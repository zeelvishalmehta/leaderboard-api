<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

// INCLUDING DATABASE AND MAKING OBJECT
include 'database.php';
include 'users.php';

$db_connection = new Database();
$conn = $db_connection->dbConnection();


// CHECK GET ID PARAMETER OR NOT
if(isset($_GET['uid']))
{
    //IF HAS ID PARAMETER
    $uid = filter_var($_GET['uid'], FILTER_VALIDATE_INT,[
        'options' => [
            'default' => 'all_posts',
            'min_range' => 1
        ]
    ]);
}
else{
    $uid = 'all_posts';
}

// MAKE SQL QUERY
// IF GET POSTS ID, THEN SHOW POSTS BY ID OTHERWISE SHOW ALL POSTS
$userobj = new Users($conn);
$stmt = $userobj->getdata($uid);

//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $posts_array = [];
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        $post_data = [
            'uid' => $row['uid'],
            'name' => $row['name'],
            'age' => $row['age'],
            'points' => $row['points'],
            'address' => $row['address']
            ];
        // PUSH POST DATA IN OUR $posts_array ARRAY
        array_push($posts_array, $post_data);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    header($_SERVER['SERVER_PROTOCOL'] . " 200 OK");
    echo json_encode($posts_array);
 

}
else{
    //IF THER IS NO POST IN OUR DATABASE
    header($_SERVER['SERVER_PROTOCOL'] . " 204 No Content");
    echo json_encode(['message'=>'No post found']);
}
?>