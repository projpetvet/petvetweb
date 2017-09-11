<?php
class Admin extends CI_Controller {
    private $status_caption = array(
        1  => "Pending",
        2  => "On Process",
        3  => "On Delivery",
        4  => "Completed",
        5  => "Canceled"
    );
    
    private $app_status_caption = array(
        1  => "Pending",
        2  => "Approved",
        3  => "Declined",
        4  => "Completed",
        5  => "Canceled"
    );
    
    private $months = array(
        1  => "Jan",
        2  => "Feb",
        3  => "Mar",
        4  => "Apr",
        5  => "May",
        6  => "Jun",
        7  => "Jul",
        8  => "Aug",
        9  => "Sept",
        10  => "Oct",
        11  => "Nov",
        12  => "Dec",
    );
    
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $data = array();
        $this->load->helper('url');
        $this->load->model('Petvet_model','model');
        $this->load->model('SmsModel','sms');
        $this->load->helper('form');

        $path = explode("/", $_SERVER['PATH_INFO']);
    }

    public function hello() {
        $args = $GLOBALS['params'];
        echo $_SERVER['PATH_INFO'];
        var_dump($args);
    }

    public function logIn() {
        $data = array();
        $data = $this->model->checkUserAdmin($_POST);
        foreach ($data as $user) {
            $row = (array) $user;
            $this->session->set_userdata('uname', $row["username"]);
        }
        echo json_encode($data);
        exit;
    }

    public function unsetSession() {
        $this->session->unset_userdata("uname");
        exit;
    }

    public function index($args = array())
    {
        $this->load->view('Login');
    }

    public function products() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['products_list'] = $this->getProductsList();
            $this->load->view('Header', $data);
            $this->load->view('Products', $data);
            $this->load->view('Footer', $data);
        }
    }
    
    public function ProductCategories() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['category_list'] = $this->GetProductCategoriesList();
            $this->load->view('Header', $data);
            $this->load->view('ProductCategories', $data);
            $this->load->view('Footer', $data);
        }
    }
    
    public function ServiceCategories() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['category_list'] = $this->GetServiceCategoriesList();
            $this->load->view('Header', $data);
            $this->load->view('ServiceCategories', $data);
            $this->load->view('Footer', $data);
        }
    }

    public function getProductsList() {
        $products = '';
        $productdetails = array();
        $productdetails = $this->model->getProductDetails();
        foreach ($productdetails->result() as $row) {
            $data = (array) $row;
            $img = FCPATH."www/images/products/".$data['image'];
            if(!file_exists($img) || (trim($data['image']) == ''))
            {
                $data['image'] = 'logo.png';
            }
            
            $products .= $this->load->view('lists/products', $data, true);
        }
        return $products;
    }
    
    public function GetProductCategoriesList() {
        $products = '';
        $result = $this->model->GetProductCategories();
        foreach ($result->result() as $row) 
        {   
            $products .= $this->load->view('lists/productcategories', $row, true);
        }
        return $products;
    }
    
    public function GetServiceCategoriesList() {
        $products = '';
        $result = $this->model->GetServiceCategories();
        foreach ($result->result() as $row) 
        {   
            $products .= $this->load->view('lists/servicecategories', $row, true);
        }
        return $products;
    }

    public function services() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['services_list'] = $this->getServicesList();
            $this->load->view('Header', $data);
            $this->load->view('Services', $data);
            $this->load->view('Footer', $data);
        }
    }

    public function getServicesList() {
        $services = '';
        $servicesdetails = array();
        $servicesdetails = $this->model->getServicesDetails();
        foreach ($servicesdetails->result() as $row) {
            $data = (array) $row;
            $img = FCPATH."www/images/services/".$data['image'];
            if(!file_exists($img) || (trim($data['image']) == ''))
            {
                $data['image'] = 'logo.png';
            }
            $services .= $this->load->view('lists/services', $data, true);
        }
        return $services;
    }

    public function doctors() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['doctors_list'] = $this->getDoctorsList();
            $this->load->view('Header', $data);
            $this->load->view('Doctors', $data);
            $this->load->view('Footer', $data);
            
        }
    }

    public function getDoctorsList() {
        $doctors = '';
        $doctorsdetails = array();
        $doctorsdetails = $this->model->getDoctorDetails();
        foreach ($doctorsdetails->result() as $row) {
            $data = (array) $row;
            $doctors .= $this->load->view('lists/doctors', $data, true);
        }
        return $doctors;
    }

    public function members() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['members_list'] = $this->getMembersList();
            $this->load->view('Header', $data);
            $this->load->view('Members', $data);
            $this->load->view('Footer', $data);
        }
    }

    public function getMembersList() {
        $members = '';
        $memberdetails = array();
        $memberdetails = $this->model->getMemberDetails();
        foreach ($memberdetails->result() as $row) {
            $data = (array) $row;
            $members .= $this->load->view('lists/members', $data, true);
        }
        return $members;
    }

    public function pets() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['species_list'] = $this->getSpeciesList();
            $data['owners_list'] = $this->getOwnersList();
            $data['pets_list'] = $this->getPetsList();       
            $this->load->view('Header', $data);
            $this->load->view('Pets', $data);
            $this->load->view('Footer', $data);
        }
    }

    public function getPetsList() {
        $pets = '';
        $petdetails = array();
        $petdetails = $this->model->getPetDetails();
        foreach ($petdetails->result() as $row) {
            $data = (array) $row;
            $pets .= $this->load->view('lists/pets', $data, true);
        }
        return $pets;
    }

    public function addnewuser() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $this->load->view('Header', $data);
            $this->load->view('AddNewUserAdmin',$data);
            $this->load->view('Footer', $data);
        }
    }

    public function useradmin() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['users_list'] = $this->getUsersList();
            $this->load->view('Header', $data);
            $this->load->view('UserAdmin', $data);
            $this->load->view('Footer', $data);
        }
    }

    public function getUsersList() {
        $users = '';
        $userdetails = array();
        $userdetails = $this->model->getUserDetails();
        foreach ($userdetails->result() as $row) {
            $data = (array) $row;
            $users .= $this->load->view('lists/users', $data, true);
        }
        return $users;
    }

    public function AddNewMember() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $this->load->view('Header', $data);
            $this->load->view('AddNewMember', $data);
            $this->load->view('Footer', $data);
        }
    }

    public function saveNewMember() {
        $data = array();
        $data = $this->model->saveMember($_POST);
        echo json_encode($data);
        exit;
    }

    public function removeMember() {
        $data = array();
        $data = $this->model->deleteMember($_POST);
        echo json_encode($data);
        exit;
    }

    public function getMembersDetails() {
        $data = array();
        $data = $this->model->getMemberInfo($_POST);
        echo json_encode($data);
        exit;
    }

    public function updateMember() {
        $data = array();
        $data = $this->model->updateMemberDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function AddNewProduct() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['product_category_list'] = $this->BuildProductCategories();
            $this->load->view('Header');
            $this->load->view('AddNewProduct',$data);
            $this->load->view('Footer');
        }
    }
    
    public function BuildProductCategories($selected = 0)
    {
        $options = '<option value="">(Select Product Category)</option>';
        $stmt = $this->model->GetProductCategories();
        foreach ($stmt->result() as $row)
        {
            if($row->id == $selected)
            {
                $options .= '<option value="'.$row->id.'" selected>'.$row->name.'</option>';
            }
            else
            {
                $options .= '<option value="'.$row->id.'">'.$row->name.'</option>';
            }
        }
        return $options;
    }
    
    public function BuildServiceCategories($selected = 0)
    {
        $options = '<option value="">(Select Service Category)</option>';
        $stmt = $this->model->GetServiceCategories();
        foreach ($stmt->result() as $row)
        {
            if($row->id == $selected)
            {
                $options .= '<option value="'.$row->id.'" selected>'.$row->name.'</option>';
            }
            else
            {
                $options .= '<option value="'.$row->id.'">'.$row->name.'</option>';
            }
        }
        return $options;
    }

    public function AddNewProductCategory() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            if(isset($_SESSION['message']))
            {
                $data['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            else
            {
                $data['message'] = '';
            }
            $this->load->view('Header');
            $this->load->view('AddNewProductCategory',$data);
            $this->load->view('Footer');
        }
    }
    
    public function EditProductCategory() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            if(isset($GLOBALS['params'][0]))
            {
                $data = array();
                $id = $GLOBALS['params'][0];
                $stmt = $this->model->GetProductCategoryById($id);
                foreach($stmt->result() as $row)
                {
                    $data['id'] = $row->id;
                    $data['name'] = $row->name;
                    $data['description'] = $row->description;
                }
                
                if(isset($_SESSION['message']))
                {
                    $data['message'] = $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                else
                {
                    $data['message'] = '';
                }
                $this->load->view('Header');
                $this->load->view('EditProductCategory',$data);
                $this->load->view('Footer');
            }
            else
            {
                header("location : /admin/productCategories");
            }
        }
    }

    public function saveProduct() {
        $config['upload_path'] = './www/images/products/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['max_width'] = 5000;
        $config['max_height'] = 5000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile') || $_POST['productName'] == "" || $_POST['productPrice'] == "" || $_POST['productStock'] == "") {
            $error = array('error' => "<div class='alert alert-warning errmess' role='alert'><center>Please enter valid information. Try again.</center></div>");
            
            $this->load->view('Header');
            $this->load->view('AddNewProduct', $error);
            $this->load->view('Footer');
        } else {
            $success = array('error' => "<div class='alert alert-success errmess' role='alert'><center>New product successfully added.</center></div>");
            $this->load->view('Header');
            $this->load->view('AddNewProduct', $success);
            $this->load->view('Footer');
            $upload = array();
            $upload = $this->model->saveProductDetails($_POST,$this->upload->file_name);
        }
    }

    public function saveService() {
        $config['upload_path'] = './www/images/services/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['max_width'] = 5000;
        $config['max_height'] = 5000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile') || $_POST['serviceName'] == "" || $_POST['serviceDescription'] == "" || $_POST['servicePrice'] == "") {
            $_SESSION['message'] = "<div class='alert alert-warning errmess' role='alert'><center>Please enter valid information. Try again.</center></div>";
            header("location: /admin/AddNewService/");
        } else {
            $_SESSION['message'] = "<div class='alert alert-success errmess' role='alert'><center>New service successfully added.</center></div>";           
            $this->model->saveServiceDetails($_POST, $this->upload->file_name);
            header("location: /admin/AddNewService/");
        }
    }

    public function updateService() {
        $config['upload_path'] = './www/images/services/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['max_width'] = 5000;
        $config['max_height'] = 5000;

        $this->load->library('upload', $config);
        if(trim($_FILES['userfile']['tmp_name']) != '')
        {
            $this->upload->do_upload('userfile');
            $this->model->updateServiceImage($_POST['edit_id'], $this->upload->file_name);
        }

        if ($_POST['editServiceName'] == "" || $_POST['editServiceDescription'] == "" || $_POST['editServicePrice'] == "") {
            $_SESSION['message'] = "<div class='alert alert-warning errmess' role='alert'><center>Please enter valid information. Try again.</center></div>";
            header("location: /admin/EditService/".$_POST['edit_id']);
        } else {
            $_SESSION['message'] = "<div class='alert alert-success errmess' role='alert'><center>Service successfully updated.</center></div>";
            $this->model->updateServiceDetails($_POST);
            header("location: /admin/EditService/".$_POST['edit_id']);
        }
    }
    
    public function updateProduct() {
        $config['upload_path'] = './www/images/products/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['max_width'] = 5000;
        $config['max_height'] = 5000;

        $this->load->library('upload', $config);
        
        if(trim($_FILES['userfile']['tmp_name']) != '')
        {
            $this->upload->do_upload('userfile');
            $this->model->updateProductImage($_POST['edit_id'], $this->upload->file_name);
        }

        if ($_POST['editProductName'] == "" || $_POST['editProductDescription'] == "" || $_POST['editProductPrice'] == "") {
            $_SESSION['message'] = "<div class='alert alert-warning errmess' role='alert'><center>Please enter valid information. Try again.</center></div>";
            header("location: /admin/EditProduct/".$_POST['edit_id']);
        } else {
            $_SESSION['message'] = "<div class='alert alert-success errmess' role='alert'><center>Product successfully updated.</center></div>";
            $this->model->updateProductDetails($_POST);
            header("location: /admin/EditProduct/".$_POST['edit_id']);
        }
    }

    public function removeProduct() {
        $data = array();
        $data = $this->model->deleteProduct($_POST);
        echo json_encode($data);
        exit;
    }

    public function AddNewDoctor() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $this->load->view('Header');
            $this->load->view('AddNewDoctor');
            $this->load->view('Footer');
        }
    }

    public function AddNewService() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['service_category_list'] = $this->BuildServiceCategories();
            if(isset($_SESSION['message']))
            {
                $data['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            else
            {
                $data['message'] = '';
            }
            $this->load->view('Header');
            $this->load->view('AddNewService',$data);
            $this->load->view('Footer');
        }
    }

    public function AddNewPet() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data['species_list'] = $this->getSpeciesList();
            $data['owners_list'] = $this->getOwnersList();
            $this->load->view('Header');
            $this->load->view('AddNewPet', $data);
            $this->load->view('Footer');
        }
    }

    public function getOwnersList() {
        $owners = '';
        $ownerdetails = array();
        $ownerdetails = $this->model->getOwnerDetails();
        foreach ($ownerdetails->result() as $row) {
            $data = (array) $row;
            $owners .= $this->load->view('lists/owners', $data, true);
        }
        return $owners;
    }

    public function getSpeciesList() {
        $specie = '';
        $speciedetails = array();
        $speciedetails = $this->model->getSpecieDetails();
        foreach ($speciedetails->result() as $row) {
            $data = (array) $row;
            $specie .= $this->load->view('lists/species', $data, true);
        }
        return $specie;
    }

    public function AddNewUserAdmin() {
        $data = array();
        $data = $this->model->AddNewUserAdminDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function AddNewDoctorDetails() {
        $data = array();
        $data = $this->model->insertDoctorDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function removeDoctor() {
        $data = array();
        $data = $this->model->deleteDoctorDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function getDoctorDetails() {
        $data = array();
        $data = $this->model->selectDoctorDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function updateDoctor() {
        $data = array();
        $data = $this->model->updateDoctorDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function getBreed() {
        $data = array();
        $data = $this->model->getBreedDetails($_POST);
        echo json_encode($data);
        exit;
    }
    
    public function getBreedBySpecieId() {
        $data = array();
        $data = $this->model->getBreedBySpecieId($_POST['specie_id']);
        echo json_encode($data);
        exit;
    }

    public function saveNewPet() {
        $data = array();
        $data = $this->model->AddNewPetDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function getOwnersFullName() {
        $data = array();
        $data = $this->model->getOwnersFullNameDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function removePet() {
        $data = array();
        $data = $this->model->removePetDetails($_POST);
        echo json_encode($data);
        exit;
    }

    public function getMembersDetailsForView() {
        $data = array();
        $data = $this->model->getMembersDetailsAndPets($_POST);
        echo json_encode($data);
        exit;
    }

    public function removeService() {
        $data = array();
        $data = $this->model->deleteService($_POST);
        echo json_encode($data);
        exit;
    }

    public function editService() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['edit_id'] = $GLOBALS['params'][0];
            $data['service_category_list'] = $this->BuildServiceCategories();
            if(isset($_SESSION['message']))
            {
                $data['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            else
            {
                $data['message'] = '';
            }
            $this->load->view('Header');
            $this->load->view('EditService',$data);
            $this->load->view('Footer');
        }
    }

    public function editProduct() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['edit_id'] = $GLOBALS['params'][0];
            $data['product_category_list'] = $this->BuildProductCategories();
            if(isset($_SESSION['message']))
            {
                $data['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            else
            {
                $data['message'] = '';
            }
            $this->load->view('Header');
            $this->load->view('EditProduct',$data);
            $this->load->view('Footer');
        }
    }

    public function getEditServiceDetails() {
        $data = array();
        $data = $this->model->getServiceEditDetails($_POST);
        $data['decoded'] = html_entity_decode($data[0]->description);
        $img = FCPATH."www/images/services/".$data[0]->image;
        if(!file_exists($img) || (trim($data[0]->image) == ''))
        {
            $data[0]->image = 'logo.png';
        }
        echo json_encode($data);
        exit;
    }

    public function getEditProductDetails() {
        $data = array();
        $data = $this->model->getProductEditDetails($_POST);
        $data['decoded'] = html_entity_decode($data[0]->description);
        $img = FCPATH."www/images/products/".$data[0]->image;
        if(!file_exists($img) || (trim($data[0]->image) == ''))
        {
            $data[0]->image = 'logo.png';
        }
        echo json_encode($data);
        exit;
    }
    
    public function Orders()
    {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['list'] = '';
            
            $selected_status = 0;
            if(isset($GLOBALS['params'][0]))
            {
                $selected_status = $GLOBALS['params'][0];
            }
            $data['status_list'] = $this->BuildOrderStatus($selected_status);
            
            $stmt = $this->model->GetOrders($selected_status);
            foreach ($stmt->result() as $row)
            {
                $row->date_added = date("M d o", strtotime($row->date_added));
                $row->status_caption = $this->status_caption[$row->status];
                $data['list'] .= $this->load->view("OrderList",$row,TRUE);
            }
            
            $this->load->view('Header');
            $this->load->view('Orders',$data);
            $this->load->view('Footer');
        }
    }
    
    public function BuildOrderStatus($selected = 0)
    {
        $options = '<option value="">All Status</option>';
        foreach($this->status_caption as $key => $caption)
        {
            if($key == $selected)
            {
                $options .= '<option value="'.$key.'" selected>'.$caption.'</option>';
            }
            else
            {
                $options .= '<option value="'.$key.'">'.$caption.'</option>';
            }
        }
        return $options;
    }
    
    public function viewOrder()
    {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            if(isset($GLOBALS['params'][0]))
            {
                $id = $GLOBALS['params'][0];
                $data = array();
                $stmt = $this->model->GetOrderById($id);
                $result = $stmt->result()[0];
                $result->date_added = date("M d o", strtotime($result->date_added));
                $result->status_caption = $this->BuildOrderStatusSelection($id,$result->status);
                $data = array_merge($data, (array) $result);
                $data['list'] = '';
                
                $order_line = $this->model->GetOrderLineByOrderId($id);
                foreach ($order_line->result() as $ol)
                {
                    $data['list'] .= $this->load->view("OrderViewList",$ol,TRUE);
                }

                $this->load->view('Header');
                $this->load->view('OrderView',$data);
                $this->load->view('Footer');
            }
            else
            {
                header("location: /admin/orders");
            }
        }
    }
    
    public function BuildOrderStatusSelection($order_id,$selected)
    {
        $options = "<select id='orderStatus' class='form-control' data-value='$selected' data-order='$order_id'>";
        foreach($this->status_caption as $key => $caption)
        {
            if($key == $selected)
            {
                $options .= "<option value='$key' selected>$caption</option>";
            }
            else
            {
                $options .= "<option value='$key'>$caption</option>";
            }
        }
        $options .= "</select>";
        return $options;
    }
    
    public function BuildAppStatusSelection($order_id,$selected)
    {
        $options = "<select id='appStatus' class='form-control' data-value='$selected' data-app='$order_id'>";
        foreach($this->app_status_caption as $key => $caption)
        {
            if($key == $selected)
            {
                $options .= "<option value='$key' selected>$caption</option>";
            }
            else
            {
                $options .= "<option value='$key'>$caption</option>";
            }
        }
        $options .= "</select>";
        return $options;
    }
    
    public function changeOrderStatus()
    {
        $json_data = array();
        $json_data['success'] = $this->model->ChangeOrderStatus($_POST['order_id'],$_POST['status']);
        //COMPLETED - deducts the items of products
        if($_POST['status'] == 4)
        {
            $products = $this->model->GetOrderLineByOrderId($_POST['order_id']);
            foreach ($products->result() as $prod)
            {
                $this->model->UpdateProductStock($prod->product_id,$prod->quantity);
            }
        }
        
        $customer_id = $this->model->GetOrderCustomerById($_POST['order_id']);
        $customer_info = $this->model->GetCustomerById($customer_id);
        $sms_data = array();
        $sms_data['recepient'] = $customer_info['mobile'];
        $sms_data['message'] = 'Hi '.$customer_info['firstname'].', your order with ID #'.$_POST['order_id'].' is now '.$this->status_caption[$_POST['status']].'.';
        $this->sms->InsertMessage($sms_data);
        
        echo json_encode($json_data);
        exit;
    }
    
    public function changeAppointmentStatus()
    {
        $json_data = array();
        $json_data['success'] = $this->model->ChangeAppointmentStatus($_POST['app_id'],$_POST['status']);
        
        $customer_id = $this->model->GetAppointmentCustomerById($_POST['app_id']);
        $customer_info = $this->model->GetCustomerById($customer_id);
        $sms_data = array();
        $sms_data['recepient'] = $customer_info['mobile'];
        $sms_data['message'] = 'Hi '.$customer_info['firstname'].', your appointment with ID #'.$_POST['app_id'].' is now '.$this->app_status_caption[$_POST['status']].'.';
        $this->sms->InsertMessage($sms_data);
        
        echo json_encode($json_data);
        exit;
    }

    public function Appointments()
    {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            
            $selected_status = 0;
            if(isset($GLOBALS['params'][0]))
            {
                $selected_status = $GLOBALS['params'][0];
            }
            $data['status_list'] = $this->BuildAppointmentStatus($selected_status);
            
            $data['list'] = '';
            $stmt = $this->model->GetAppointments($selected_status);
            foreach ($stmt->result() as $row)
            {
                $row->app_date = date("M d o", strtotime($row->app_date));
                $row->app_time = date("h:i a", strtotime($row->app_time));
                $row->status_caption = $this->app_status_caption[$row->status];
                $data['list'] .= $this->load->view("AppointmentList",$row,TRUE);
            }
            
            $this->load->view('Header');
            $this->load->view('Appointments',$data);
            $this->load->view('Footer');
        }
    }
    
    public function BuildAppointmentStatus($selected = 0)
    {
        $options = '<option value="">All Status</option>';
        foreach($this->app_status_caption as $key => $caption)
        {
            if($key == $selected)
            {
                $options .= '<option value="'.$key.'" selected>'.$caption.'</option>';
            }
            else
            {
                $options .= '<option value="'.$key.'">'.$caption.'</option>';
            }
        }
        return $options;
    }
    
    public function viewAppointment()
    {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            if(isset($GLOBALS['params'][0]))
            {
                $id = $GLOBALS['params'][0];
                $data = array();
                $stmt = $this->model->GetAppointmentById($id);
                $result = $stmt->result()[0];
                $result->app_date = date("M d o", strtotime($result->app_date));
                $result->app_time = date("h:i a", strtotime($result->app_time));
                $result->status_caption = $this->BuildAppStatusSelection($id,$result->status);
                $data = array_merge($data, (array) $result);
                $data['list'] = '';
                
                $line = $this->model->GetAppointmentLineByAppId($id);
                foreach ($line->result() as $l)
                {
                    $data['list'] .= $this->load->view("AppointmentViewList",$l,TRUE);
                }

                $this->load->view('Header');
                $this->load->view('AppointmentView',$data);
                $this->load->view('Footer');
            }
            else
            {
                header("location: /admin/orders");
            }
        }
    }

    public function getPetData()
    {
        $id = $_POST['id'];
        $json_data = array(); 
        $json_data['info'] = $this->model->getPetData($id);
        echo json_encode($json_data);
        exit;
    }
    
    public function updatePetData()
    {
        $json_data = array();
        $json_data['success'] = $this->model->updatePetData($_POST);
        echo json_encode($json_data);
        exit;
    }
    
    public function updateUser()
    {
        $json_data = array();
        $json_data['success'] = $this->model->updateUser($_POST);
        echo json_encode($json_data);
        exit;
    }
    
    public function DeleteUser()
    {
        $json_data = array();
        $json_data['success'] = $this->model->DeleteUser($_POST['id']);
        echo json_encode($json_data);
        exit;
    }
    
    public function EditUser()
    {
        $id = $GLOBALS['params'][0];
        $data = $this->model->GetUserById($id);
        $this->load->view('Header');
        $this->load->view('EditUserAdmin',$data);
        $this->load->view('Footer');
    }    
    
    public function Species()
    {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['list'] = '';
            $stmt = $this->model->GetSpecies();
            foreach ($stmt->result() as $row)
            {
                $data['list'] .= $this->load->view("SpeciesList",$row,TRUE);
            }
            
            $this->load->view('Header');
            $this->load->view('Species',$data);
            $this->load->view('Footer');
        }
    }
    
    public function AddSpecie() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $this->load->view('Header');
            $this->load->view('AddSpecie');
            $this->load->view('Footer');
        }
    }
    
    public function saveSpecie() {
        $json_data = array();
        $json_data['success'] = $this->model->SaveSpecie($_POST['specie']);
        echo json_encode($json_data);
        exit;
    }
    
    public function UpdateSpecie()
    {
        $json_data = array();
        if(isset($_POST['id']) && isset($_POST['name']))
        {
            $json_data['success'] = $this->model->UpdateSpecie($_POST);
        }
        else
        {
            $json_data['success'] = FALSE;
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function DeleteSpecie()
    {
        $json_data = array();
        if(isset($_POST['id']))
        {
            $json_data['success'] = $this->model->DeleteSpecie($_POST['id']);
        }
        else
        {
            $json_data['success'] = FALSE;
        }
        echo json_encode($json_data);
        exit;
    }
    public function Breeds()
    {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            
            $selected = 0;
            if(isset($GLOBALS['params'][0]))
            {
                $selected = $GLOBALS['params'][0];
            }
            $data['specie_list'] = $this->BuildSpecies($selected);
            
            $data['list'] = '';
            $stmt = $this->model->GetBreeds($selected);
            foreach ($stmt->result() as $row)
            {
                $data['list'] .= $this->load->view("BreedsList",$row,TRUE);
            }
            
            $this->load->view('Header');
            $this->load->view('Breeds',$data);
            $this->load->view('Footer');
        }
    }
    
    public function AddBreed() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['specie_list'] = $this->BuildSpeciesSelection();
            $this->load->view('Header');
            $this->load->view('AddBreed',$data);
            $this->load->view('Footer');
        }
    }
    
    public function EditBreed() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $id = 0;
            if(isset($GLOBALS['params'][0]))
            {
                $id = $GLOBALS['params'][0];
            }
            
            $breed = $this->model->GetBreed($id);
            $breed_data = $breed->result()[0];
            $data['name'] = $breed_data->name;
            $data['id'] = $breed_data->id;
            $data['specie_list'] = $this->BuildSpeciesSelection($breed_data->specie_id);
            $this->load->view('Header');
            $this->load->view('EditBreed',$data);
            $this->load->view('Footer');
        }
    }
    
    public function saveBreed() {
        $json_data = array();
        $json_data['success'] = $this->model->SaveBreed($_POST);
        echo json_encode($json_data);
        exit;
    }
    
    public function UpdateBreed()
    {
        $json_data = array();
        if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['specie']))
        {
            $json_data['success'] = $this->model->UpdateBreed($_POST);
        }
        else
        {
            $json_data['success'] = FALSE;
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function DeleteBreed()
    {
        $json_data = array();
        if(isset($_POST['id']))
        {
            $json_data['success'] = $this->model->DeleteBreed($_POST['id']);
        }
        else
        {
            $json_data['success'] = FALSE;
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function BuildSpecies($selected = 0)
    {
        $options = '<option value="">All Species</option>';
        $stmt = $this->model->GetSpecies();
        foreach($stmt->result() as $row)
        {
            if($selected == $row->id)
            {
                $options .= '<option value="'.$row->id.'" selected>'.$row->name.'</option>';
            }
            else
            {
                $options .= '<option value="'.$row->id.'">'.$row->name.'</option>';
            }
        }
        return $options;
    }
    
    public function BuildSpeciesSelection($selected = 0)
    {
        $options = '<option value=""></option>';
        $stmt = $this->model->GetSpecies();
        foreach($stmt->result() as $row)
        {
            if($selected == $row->id)
            {
                $options .= '<option value="'.$row->id.'" selected>'.$row->name.'</option>';
            }
            else
            {
                $options .= '<option value="'.$row->id.'">'.$row->name.'</option>';
            }
        }
        return $options;
    }
    
    public function Overview()
    {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            $data['current_month'] = date('m');
            $data['years'] = $this->BuildYears();
            $this->load->view('Header');
            $this->load->view('Overview/Overview',$data);
            $this->load->view('Footer');
        }
    }
    
    public function BuildYears()
    {
        $options = '<option value="">Select Year</option>';
        $current_year = date('Y');
        $years_app = $this->model->GetAppointmentYears();
        $years_order = $this->model->GetOrderYears();
        
        $all_years = array();
        foreach ($years_app->result() as $y)
        {
            if(!in_array($y->years,$all_years))
            {
                array_push($all_years, $y->years);
            }
        }
        
        foreach ($years_order->result() as $y)
        {
            if(!in_array($y->years,$all_years))
            {
                array_push($all_years, $y->years);
            }
        }
        
        rsort($all_years);
        
        foreach ($all_years as $y)
        {
            if($current_year == $y)
            {
                $options .= '<option value="'.$y.'" selected>'.$y.'</option>';
            }
            else
            {
                $options .= '<option value="'.$y.'">'.$y.'</option>';
            }
        }
        return $options;
    }
    
    public function GetReportByMonth()
    {
        $json_data = array();
        $date_from = date('Y-m-d',strtotime($_POST['year'].'-'.$_POST['month'].'-1'));
        $date_to = date("Y-m-t", strtotime($date_from));
        
        $json_data['title'] = "Monthly Report";
        $json_data['subTitle'] = "From: ".date('m/d/Y',strtotime($date_from))." To: ".date('m/d/Y',strtotime($date_to));
        
        $json_data['columns'] = array();
        $json_data['columns'][0] = array('string', 'Weeks');
        $json_data['columns'][1] = array('number', 'Sales');
        $json_data['columns'][2] = array('number', 'Appointments');
        
        $json_data['content'] = array();
        
        $start_date = $date_from;
        $end_date = $date_to;
        $week_counter = 1;
        for($date = $start_date; $date <= $end_date; $date = date('Y-m-d', strtotime($date. ' + 7 days')))
        {
            $week_data = $this->getWeekDates($date, $start_date, $end_date);
            $week_content = array();
            $week_content[0] = "Week ".$week_counter;
            $week_content[1] = floatval($this->model->GetOrderTotalByDateRange($week_data['from'],$week_data['to']));
            $week_content[2] = floatval($this->model->GetAppointmentTotalByDateRange($week_data['from'],$week_data['to']));
            $week_counter++;
            array_push($json_data['content'], $week_content);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }

    public function getWeekDates($date, $start_date, $end_date)
    {
        $week =  date('W', strtotime($date));
        $year =  date('Y', strtotime($date));
        $from = date("Y-m-d", strtotime("{$year}-W{$week}")); //Returns the date of monday in week
            if($from < $start_date) $from = $start_date;
        $to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
            if($to > $end_date) $to = $end_date;
        
        $week_data = array();
        $week_data['from'] = $from;
        $week_data['to'] = $to;
        return $week_data;
    }
    
    public function GetReportByYear()
    {
        $json_data = array();
        
        $json_data['title'] = "Yearly Report (".$_POST['year'].')';
        $json_data['subTitle'] = "From: January ".$_POST['year']." To: December ".$_POST['year'];
        
        $json_data['columns'] = array();
        $json_data['columns'][0] = array('string', 'Months');
        $json_data['columns'][1] = array('number', 'Sales');
        $json_data['columns'][2] = array('number', 'Appointments');
        
        $json_data['content'] = array();
        
        foreach ($this->months as $key => $m)
        {
            $date_from = date('Y-m-d',strtotime($_POST['year'].'-'.$key.'-1'));
            $date_to = date("Y-m-t", strtotime($date_from));
            $content = array();
            $content[0] = $m;
            $content[1] = floatval($this->model->GetOrderTotalByDateRange($date_from,$date_to));
            $content[2] = floatval($this->model->GetAppointmentTotalByDateRange($date_from,$date_to));
            array_push($json_data['content'], $content);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function GetReportByWeek()
    {
        $week_data = explode('-', $_POST['week']);
        $year = $week_data[0];
        $week = $week_data[1];
        $week = ltrim($week, 'W');

        $date_from = date('Y-m-d', strtotime($year."W".str_pad($week,2,"0",STR_PAD_LEFT)));
        $date_to =  date('Y-m-d', strtotime("+6 days", strtotime($date_from)));
        
        $json_data = array();
        
        $json_data['title'] = "Weekly Report";
        $json_data['subTitle'] = 'From: '.date('m/d/Y', strtotime($date_from)).' To: '.date('m/d/Y', strtotime($date_to));
        
        $json_data['columns'] = array();
        $json_data['columns'][0] = array('string', 'Days');
        $json_data['columns'][1] = array('number', 'Sales');
        $json_data['columns'][2] = array('number', 'Appointments');
        
        $json_data['content'] = array();
        
        $begin = new DateTime( $date_from );
        $end   = new DateTime( $date_to );

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $day = $i->format("Y-m-d");
            $date_from = date('Y-m-d', strtotime($day));
            $date_to = $date_from;
            $content = array();
            $content[0] = date('m/d/Y', strtotime($date_from));
            $content[1] = floatval($this->model->GetOrderTotalByDay($date_from,$date_to));
            $content[2] = floatval($this->model->GetAppointmentTotalByDay($date_from,$date_to));
            array_push($json_data['content'], $content);
        }
        
        $json_data['success'] = TRUE;
        echo json_encode($json_data);
        exit;
    }
    
    public function SaveProductCategory()
    {
        if(isset($_POST['name']) && isset($_POST['description']))
        {
            $_POST['description'] = htmlentities($_POST['description']);
            $ret = $this->model->SaveProductCategory($_POST);
            if($ret)
            {
                $_SESSION['message'] = $this->SuccessMessage('Product category successfully added.');
            }
            else
            {
                $_SESSION['message'] = $this->ErrorMessage('Error saving to the database.');
            }
        }
        else
        {
            $_SESSION['message'] = $this->ErrorMessage('There are missing fields.');
        }
        
        header('Location: /admin/AddNewProductCategory');
        
    }
    
    public function updateProductCategory()
    {
        if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['id']))
        {
            $_POST['description'] = htmlentities($_POST['description']);
            $ret = $this->model->UpdateProductCategory($_POST);
            if($ret)
            {
                $_SESSION['message'] = $this->SuccessMessage('Product category successfully updated.');
            }
            else
            {
                $_SESSION['message'] = $this->ErrorMessage('Error saving to the database.');
            }
            
            header('Location: /admin/editProductCategory/'.$_POST['id']);
        }
        else
        {
            $_SESSION['message'] = $this->ErrorMessage('There are missing fields.');
            header('Location: /admin/productCategories/');
        }
        
    }
    
    public function removeCategory()
    {
        $json_data = array();
        if(isset($_POST['id']))
        {
            $json_data['success'] = $this->model->RemoveCategory($_POST['id']);
        }
        else
        {
            $json_data['success'] = FALSE;
        }
        
        echo json_encode($json_data);
        exit;
    }
    
    public function AddNewServiceCategory() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            $data = array();
            if(isset($_SESSION['message']))
            {
                $data['message'] = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            else
            {
                $data['message'] = '';
            }
            $this->load->view('Header');
            $this->load->view('AddNewServiceCategory',$data);
            $this->load->view('Footer');
        }
    }
    
    public function EditServiceCategory() {
        if ($this->session->uname == NULL) {
            header('Location: /admin');
        } else {
            if(isset($GLOBALS['params'][0]))
            {
                $data = array();
                $id = $GLOBALS['params'][0];
                $stmt = $this->model->GetServiceCategoryById($id);
                foreach($stmt->result() as $row)
                {
                    $data['id'] = $row->id;
                    $data['name'] = $row->name;
                    $data['description'] = $row->description;
                }
                
                if(isset($_SESSION['message']))
                {
                    $data['message'] = $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                else
                {
                    $data['message'] = '';
                }
                $this->load->view('Header');
                $this->load->view('EditServiceCategory',$data);
                $this->load->view('Footer');
            }
            else
            {
                header("location : /admin/productCategories");
            }
        }
    }
    
    public function removeServiceCategory()
    {
        $json_data = array();
        if(isset($_POST['id']))
        {
            $json_data['success'] = $this->model->RemoveServiceCategory($_POST['id']);
        }
        else
        {
            $json_data['success'] = FALSE;
        }
        
        echo json_encode($json_data);
        exit;
    }
    
    public function SaveServiceCategory()
    {
        if(isset($_POST['name']) && isset($_POST['description']))
        {
            $_POST['description'] = htmlentities($_POST['description']);
            $ret = $this->model->SaveServiceCategory($_POST);
            if($ret)
            {
                $_SESSION['message'] = $this->SuccessMessage('Service category successfully added.');
            }
            else
            {
                $_SESSION['message'] = $this->ErrorMessage('Error saving to the database.');
            }
        }
        else
        {
            $_SESSION['message'] = $this->ErrorMessage('There are missing fields.');
        }
        
        header('Location: /admin/AddNewServiceCategory');
        
    }
    
    public function updateServiceCategory()
    {
        if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['id']))
        {
            $_POST['description'] = htmlentities($_POST['description']);
            $ret = $this->model->UpdateServiceCategory($_POST);
            if($ret)
            {
                $_SESSION['message'] = $this->SuccessMessage('Service category successfully updated.');
            }
            else
            {
                $_SESSION['message'] = $this->ErrorMessage('Error saving to the database.');
            }
            
            header('Location: /admin/editServiceCategory/'.$_POST['id']);
        }
        else
        {
            $_SESSION['message'] = $this->ErrorMessage('There are missing fields.');
            header('Location: /admin/serviceCategories/');
        }
        
    }
    
    public function SuccessMessage($message)
    {
        return '<div class="alert alert-success">
                <strong>Success!</strong> '.$message.'
              </div>';
    }
    
    public function ErrorMessage($message)
    {
        return '<div class="alert alert-danger">
                <strong>Error!</strong> '.$message.'
              </div>';
    }
}

?>