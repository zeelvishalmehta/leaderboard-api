<?php
class Users{

    private $conn;

    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function getdata($uid){

        $sql = is_numeric($uid) ? "SELECT * FROM users WHERE uid='$uid'" : "SELECT * FROM users order by points desc"; 

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        return $stmt;
    }

    public function insertdata()
    {
        $insert_query = "INSERT INTO users (name,age,address) VALUES(:name,:age,:address)";        
        $insert_stmt = $this->conn->prepare($insert_query);
        return $insert_stmt;
    }

    public function deletedata($uid)
    {
        $delete_post = "DELETE FROM users WHERE uid=:uid";
        $delete_post_stmt = $this->conn->prepare($delete_post);
        return $delete_post_stmt;
    }

        
}

?>