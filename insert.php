<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// INCLUDING DATABASE AND MAKING OBJECT
include 'database.php';
include 'users.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));

//CREATE MESSAGE ARRAY AND SET EMPTY
$msg['message'] = '';

// CHECK IF RECEIVED DATA FROM THE REQUEST
if(isset($data->name) && isset($data->age) && isset($data->address)){
    // CHECK DATA VALUE IS EMPTY OR NOT
    if(!empty($data->name) && !empty($data->age) && !empty($data->address))
    {
        
        if($data->age > 0)
        {
            $userobj = new Users($conn);
            $insert_stmt = $userobj->insertdata();
            // DATA BINDING
            $insert_stmt->bindValue(':name', htmlspecialchars(strip_tags($data->name)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':age', htmlspecialchars(strip_tags($data->age)),PDO::PARAM_STR);
            //$insert_stmt->bindValue(':points', htmlspecialchars(strip_tags($data->points)),PDO::PARAM_STR);
            $insert_stmt->bindValue(':address', htmlspecialchars(strip_tags($data->address)),PDO::PARAM_STR);
            
            if($insert_stmt->execute()){
                $msg['message'] = 'Data Inserted Successfully';
            }else{
                $msg['message'] = 'Data not Inserted';
            } 
        
        }
        else
        {
             $msg['message'] = 'Age must be greater than zero';
        }
    }
    else{
        $msg['message'] = 'Oops! empty field detected. Please fill all the fields';
    }
}
else{
    $msg['message'] = 'Please fill all the fields';
}
//ECHO DATA IN JSON FORMAT
echo  json_encode($msg);
?>