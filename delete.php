<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// INCLUDING DATABASE AND MAKING OBJECT
include 'database.php';
include 'users.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();

$userobj = new Users($conn);

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));


//CHECKING, IF ID AVAILABLE ON $data
if(isset($data->uid)){
    $msg['message'] = '';
    
    $uid = $data->uid;
    
    //GET POST BY ID FROM DATABASE
    
    $check_post_stmt = $userobj->getdata($uid);
    $check_post_stmt->bindValue(':uid', $uid,PDO::PARAM_INT);
    $check_post_stmt->execute();
    
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($check_post_stmt->rowCount() > 0){
        
        //DELETE POST BY ID FROM DATABASE
        $delete_post_stmt = $userobj->deletedata($uid);
        $delete_post_stmt->bindValue(':uid', $uid,PDO::PARAM_INT);
        
        if($delete_post_stmt->execute()){
            header($_SERVER['SERVER_PROTOCOL'] . " 200 OK");
            $msg['message'] = 'User Deleted Successfully';
        }else{
            header($_SERVER['SERVER_PROTOCOL'] . " 400 Bad Request");
            $msg['message'] = 'User Not Deleted';
        }
        
    }else{
        header($_SERVER['SERVER_PROTOCOL'] . " 400 Bad Request");
        $msg['message'] = 'Invlid ID';
    }
    // ECHO MESSAGE IN JSON FORMAT
    echo  json_encode($msg);
    
}
?>