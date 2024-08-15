<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'voting_system');
if (!isset($_SESSION['Email'])) {
    echo "<script> window.open('Login.php','_self') </script>";
}

$user = $_SESSION['Email'];

$conn = mysqli_connect('localhost', 'root', '', 'voting_system');
$select = "SELECT * FROM register WHERE Email='$user'";

$run = mysqli_query($conn, $select);
$row_user = mysqli_fetch_array($run);
$FullName = $row_user['FullName'];
$MobileNo = $row_user['MobileNo'];
$DOB = $row_user['DOB'];
$Password = $row_user['Password'];
$Status = $row_user['Status'];
$Voted = $row_user['Voted'];
$pic = $row_user['ImageData'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel='stylesheet' type='text/css' media='screen' href='LoginSuccess.css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style>
        

        center{
            background-color: #65696d;
        }





        .space {
            
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }

        .card {
            background-color: aqua;
            width: 300px;
            border-radius: 30px;
            
            margin-bottom: 20px;
        }

        .card img {
            margin-top: 30px;
            margin-left: 75px;
          
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            margin-bottom: 5px;
        }

        .links {
            margin-top: 20px;
        }

        .links a {
            margin-right: 10px;
            text-decoration: none;
            color:blue;
            font-style: italic;
            font-size: 20px;
            
        }

        .links a:hover {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="space">
        <div class="card">
            <img src="Images/<?php echo $pic; ?>" alt="User" class="rounded-circle">
            <div class="card-body">
                <h6 class="card-title">Name: <?php echo $FullName; ?></h6>
                <h6 class="card-title">User: <?php echo $user; ?></h6>
                <h6 class="card-title">Mobile No: <?php echo $MobileNo; ?></h6>
                <h6 class="card-title">DOB: <?php echo $DOB; ?></h6>
                <h6 class="card-title">Voted: <?php echo $Voted; ?></h6>
            </div>
        </div>

        <div class="links">
            <a href="LoginResult.php"><i class="fas fa-poll-h"></i> View Result</a>
            <a href="Logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </div>
    </div>

</body>

</html>
