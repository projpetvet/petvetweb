<?php
        
Class SmsModel extends CI_Model {

    Public function __construct() {
        parent::__construct();
        $this->pdo = $this->load->database('pdo', true);
    }

    public function InsertMessage($data) 
    {
        try
        {
            extract($data);
            $sql = "INSERT INTO sms
                    SET recepient = ?,
                    message = ?
                    ";
            $stmt = $this->pdo->query($sql,array($recepient,$message));
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