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
            <input type="date" name="DOB" required placeholder="Date Of Birth"><br>
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

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(isset($_POST['submit'])){
     $Email=$_POST['Email'];
     $DOB=$_POST['DOB'];
     $Password=$_POST['Password'];
    
    $select="select * from register where Email='$Email' and Password='$Password'and DOB='$DOB'";
    $run=mysqli_query($conn,$select);
    
    // $row_user=mysqli_num_rows($run);
      $row_user=mysqli_fetch_array($run);
    //   $dbEmail=$row_user['Email'];
    //   $dbDOB=$row_user['DOB'];
    //   $dbVoted=$row_user['Voted'];
    //   $dbPassword=$row_user['Password'];

      if(is_array($row_user)){//$Email==$dbEmail && $Password==$dbPassword
          echo "<script> window.open('LoginSuccess.php','_self') </script>";
          $_SESSION['Email']=$row_user['Email'];// $dbEmail;
          $_SESSION['Voted']=$row_user['Voted'];// $Voted;
      }else{
          echo "<h5 style='color:red;text-align:center;'>Wrong Username or Password</h5>".mysqli_error($conn);
      }
}
?>

</body>
</html>
