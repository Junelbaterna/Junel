<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css
"
        grity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
        crossorigin="anonymous">
    <style>
        body {
            background-image: url("Images/phinma.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.8);
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            background-color: rgba(255, 255, 255, 0.9);
        }

        .container h1 {
            padding: 10px 0;
            font-weight: bold;
            text-align: center;
            color: #155724;
            background-color: #d4edda;
            border-radius: 5px;
        }

        .container .form-group {
            margin-bottom: 15px;
        }

        .container .form-group label {
            font-weight: bold;
        }

        .container .form-group input {
            width: 100%;
            height: 40px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .container .form-group button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            background-color: #28a745;
            color: #fff;
        }

        .container .form-group button:hover {
            background-color: #218838;
        }

        .container .mt-3 {
            text-align: center;
        }

        #backButtonContainer {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        #cameraContainer {
            display: none;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            background-color: rgba(255, 255, 255, 0.9);
        }

        #cameraContainer img {
            max-width: 80%;
            height: auto;
        }

        #cameraContainer button {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<?php
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'voting_system');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Retrieve form data
        $FullName = $_POST['FullName'];
        $MobileNo = $_POST['MobileNo'];
        $Email = $_POST['Email'];
        $DOB = $_POST['DOB'];
        $Password = $_POST['Password'];
        $RePassword = $_POST['RePassword'];

        
        if (strpos($Email, '@gmail.com') !== false) {
          
            if ($Password == $RePassword) {
                
                if (isset($_POST['ImageData'])) {
                    
                    $ImageData = $_POST['ImageData'];
                    $targetDir = "Images/";
                    $imageName = uniqid() . '.jpg'; 
                    $targetFile = $targetDir . $imageName;
                    $uploadOk = 1;

                    $imageData = str_replace('data:image/jpeg;base64,', '', $ImageData);
                    $imageData = str_replace(' ', '+', $imageData);
                    $imageData = base64_decode($imageData);
                    if (file_put_contents($targetFile, $imageData)) {
                        $insert = "INSERT INTO register(FullName, MobileNo, Email, DOB, Password, Status, Voted, ImageData) VALUES ('$FullName','$MobileNo','$Email','$DOB','$Password','ACTIVE','NO','$imageName')";
                        $run_insert = mysqli_query($conn, $insert);

                        if ($run_insert) {
                            $_SESSION['Email'] = $Email;
                            $_SESSION['ImageData'] = $imageName;
                            echo "<script>alert('Registration successful!');</script>";
                        } else {
                            echo "<script>alert('Registration failed. Please try again.');</script>";
                        }
                    } else {
                        echo "<script>alert('Failed to upload image. Please try again.');</script>";
                    }
                } else {
                    echo "<script>alert('Image data not provided.');</script>";
                }
            } else {
                echo "<script>alert('Password is not matched with Re-Entered Password');</script>";
            }
        } else {
            echo "<script>alert('Invalid email domain. Please use a valid Gmail address.');</script>";
        }
    }
    ?>

    <div class="container">
        <h1>Registration Form</h1>
        <form action="" method="POST">
           
           <div class="form-group">
                <label for="FullName">Full Name</label>
                <input type="text" class="form-control" id="FullName" name="FullName" required>
            </div>
            <div class="form-group">
                <label for="MobileNo">Mobile No</label>
                <input type="tel" class="form-control" id="MobileNo" name="MobileNo"
                    pattern="^(09|\+639)\d{9}$" required>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="DOB">Date of Birth</label>
                <input type="date" class="form-control" id="DOB" name="DOB" required>
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" required>
            </div>
            <div class="form-group">
                <label for="RePassword">Re-enter Password</label>
                <input type="password" class="form-control" id="RePassword" name="RePassword" required>
            </div>
            

            <input type="hidden" name="ImageData" id="imageData">
            <button type="button" class="btn btn-primary" id="openCamera">Take Picture</button>
            <button type="submit" class="btn btn-success" name="submit">Submit</button>
            <button id="back" class="btn btn-secondary">Back</button>
        </form>
        <div class="mt-3">Already have an account? <a href="Login.php">Login</a></div>
    </div>
    <div id="cameraContainer">
        <video id="cameraFeed" width = "100%"></video><br>
     <center>  <button id="captureButton" class="btn btn-primary" >Capture</button></center> 
    </div>

    <script>
            document.getElementById('back').addEventListener('click', function () {
            window.location.href = 'index.html'; 
        });
        document.getElementById('openCamera').addEventListener('click', function () {
            document.getElementById('cameraContainer').style.display = 'block';
            startCamera();
        });

        document.getElementById('captureButton').addEventListener('click', function () {
            captureImage();
        });

        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    var video = document.getElementById('cameraFeed');
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function (error) {
                    console.error('Error accessing camera:', error);
                    alert('Error accessing camera. Please try again.');
                });
        }

        function captureImage() {
            var video = document.getElementById('cameraFeed');
            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            var imageData = canvas.toDataURL('image/jpeg'); 

            document.getElementById('imageData').value = imageData;

            document.getElementById('cameraContainer').style.display = 'none';
        }
    </script>



</body>

</html>