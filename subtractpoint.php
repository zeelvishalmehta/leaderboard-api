<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
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
    $get_stmt = $userobj->getdata($uid);
    $get_stmt->bindValue(':uid', $uid,PDO::PARAM_INT);
    $get_stmt->execute();
    
    
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($get_stmt->rowCount() > 0){
        
        // FETCH POST FROM DATBASE 
        $row = $get_stmt->fetch(PDO::FETCH_ASSOC);
        if($row['points'] > 0)
        {
            $points =  $row['points'] - 1;                
            $update_query = "UPDATE users SET points = :points WHERE uid = :uid";        
            $update_stmt = $conn->prepare($update_query);
            
            // DATA BINDING AND REMOVE SPECIAL CHARS AND REMOVE TAGS
            $update_stmt->bindValue(':points', htmlspecialchars(strip_tags($points)),PDO::PARAM_STR);
            $update_stmt->bindValue(':uid', $uid,PDO::PARAM_INT);
            
            
            if($update_stmt->execute()){
                $msg['message'] = 'Points updated successfully';
            }else{
                $msg['message'] = 'Points not updated';
            }   
        }
        else{
            $msg['message'] = 'Points must be greater than zero';
        }
    }
    else{
        $msg['message'] = 'Invlid ID';
    }  
    
    echo  json_encode($msg);
    
}
?>