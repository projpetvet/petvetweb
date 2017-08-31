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
    
    public function Register()
    {
        $json_data = array();
        $id = $this->model->Register($_POST);
        $json_data['id'] = $id;
        if($id > 0)
        {
            $json_data['success'] = TRUE;
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = "Error in inserting to the database";
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function UpdateProfile()
    {
        $json_data = array();
        $json_data['success'] = $this->model->UpdateProfile($_POST);
        if(!$json_data['success'])
        {
            $json_data['message'] = "Error in updating your account";
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
            $json_data['success'] = TRUE;
        }
        else
        {
            $json_data['success'] = FALSE;
            $json_data['message'] = "Error in inserting to the database";
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function GetAppointmentByCustomerId()
    {
        $json_data = array();
        $json_data['app_list'] = array();
        $stmt = $this->model->GetAppointmentByCustomerId($_POST['customer_id']);
        foreach($stmt->result() as $row)
        {
            $row->app_date = date("M d o", strtotime($row->app_date));
            $row->app_time = date("h:i a", strtotime($row->app_time));
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
            $row->app_time = date("h:i a", strtotime($row->app_time));
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
}
