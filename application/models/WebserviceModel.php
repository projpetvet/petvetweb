<?php
        
Class WebserviceModel extends CI_Model {

    Public function __construct() {
        parent::__construct();
        $this->pdo = $this->load->database('pdo', true);
    }

    public function GetCustomerById($id) 
    {
        try
        {
            $sql = "SELECT * FROM customer
                    WHERE id = ?
                    ";
            $stmt = $this->pdo->query($sql,$id);
            $result = $stmt->result();
            return (array) $result[0];
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function AuthenticateUser($username,$password) 
    {
        try
        {
            $sql = "SELECT id FROM customer where username = ? and password = ?";
            $stmt = $this->pdo->query($sql,array($username,$password));
            return $stmt->result();
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function Register($data)
    {
        try
        {
            extract($data);
            $password = sha1($password);
            $sql = "INSERT INTO customer
                    SET lastname = ?,
                    firstname = ?,
                    address = ?,
                    mobile = ?,
                    email = ?,
                    username = ?,
                    password = ?,
                    enabled = 1
                    ";
            $stmt = $this->pdo->query($sql,array($lastname,$firstname,$address,$mobile,$email,$username,$password));
            $id = $this->pdo->insert_id();
            return $id;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function UpdateProfile($data)
    {
        try
        {
            extract($data);
            if(trim($password) != '')
            {
                $password = sha1($password);
                $sql = "UPDATE customer
                        SET lastname = ?,
                        firstname = ?,
                        address = ?,
                        mobile = ?,
                        email = ?,
                        username = ?,
                        password = ?
                        WHERE id = ?
                        ";
                $stmt = $this->pdo->query($sql,array($lastname,$firstname,$address,$mobile,$email,$username,$password,$id));
                return $stmt;
            }
            else
            {
                $sql = "UPDATE customer
                        SET lastname = ?,
                        firstname = ?,
                        address = ?,
                        mobile = ?,
                        email = ?,
                        username = ?
                        WHERE id = ?
                        ";
                $stmt = $this->pdo->query($sql,array($lastname,$firstname,$address,$mobile,$email,$username,$id));
                return $stmt;
            }
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetProducts()
    {
        try
        {
            $sql = "SELECT * FROM product 
                    WHERE enabled = 1
                    ORDER BY name";
            $stmt = $this->pdo->query($sql);
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetProductPriceById($id)
    {
        try
        {
            $sql = "SELECT price FROM product 
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            $result = $stmt->result();
            return $result[0]->price;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetProductsByIdList($ids)
    {
        try
        {
            $array = explode(",", $ids);
            $sql = "SELECT id,name,price FROM product 
                    WHERE enabled = 1
                    AND id IN(". implode(',', array_map('intval', $array)) . ")";
            $stmt = $this->pdo->query($sql);
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function AddOrder($data)
    {
        try
        {
            extract($data);
            $date_added = date("Y-m-d h:i:s");
            $sql = "INSERT INTO orders
                    SET customer_id = ?,
                    date_added = ?,
                    billing_name = ?,
                    billing_address = ?,
                    billing_mobile = ?,
                    billing_email = ?,
                    note = ?,
                    total = ?
                    ";
            $stmt = $this->pdo->query($sql,array($customer_id,$date_added,$name,$address,$mobile,$email,$note,$grandTotal));
            $id = $this->pdo->insert_id();
            return $id;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function AddOrderLine($order_id,$data)
    {
        try
        {
            extract($data);
            $sql = "INSERT INTO order_line
                    SET order_id = ?,
                    product_id = ?,
                    quantity = ?,
                    price = ?,
                    total = ?
                    ";
            $stmt = $this->pdo->query($sql,array($order_id,$id,$quantity,$price,$total));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetOrderListByCustomer($id)
    {
        try
        {
            $sql = "SELECT id,date_added,status,total FROM orders 
                    WHERE customer_id = ?
                    ORDER BY id DESC";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetDoctors()
    {
        try
        {
            $sql = "SELECT * FROM doctor 
                    WHERE enabled = 1
                    ORDER BY lastname";
            $stmt = $this->pdo->query($sql);
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetServices()
    {
        try
        {
            $sql = "SELECT * FROM service 
                    WHERE enabled = 1
                    ORDER BY name";
            $stmt = $this->pdo->query($sql);
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetPetsByOwner($id)
    {
        try
        {
            $sql = "SELECT * FROM pet 
                    WHERE owner_id = ?
                    ORDER BY name";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function RequestAppointment($data)
    {
        try
        {
            extract($data);
            $sql = "INSERT INTO appointment
                    SET customer_id = ?,
                    pet_id = ?,
                    doctor_id = ?,
                    app_date = ?,
                    app_time = ?,
                    status = 1
                    ";
            $stmt = $this->pdo->query($sql,array($customer_id,$pet_id,$doctor_id,$app_date,$app_time));
            $id = $this->pdo->insert_id();
            return $id;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function RequestAppointmentService($id,$service_id)
    {
        try
        {
            $sql = "INSERT INTO appointment_line
                    SET appointment_id = ?,
                    service_id = ?
                    ";
            $stmt = $this->pdo->query($sql,array($id,$service_id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetAppointmentByCustomerId($customer_id)
    {
        try
        {
            $sql = "SELECT * FROM appointment 
                    WHERE customer_id = ?
                    ORDER BY id DESC";
            $stmt = $this->pdo->query($sql,array($customer_id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetAppointmentDetailById($id)
    {
        try
        {
            $sql = "SELECT a.*, CONCAT(d.firstname,' ',d.lastname) as doctor_name, p.name as pet_name
                    FROM appointment as a
                    INNER JOIN doctor as d
                    ON a.doctor_id = d.id
                    INNER JOIN pet as p
                    ON a.pet_id = p.id
                    WHERE a.id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetAppointmentServices($id)
    {
        try
        {
            $sql = "SELECT s.* 
                    FROM appointment_line as a
                    INNER JOIN service as s
                    ON a.service_id = s.id
                    WHERE a.appointment_id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function CancelAppointment($id)
    {
        try
        {
            $sql = "UPDATE appointment
                    SET status = 5
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function CancelOrder($id)
    {
        try
        {
            $sql = "UPDATE orders
                    SET status = 5
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetSpecies()
    {
        try
        {
            $sql = "SELECT * FROM specie ORDER BY name";
            $stmt = $this->pdo->query($sql);
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetBreedsBySpecieId($specie)
    {
        try
        {
            $sql = "SELECT * FROM breed
                    WHERE specie_id = ?
                    ORDER BY name";
            $stmt = $this->pdo->query($sql,array($specie));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function SavePet($data)
    {
        try
        {
            extract($data);
            $sql = "INSERT INTO pet
                    SET owner_id = ?,
                    name = ?,
                    breed_id = ?,
                    specie_id = ?,
                    sex = ?
                    ";
            $stmt = $this->pdo->query($sql,array($customer,$name,$breed,$specie,$gender));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
}

?> 