<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
</head>
<body>
    <div class="blur-background"></div>
    <div class="login">
        <h1>Login</h1>
    
        <form action="" method="POST">
            <center>
            <input type="email" name="Email" required placeholder="Email"><br>
          
            <input type="password" name="Password" required placeholder="Password"><br>
            <button type="submit" name="submit">Submit</button><br>
            <a href="admin.php">or Admin Login?</a>
        </center>
        </form> 
       
    </div>

    <button class="open-button" onclick="back()">Back</button>

<script>
    function back(){
        window.location="index.html";
    }
</script>  
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(isset($_POST['submit'])){
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $select = "SELECT * FROM register WHERE Email='$Email' AND Password='$Password' AND (Status='active' OR Status IS NULL)";
    $run = mysqli_query($conn, $select);
    $row_user = mysqli_fetch_array($run);

    if(is_array($row_user)){       
        echo "<script> window.open('LoginSuccess.php','_self') </script>";
        $_SESSION['Email'] = $row_user['Email'];
        $_SESSION['Voted'] = $row_user['Voted'];
    } else {
        echo "<h5 style='color:red;text-align:center;'>Your account has been deactivated by the admin or Invalid Credentials</h5>";
    }
}
?>




</body>
</html>
