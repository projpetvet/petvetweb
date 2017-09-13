<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller {
    
    private $ServiceStatus = array(
        1 => "Pending",
        2 => "Approved",
        3 => "Declined",
        4 => "Completed",
        5 => "Canceled"
    );
    
    public function __construct() 
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        $this->load->model('WebserviceModel','model');
        $this->load->model('SmsModel','sms');
    }
    
    public function index()
    {
        echo "PetVet Web Service";
    }

    public function Signin()
    {
        $json_data = array();
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            $username = $_POST['username'];
            $password = sha1($_POST['password']);

            $stmt = $this->model->AuthenticateUser($username,$password);
            if(count($stmt) > 0)
            {
                $json_data['success'] = TRUE;
                $json_data['id'] = $stmt[0]->id;
                $json_data['info'] = $stmt[0];
            }
            else
            {
                $json_data['success'] = FALSE;
                $json_data['message'] = 'Login failed';
            }
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = 'Invalid Action';
        }

        echo json_encode($json_data);
        exit;
    }
    
    public function SignInWebUser()
    {
        $json_data = array();
        $stmt = $this->model->AuthenticateWebUser($_POST['web_code']);
        if(count($stmt) > 0)
        {
            $json_data['success'] = TRUE;
            $json_data['id'] = $stmt[0]->id;
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = 'Login failed';
        }

        echo json_encode($json_data);
        exit;
    }
    
    public function Register()
    {
        $json_data = array();
        if($this->isUsernameAvailable($_POST['username']))
        {
            if($this->isNumberAvailable($_POST['mobile']))
            {
                $_POST['web_code'] = $this->generateRandomString();
                $id = $this->model->Register($_POST);
                $json_data['id'] = $id;
                if($id > 0)
                {
                    $sms_data = array();
                    $sms_data['recepient'] = $_POST['mobile'];
                    $sms_data['message'] = 'Hi '.$_POST['firstname'].', here is your account verification code: '.$_POST['web_code'];
                    $this->sms->InsertMessage($sms_data);
                    
                    $json_data['success'] = TRUE;
                }
                else
                {
                    $json_data['success'] = FALSE;
                    $json_data['message'] = "Error in inserting to the database";
                }
            }
            else
            {
                $json_data['success'] = FALSE;
                $json_data['message'] = "Mobile number already taken.";
            }
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = "Username already taken";
        }
        
        echo json_encode($json_data);
        exit;
    }
    
    public function UpdateProfile()
    {
        $json_data = array();
        if($this->isUsernameAvailable($_POST['username'],$_POST['id']))
        {
            if($this->isNumberAvailable($_POST['mobile'],$_POST['id']))
            {
                $json_data['success'] = $this->model->UpdateProfile($_POST);
                if(!$json_data['success'])
                {
                    $json_data['message'] = "Error in updating your account";
                }
            }
            else
            {
                $json_data['success'] = FALSE;
                $json_data['message'] = "Mobile number already taken by other user";
            }
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = "Username already taken by other user.";
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function GetCustomerById()
    {
        $json_data = array();
        $json_data['info'] = $this->model->GetCustomerById($_POST['id']);
        $json_data['info']['password'] = '******';
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function GetProducts()
    {
        $json_data = array();
        $json_data['list'] = array();
        $stmt = $this->model->GetProducts();
        foreach($stmt->result() as $row)
        {
            $row->description = html_entity_decode($row->description);
            
            $img = FCPATH."www/images/products/".$row->image;
            if(!file_exists($img) || (trim($row->image) == ''))
            {
                $row->image = '';
            }
            
            array_push($json_data['list'], $row);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function GetProductsByIdList()
    {
        $json_data = array();
        $json_data['list'] = array();
        $stmt = $this->model->GetProductsByIdList($_POST['ids']);
        foreach($stmt->result() as $row)
        {
            array_push($json_data['list'], $row);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function Checkout()
    {
        $json_data = array();
        $order_line = json_decode($_POST['order_line'],TRUE);
        $grandTotal = 0;
        foreach ($order_line as $key => $line)
        {
            $order_line[$key]['price'] = $this->model->GetProductPriceById($line['id']);
            $order_line[$key]['total'] = $order_line[$key]['price'] * $order_line[$key]['quantity'];
            $grandTotal += $order_line[$key]['total'];
        }
        //Adding to orders
        $_POST['grandTotal'] = $grandTotal;
        $order_id = $this->model->AddOrder($_POST);
        //Adding to order line
        if($order_id > 0)
        {
            foreach ($order_line as $key => $line)
            {
                $this->model->AddOrderLine($order_id,$line);
            }
            
            $customer_info = $this->model->GetCustomerById($_POST['customer_id']);
            $sms_data = array();
            $sms_data['recepient'] = $customer_info['mobile'];
            $sms_data['message'] = 'Hi '.$customer_info['firstname'].', thank you for the order you made with ID #'.$order_id.'. This is a confirmation that your order has been successfully received.';
            $this->sms->InsertMessage($sms_data);
            $json_data['success'] = TRUE;
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = "Error in adding order.";
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function GetOrderHistory()
    {
        $json_data = array();
        if(isset($_POST['customer_id']))
        {
            $json_data['success'] = TRUE;
            $json_data['list'] = array();
            $stmt = $this->model->GetOrderListByCustomer($_POST['customer_id']);
            foreach($stmt->result() as $row)
            {
                $row->date_added = date("M d o", strtotime($row->date_added));
                switch($row->status)
                {
                    case 1:
                        $row->status = "Pending";
                        break;
                    case 2:
                        $row->status = "On Process";
                        break;
                    case 3:
                        $row->status = "On Delivery";
                        break;
                    case 4:
                        $row->status = "Completed";
                        break;
                    case 5:
                        $row->status = "Canceled";
                        break;
                }
                
                array_push($json_data['list'], $row);
            }
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = "Invalid action.";
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function GetDataForAppointment()
    {
        $json_data = array();
        $json_data['success'] = TRUE;
        //doctors
        $json_data['doctor_list'] = array();
        $stmt = $this->model->GetDoctors();
        foreach($stmt->result() as $row)
        {
            array_push($json_data['doctor_list'], $row);
        }
        //services
        $json_data['services_list'] = array();
        $stmt = $this->model->GetServices();
        foreach($stmt->result() as $row)
        {
            $img = FCPATH."www/images/services/".$row->image;
            if(!file_exists($img) || (trim($row->image) == ''))
            {
                $row->image = '';
            }
            
            $row->description = html_entity_decode($row->description);
            array_push($json_data['services_list'], $row);
        }
        //services
        $json_data['pet_list'] = array();
        $stmt = $this->model->GetPetsByOwner($_POST['customer_id']);
        foreach($stmt->result() as $row)
        {
            array_push($json_data['pet_list'], $row);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function RequestAppointment()
    {
        $json_data = array();
        $json_data['error_code'] = '';
        if($this->CheckIfSchedIsAvailable($_POST['app_time'],$_POST['app_date']))
        {
            $id = $this->model->RequestAppointment($_POST);
            $json_data['id'] = $id;
            if($id > 0)
            {
                $services = explode(',', $_POST['selected_services']);
                $total = 0;
                foreach($services as $service_id)
                {
                    $this->model->RequestAppointmentService($id,$service_id);
                    $service_detail = $this->model->GetServiceById($service_id);
                    $total += floatval($service_detail->price);
                }
                $this->model->SetAppointmentTotal($id,$total);

                $this->model->SaveSchedule($_POST['app_time'],$id,$_POST['app_date']);
                
                $customer_info = $this->model->GetCustomerById($_POST['customer_id']);
                $sms_data = array();
                $sms_data['recepient'] = $customer_info['mobile'];
                $sms_data['message'] = 'Hi '.$customer_info['firstname'].', thank you for the appointment you made with ID #'.$id.'. This is a confirmation that your appointment request has been successfully received.';
                $this->sms->InsertMessage($sms_data);

                $json_data['success'] = TRUE;
            }
            else
            {
                $json_data['success'] = FALSE;
                $json_data['message'] = "Error in inserting to the database";
            }
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = "Time already reserved";
            $json_data['error_code'] = 'TIME_ERROR';
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function CheckIfSchedIsAvailable($app_time,$app_date)
    {
        $result = $this->model->CheckIfSchedIsAvailable($app_time,$app_date);
        if(empty($result))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function GetAppointmentByCustomerId()
    {
        $json_data = array();
        $json_data['app_list'] = array();
        $stmt = $this->model->GetAppointmentByCustomerId($_POST['customer_id']);
        foreach($stmt->result() as $row)
        {
            $row->app_date = date("M d o", strtotime($row->app_date));
            $row->app_time = $this->model->GetTimeTableById($row->app_time);
            $row->status_caption = $this->ServiceStatus[$row->status];
            array_push($json_data['app_list'], $row);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function GetAppointmentByPetId()
    {
        $json_data = array();
        $json_data['app_list'] = array();
        $stmt = $this->model->GetAppointmentByPetId($_POST['id']);
        foreach($stmt->result() as $row)
        {
            $row->app_date = date("M d o", strtotime($row->app_date));
            $row->app_time = $this->model->GetTimeTableById($row->app_time);
            $row->status_caption = $this->ServiceStatus[$row->status];
            array_push($json_data['app_list'], $row);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function GetAppointmentDetailById()
    {
        $json_data = array();
        $json_data['app_detail'] = array();
        $stmt = $this->model->GetAppointmentDetailById($_POST['id']);
        foreach($stmt->result() as $row)
        {
            $row->app_date = date("M d o", strtotime($row->app_date));
            $row->app_time = $this->model->GetTimeTableById($row->app_time);
            $row->status_caption = $this->ServiceStatus[$row->status];
            $json_data['app_detail'] = $row;
            
            $json_data['services_list'] = array();
            $stmt_service = $this->model->GetAppointmentServices($_POST['id']);
            foreach($stmt_service->result() as $row)
            {
                array_push($json_data['services_list'],$row);
            }
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function CancelAppointment()
    {
        $json_data = array();
        $json_data['success'] = $this->model->CancelAppointment($_POST['id']);
        if($json_data['success'])
        {
            $this->model->RemoveAppointmentInTimeTable($_POST['id']);
        }
        
        if(!$json_data['success'])
        {
            $json_data['message'] = "An error occured.";
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function CancelOrder()
    {
        $json_data = array();
        $json_data['success'] = $this->model->CancelOrder($_POST['id']);
        if(!$json_data['success'])
        {
            $json_data['message'] = "An error occured.";
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function GetSpecies()
    {
        $json_data = array();
        $species = $this->model->GetSpecies();
        $json_data['list'] = $species->result();
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function GetBreeds()
    {
        $json_data = array();
        $breeds = $this->model->GetBreedsBySpecieId($_POST['id']);
        $json_data['list'] = $breeds->result();
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function SavePet()
    {
        $json_data = array();
        $json_data['success'] = $this->model->SavePet($_POST);
        echo json_encode($json_data);
        exit;
    }
    
    public function GetMessages()
    {
        $json_data = array();
        $result = $this->model->GetMessages();
        if(!empty($result->result()))
        {
            $json_data['contact'] = $result->result();
        }
        else
        {
            $json_data['contact'] = array();
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function SetMessagesSent()
    {
        $json_data = array();
        if(isset($_GET['ids']))
        {
            $ids = explode(',', $_GET['ids']);
            foreach ($ids as $id)
            {
                if(trim($id) != '')
                {
                    $this->model->SetMessageSent($id);
                }
            }
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function RegisterWebUser()
    {
        $web_key = $_GET['web_key'];
        $is_registered = $this->model->CheckIfWebUserExist($web_key);
        if(empty($is_registered))
        {
            $this->model->RegisterWebUser($_GET);
            $this->SetVerificationCode($web_key);
        }
        else
        {
            $this->SetVerificationCode($web_key);
        }
    }
    
    public function SetVerificationCode($web_key)
    {
        $web_code = $this->generateRandomString();
        $this->model->SetVerificationKey($web_key,$web_code);
        $this->load->view('Signin/Success',array("web_code" => $web_code));
    }
    
    public function generateRandomString($length = 5) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function GetTimeTable()
    {
        $sched_date = $_POST['sched_date'];
        $date_now = date('Y-m-d');
        $json_data = array();
        if(strtotime($date_now) > strtotime($sched_date))
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = 'Invalid date!';
        }
        else if(date('Y', strtotime($date_now)) != date('Y', strtotime($sched_date)))
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = 'Invalid year! You may only make an appointment this year';
        }
        else
        {
            $json_data['sched'] = array();
            $stmt = $this->model->GetTimeTable($sched_date);
            foreach ($stmt->result() as $row)
            {
                if($row->ttaid == '')
                {
                    array_push($json_data['sched'], $row);
                }
            }

            $json_data['success'] = TRUE;
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function GetMyPets()
    {
        $json_data = array();
        $json_data['list'] = $this->model->GetPetsFullDetailsByOwner($_POST['customer_id']);
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function isUsernameAvailable($username,$id = null)
    {
        $is_exist = $this->model->CheckIfUsernameExist($username,$id);
        if(!empty($is_exist->result()))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function isNumberAvailable($mobile,$id = null)
    {
        $is_exist = $this->model->CheckIfNumberExist($mobile, $id);
        if(!empty($is_exist->result()))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function IsStockSufficient()
    {
        $id = $_POST['id'];
        $quantity = $_POST['quantity'];
        $stock = $this->model->CheckStock($id);
        $json_data = array();
        $json_data['current_stock'] = $stock;
        $json_data['success'] = TRUE;
        if($stock >= $quantity )
        {
            $json_data['sufficient'] = TRUE;
        }
        else
        {
            $json_data['sufficient'] = FALSE;
        }
        
        echo json_encode($json_data);
        exit;
    }
    
    public function VerifyAccount()
    {
        $id = $_POST['id'];
        $json_data = array();
        $json_data['id'] = $id;
        $json_data['success'] = $this->model->VerifyAccount($id);
        echo json_encode($json_data);
        exit;
    }
    
    public function ResendVerificationCode()
    {
        $id = $_POST['id'];
        $json_data = array();
        $code = $this->generateRandomString();
        $json_data['success'] = $this->model->ResetVerificationCode($id,$code);
        
        $customer_info = $this->model->GetCustomerById($id);
        $sms_data = array();
        $sms_data['recepient'] = $customer_info['mobile'];
        $sms_data['message'] = 'Hi '.$customer_info['firstname'].', here is your account verification code: '.$code;
        $this->sms->InsertMessage($sms_data);
        
        echo json_encode($json_data);
        exit;
    }
}
