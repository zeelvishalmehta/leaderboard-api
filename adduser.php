<?php
if(isset($_POST['submit']) && ($_POST['submit']=='Add User'))
{
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];

    if(($name != '') && (isset($name)) && (!empty(trim($name))) && ($address != '') && (isset($address)) && (!empty(trim($address))) && ($age>0))
    { 
        $data = array( 'name' => $name, 'age' => $age, 'address' => $address);
        $json_data = json_encode($data); 
        $request_url = 'http://localhost/leaderboard-api/insert.php';     
        $ch = curl_init($request_url);                                                     
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json_data))                                                                       
        );     
        $output = curl_exec($ch);
        header('location:index');
    }
    else
    {
        header('location:adduser?msg=error');
    }
}

?>
<html>
<title>Add New User</title>

<body>
    <form method="post">
        <table border=1 align='center' style='margin-top:50px;'>
        <tr><td colspan=2><a href='index'>HOME</a></td></tr>
            <tr>
                <td>Name:</td><td><input type='text' name='name' required></td>
            </tr>
            <tr>
                <td>Age:</td><td><input type='number' name='age' required></td>
            </tr>
            <tr>
                <td>Address:</td><td><input type='text' name='address' required></td>
            </tr>
            <tr>
                <td></td><td><input type='submit' name='submit' value='Add User'>
                <br>  
                <?
                if($_GET['msg']!='')
                { ?>
                <h4 style="color:red;font-size:14px;">NOTE: Name, age and address data should be valid otherwise you wouldn't be able to submit the information.</h4>
                <? }
                ?><br>
            </td>
            </tr>
        </table>
    </form>
</body>
</html>