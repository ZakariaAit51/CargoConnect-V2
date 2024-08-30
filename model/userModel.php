<?php 
require_once 'core/db.php';

class UserModel{
    private $db;
    public function __construct(){
        $this->db = new db();
        }
    public function createUser($data){
        try{
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->execute();
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
}

?>