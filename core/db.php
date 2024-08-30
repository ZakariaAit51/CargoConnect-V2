<?php 

class db{
    protected $connection;
    protected $error;

    public function connect(){
        try{
            $this->connection = new PDO("mysql:host=localhost;dbname=cargoconnectv2", "root", "");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
            
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            throw new RuntimeException('Databse connection failed: ' . $this->error);
        }
    }
}

?>