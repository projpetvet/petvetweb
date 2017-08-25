<?php

class Petvet_model extends CI_Model {

    private $pdo;

    public function __construct() {
        parent::__construct();
        $this->pdo = $this->load->database('pdo', true);
    }

    public function checkUserAdmin($data) {
        extract($data);
        $encodePassword = hash('sha1', $password);
        $selectUser = $this->pdo->query("SELECT username, password FROM user_admin WHERE username = '$username' AND password = '$encodePassword' AND enabled = 1 ");
        return $selectUser->result();
    }

    public function saveMember($data) {
        extract($data);
        $hashpassword = hash('sha1', $password);
        $insertMember = "INSERT INTO customer(lastName, firstName, address, mobile, email, username, password, enabled) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $this->pdo->query($insertMember, array($lastName, $firstName, $address, $mobileNumber, $emailAddress, $userName, $hashpassword, 1));
        return "New member successfully added.";
    }

    public function getMemberDetails() {
        $selectMembers = $this->pdo->query("SELECT * FROM customer WHERE enabled = 1");
        return $selectMembers;
    }

    public function deleteMember($data) {
        extract($data);
        $removeMember = "UPDATE customer SET enabled = 0 WHERE id = ?";
        $this->pdo->query($removeMember, array($memberid));
        return "Member successfully removed.";
    }

    public function getMemberInfo($data) {
        extract($data);
        $selectMemberDetails = $this->pdo->query("SELECT * FROM customer WHERE id = $memberid ");
        return $selectMemberDetails->result();
    }

    public function updateMemberDetails($data) {
        extract($data);
        if(trim($newPassword) != '')
        {
            $newPassword = sha1($newPassword);
            $updateMember = "UPDATE customer SET firstname = ?, lastname = ?, address = ?, mobile = ?, email = ?, username = ?, password = ? WHERE id = ?";
            $this->pdo->query($updateMember, array($newFirstName, $newLastName, $newAddress, $newMobileNumber, $newEmailAddress, $newUsername, $newPassword, $id));
        }
        else
        {
            $updateMember = "UPDATE customer SET firstname = ?, lastname = ?, address = ?, mobile = ?, email = ?, username = ? WHERE id = ?";
            $this->pdo->query($updateMember, array($newFirstName, $newLastName, $newAddress, $newMobileNumber, $newEmailAddress, $newUsername, $id));
        }

        return "Member details successfully updated.";
    }

    public function saveProductDetails($data,$savedImage) {
        extract($data);
        $productDescriptionEncoded = htmlentities($productDescription);
        $insertProduct = "INSERT INTO product(name, description, price, image, enabled) VALUES(?, ?, ?, ?, ?)";
        $this->pdo->query($insertProduct, array($productName, $productDescriptionEncoded, $productPrice, $savedImage, 1));
    }

    public function saveServiceDetails($data,$savedImage) {
        extract($data);
        $serviceDescriptionEncoded = htmlentities($serviceDescription);
        $insertService = "INSERT INTO service(name, description, price, image, enabled) VALUES(?, ?, ?, ?, ?)";
        $this->pdo->query($insertService, array($serviceName, $serviceDescriptionEncoded, $servicePrice, $savedImage, 1));
    }

    public function updateServiceDetails($data) {
        extract($data);
        $editServiceDescriptionEncoded = htmlentities($editServiceDescription);
        $insertService = "UPDATE service SET name = ?, description = ?, price = ? WHERE id = ?";
        $this->pdo->query($insertService, array($editServiceName, $editServiceDescriptionEncoded, $editServicePrice, $edit_id));
    }
    
    public function updateProductDetails($data) {
        extract($data);
        $editProductDescriptionEncoded = htmlentities($editProductDescription);
        $insertService = "UPDATE product SET name = ?, description = ?, price = ? WHERE id = ?";
        $this->pdo->query($insertService, array($editProductName, $editProductDescriptionEncoded, $editProductPrice, $edit_id));
    }
    
    public function updateProductImage($id,$image)
    {
        $sql = "UPDATE product SET image = ? WHERE id = ?";
        $this->pdo->query($sql, array($image, $id));
    }
    
    public function updateServiceImage($id,$image)
    {
        $sql = "UPDATE service SET image = ? WHERE id = ?";
        $this->pdo->query($sql, array($image, $id));
    }

    public function getProductDetails() {
        $selectProducts = $this->pdo->query("SELECT * FROM product 
            WHERE enabled = 1
            ORDER BY name
            ");
        return $selectProducts;
    }

    public function deleteProduct($data) {
        extract($data);
        $removeProduct = "UPDATE product SET enabled = 0 WHERE id = ?";
        $this->pdo->query($removeProduct, array($productid));
        return "Product successfully removed.";
    }

    public function addNewUserAdminDetails($data) {
        extract($data);
        $hashpassword = hash('sha1', $password);
        $insertUser = "INSERT INTO user_admin(username, password, enabled) VALUES(?, ?, ?)";
        $this->pdo->query($insertUser, array($userName, $hashpassword, 1));
        return "New user admin successfully added.";
    }

    public function insertDoctorDetails($data) {
        extract($data);
        $insertDoctor = "INSERT INTO doctor(lastName, firstName, mobile, mon, tue, wed, thur, fri, sat, sun, time_in, time_out, enabled) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->pdo->query($insertDoctor, array($lastName, $firstName, $mobileNumber, $mon, $tues, $wed, $thurs, $fri, $sat, $sun, $timeIn, $timeOut, 1));
        return "New doctor successfully added.";
    }

    public function getDoctorDetails() {
        $selectDoctors = $this->pdo->query("SELECT * FROM doctor WHERE enabled = 1");
        return $selectDoctors;
    }

    public function deleteDoctorDetails($data) {
        extract($data);
        $removeDoctor = "UPDATE doctor SET enabled = 0 WHERE id = ?";
        $this->pdo->query($removeDoctor, array($doctorid));
    }

    public function selectDoctorDetails($data) {
        extract($data);
        $selectDoctors = $this->pdo->query("SELECT * FROM doctor WHERE id = $doctorid");
        return $selectDoctors->result();
    }

    public function updateDoctorDetails($data) {
        extract($data);
        $updateDoctor = "UPDATE doctor SET 	lastname = ?, firstname = ?, mobile = ?, mon = ?, tue = ?, wed = ?, thur = ?, fri = ?, sat = ?, sun = ?, time_in = ?, time_out = ? WHERE id = ?";
        $this->pdo->query($updateDoctor, array($editLastName, $editFirstName, $editMobileNumber, $mon, $tues, $wed, $thurs, $fri, $sat, $sun, $timeIn, $timeOut, $doctorid));
        return "Doctor details successfully updated.";
    }

    public function getUserDetails() {
        $selectUsers = $this->pdo->query("SELECT * FROM user_admin where enabled = 1");
        return $selectUsers;
    }

    public function getOwnerDetails() {
        $selectOwners = $this->pdo->query("SELECT lastname, firstname FROM customer WHERE enabled = 1");
        return $selectOwners;
    }

    public function getSpecieDetails() {
        $selectSpecies = $this->pdo->query("SELECT * FROM specie");
        return $selectSpecies;
    }

    public function getBreedDetails($data) {
        extract($data);
        $selectBreeds = $this->pdo->query("SELECT name FROM breed WHERE specie_id = '$speciename' ");
        return $selectBreeds->result();
    }
    
    public function getBreedBySpecieId($specie_id) 
    {
        $sql = "SELECT * FROM breed WHERE specie_id = ? ";
        $selectBreeds = $this->pdo->query($sql, array($specie_id));
        return $selectBreeds->result();
    }

    public function addNewPetDetails($data) {
        extract($data);

        $owner = explode(" ", $ownerName);
        $selectOwnerId = $this->pdo->query("SELECT id FROM customer WHERE lastname = '$owner[1]' AND firstname = '$owner[0]' ");
        $ownerIdResult = $selectOwnerId->result();
        $ownerid = $ownerIdResult[0]->id;

        $insertPet = "INSERT INTO pet(owner_id, name, breed_id, specie_id, sex) VALUES(?, ?, ?, ?, ?)";
        $this->pdo->query($insertPet, array($ownerid, $petName, $breed, $specie, $petGender));
        return "New pet successfully added.";
    }

    public function getPetDetails() {
        $selectPetDetails = $this->pdo->query("SELECT pet.owner_id AS ownerid,
                                                    pet.id AS petid,
                                                    customer.firstname AS owner, 
                                                    pet.name AS petname, 
                                                    pet.sex AS gender,
                                                    specie.name AS specie,
                                                    breed.name AS breed
                                            FROM customer, pet, specie, breed
                                            WHERE customer.id = pet.owner_id 
                                            AND pet.specie_id = specie.id 
                                            AND pet.breed_id = breed.id
                                            ORDER BY pet.name");
        return $selectPetDetails;
    }

    public function getOwnersFullNameDetails($data) {
        extract($data);
        $selectOwnersId = $this->pdo->query("SELECT lastname, firstname FROM customer WHERE id = $ownerid");
        return $selectOwnersId->result();
    }

    public function removePetDetails($data) {
        extract($data);
        $removeDoctor = "DELETE FROM pet WHERE id = ?";
        $this->pdo->query($removeDoctor, array($petid));
    }

    public function getMembersDetailsAndPets($data) {
        extract($data);

        $selectMember = $this->pdo->query("SELECT * FROM customer WHERE id = $id");
        $details['memberDetails'] = $selectMember->result();

        $selectPets = $this->pdo->query("SELECT id, name FROM pet WHERE owner_id = $id");
        $details['petDetails'] = $selectPets->result();

        return $details;
    }

    public function getServicesDetails() {
        $selectServices = $this->pdo->query("SELECT * FROM service WHERE enabled = 1");
        return $selectServices;
    }

    public function deleteService($data) {
        extract($data);
        $removeService = "UPDATE service SET enabled = 0 WHERE id = ?";
        $this->pdo->query($removeService, array($id));
        return "Service successfully removed.";
    }

    public function getServiceEditDetails($data) {
        extract($data);
        $selectServicesDetails = $this->pdo->query("SELECT * FROM service WHERE id = '$lastSegment' ");
        return $selectServicesDetails->result();
    }

    public function getProductEditDetails($data) {
        extract($data);
        $selectProductDetails = $this->pdo->query("SELECT * FROM product WHERE id = '$lastSegment' ");
        return $selectProductDetails->result();
    }
    
    public function GetOrders()
    {
        try
        {
            $sql = "SELECT * FROM orders ORDER BY id DESC";
            $stmt = $this->pdo->query($sql);
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetOrderById($id)
    {
        try
        {
            $sql = "SELECT * FROM orders
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
    
    public function GetOrderLineByOrderId($id)
    {
        try
        {
            $sql = "SELECT ol.*, p.name as product
                    FROM order_line as ol
                    INNER JOIN product as p
                    ON ol.product_id = p.id
                    WHERE ol.order_id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetAppointments()
    {
        try
        {
            $sql = "SELECT a.*, CONCAT(c.firstname,' ',c.lastname) as customer,
                    CONCAT(d.firstname,' ',d.lastname) as doctor,
                    p.name as pet
                    FROM appointment as a
                    INNER JOIN customer as c
                    ON a.customer_id = c.id
                    INNER JOIN doctor as d
                    ON a.doctor_id = d.id
                    INNER JOIN pet as p
                    ON a.pet_id = p.id
                    ORDER BY a.id DESC";
            $stmt = $this->pdo->query($sql);
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetAppointmentById($id)
    {
        try
        {
            $sql = "SELECT a.*, CONCAT(c.firstname,' ',c.lastname) as customer,
                    CONCAT(d.firstname,' ',d.lastname) as doctor,
                    p.name as pet
                    FROM appointment as a
                    INNER JOIN customer as c
                    ON a.customer_id = c.id
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
    
    public function GetAppointmentLineByAppId($id)
    {
        try
        {
            $sql = "SELECT s.*
                    FROM appointment_line as al
                    INNER JOIN service as s
                    ON al.service_id = s.id
                    WHERE al.appointment_id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }

    public function ChangeOrderStatus($order_id,$status)
    {
        try
        {
            $sql = "UPDATE orders SET status = ?
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($status,$order_id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function ChangeAppointmentStatus($app_id,$status)
    {
        try
        {
            $sql = "UPDATE appointment SET status = ?
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($status,$app_id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }

    public function getPetData($id)
    {
        try
        {
            $sql = "SELECT * FROM pet
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt->result()[0];
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function updatePetData($data)
    {
        try
        {
            extract($data);
            $sql = "UPDATE pet
                    SET name = ?,
                    breed_id = ?,
                    specie_id = ?,
                    sex = ?
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($name,$breed,$specie,$gender,$id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function updateUser($data)
    {
        try
        {
            extract($data);
            $password = sha1($password);
            $sql = "UPDATE user_admin
                    SET username = ?,
                    password = ?
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($username,$password,$id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function DeleteUser($id)
    {
        try
        {
            $sql = "UPDATE user_admin
                    SET enabled = 0
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
    
    public function GetUserById($id)
    {
        try
        {
            $sql = "SELECT * FROM user_admin
                    WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt->result()[0];
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
    
    public function SaveSpecie($specie)
    {
        try
        {
            $sql = "INSERT INTO specie SET name = ?";
            $stmt = $this->pdo->query($sql,array($specie));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function UpdateSpecie($data)
    {
        try
        {
            extract($data);
            $sql = "UPDATE specie SET name = ? WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($name,$id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function DeleteSpecie($id)
    {
        try
        {
            $sql = "DELETE FROM specie WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetBreeds($selected)
    {
        try
        {
            if($selected == 0)
            {
                $sql = "SELECT b.*,s.name as specie FROM breed as b
                        INNER JOIN specie as s
                        ON b.specie_id = s.id
                        ORDER BY name";
                $stmt = $this->pdo->query($sql);
            }
            else
            {
                $sql = "SELECT b.*,s.name as specie FROM breed as b
                        INNER JOIN specie as s
                        ON b.specie_id = s.id
                        WHERE s.id = ?
                        ORDER BY name";
                $stmt = $this->pdo->query($sql,array($selected));
            }
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function GetBreed($id)
    {
        try
        {
            $sql = "SELECT * FROM breed WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function SaveBreed($data)
    {
        try
        {
            extract($data);
            $sql = "INSERT INTO breed SET name = ?, specie_id = ?";
            $stmt = $this->pdo->query($sql,array($name,$specie));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function UpdateBreed($data)
    {
        try
        {
            extract($data);
            $sql = "UPDATE breed SET name = ?, specie_id = ? WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($name,$specie,$id));
            return $stmt;
        } 
        catch (Exception $ex) 
        {
            echo $ex;
            exit;
        }
    }
    
    public function DeleteBreed($id)
    {
        try
        {
            $sql = "DELETE FROM breed WHERE id = ?";
            $stmt = $this->pdo->query($sql,array($id));
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