<html>
<title>LeaderBoard</title>

<body>
<table border=1 width="70%" align="center" style="margin-top:50px;"> 
    <tr align="center">
        <td></td>
        <td>Name</td>
        <td></td>
        <td></td>
        <td>Points</td>    
    </tr>
<?php
error_reporting(0);
$readdata = file_get_contents("http://localhost/leaderboard-api/read.php");
$data_json_decode = json_decode($readdata);
if($data_json_decode->message != 'No post found'){
    foreach($data_json_decode as $user)
    {
        echo "<tr align=center>";
        echo "<td><a href=index?action=delete&uid=".$user->uid.">X</a></td>";
        echo "<td><a href=index?uid=".$user->uid.">".$user->name."</a></td>";
        echo "<td><a href=index?action=addpoint&uid=".$user->uid.">+</a></td>";
        echo "<td><a href=index?action=subtractpoint&uid=".$user->uid.">-</a></td>";
        echo "<td>".$user->points." points</td>";
        echo "</tr>";
    }
} 
?>
<tr>
<td colspan='5' align='right'><a href='adduser'>Add User</a></td>
</tr>
</table>

<?php
//show selected user's details
if(isset($_GET['uid']) && ($_GET['uid']!=''))
{
?>
<table border='1' align='center' style='margin-top:30px'>
<tr>
<td>Name</td>
<td>Age</td>
<td>Points</td>
<td>Address</td>
</tr>
<?php
$readsingledata = file_get_contents("http://localhost/leaderboard-api/read.php?uid=".$_GET['uid']."");
$json_decode = json_decode($readsingledata);
    foreach($json_decode as $user)
    {
        echo "<tr align=center>";
        echo "<td>".$user->name."</td>";
        echo "<td>".$user->age."</td>";
        echo "<td>".$user->points." points</td>";
        echo "<td>".$user->address."</td>";
        echo "</tr>";
    }
?>
<tr align='center'><td colspan='4'><a href='index.php'>Back</a></td></tr>
</table>
<?php } 

//delete selected user
if(isset($_GET['action']) && ($_GET['action']=='delete') && ($_GET['uid']!=''))
{
    $data = array( 'uid' => $_GET['uid']);
    $json_data = json_encode($data); 
    $request_url = 'http://localhost/leaderboard-api/delete.php';     
    $ch = curl_init($request_url);                                                     
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                              
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($json_data))                                                                       
    );     
    $output = curl_exec($ch);
    header('location:index.php');
}

//addpoint of selected user
if(isset($_GET['action']) && ($_GET['action']=='addpoint') && ($_GET['uid']!=''))
{
    $data = array( 'uid' => $_GET['uid']);
    $json_data = json_encode($data); 
    $request_url = 'http://localhost/leaderboard-api/addpoint.php';     
    $ch = curl_init($request_url);                                                     
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                              
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($json_data))                                                                       
    );     
    $output = curl_exec($ch);
    header('location:index.php');
}

//subtractpoint of selected user
if(isset($_GET['action']) && ($_GET['action']=='subtractpoint') && ($_GET['uid']!=''))
{
    $data = array( 'uid' => $_GET['uid']);
    $json_data = json_encode($data); 
    $request_url = 'http://localhost/leaderboard-api/subtractpoint.php';     
    $ch = curl_init($request_url);                                                     
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                              
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($json_data))                                                                       
    );     
    $output = curl_exec($ch);
    header('location:index.php');
}

?>
</body>
</html>
