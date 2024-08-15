<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Register</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='Register.css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@latest"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <div class="registerform">
        <h1>Registration Form</h1>
        <form action="" method="POST" >
            <input type="text" name="FullName" required placeholder="Full Name">
            <input type="tel" name="MobileNo" pattern="^(09|\+639)\d{9}$" required placeholder="Mobile No"><br>
            <input type="email" name="Email" required placeholder="Email">
            <input type="date" name="DOB" required placeholder="Date Of Birth"><br>
            <input type="password" name="Password" id="Password" required placeholder="Password">
            <input type="password" name="RePassword" id="RePassword" required placeholder="ReEnter Password"><br>
            <button type="submit" name="submit">Submit</button>
        </form>
        Have already account? <a href="Login.php">Login</a>
    </div>

    <button class="open-button" onclick="back()">Back</button>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@latest"></script>
    
    <script>
        function back(){
            window.location="index.html";
        }

        function validatePassword() {
            var password = document.getElementById("Password").value;
            var confirmPassword = document.getElementById("RePassword").value;
            if (password !== confirmPassword) {
                alert("Password does not match the confirm password.");
                return false;
            }
            return true;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var form = document.querySelector("form");
            form.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the form from submitting normally
                
                var formData = new FormData(form);
                fetch("register.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.includes("Successfully Inserted")) {
                        alert("Registration successful!");
                        form.reset(); // Reset the form fields
                    } else {
                        alert("Registration failed. Please try again.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
            });
        });
    </script>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "voting_system";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_POST['submit'])){
        $FullName=$_POST['FullName'];
        $MobileNo=$_POST['MobileNo'];
        $Email=$_POST['Email'];
        $DOB=$_POST['DOB'];
        $Password=$_POST['Password'];
        $RePassword=$_POST['RePassword'];

        if($Password==$RePassword){
            $insert="insert into register(FullName,MobileNo,Email,DOB,Password,Status,Voted) values('$FullName','$MobileNo','$Email','$DOB','$Password','OFF','NO')";
            $run_insert=mysqli_query($conn,$insert);
            
            if($run_insert===true){
                echo "Successfully Inserted";
            }else{
                echo "Not Inserted: " . mysqli_error($conn);
            }
        }else{
            echo "Password is not matched with Re-Entered Password";
        }
    }
    ?>
</body>
</html>
