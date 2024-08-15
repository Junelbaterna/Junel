<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Admin Panel</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='adminPanel.css'>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src='main.js'></script>
</head>
<style>
  .card1 {
    padding: 20px;
    background: #ffffff;
    border-radius: 5px;
    box-shadow: 5px 6px 15px lightseagreen;
  }

  .card {
    padding: 20px;
  }
</style>

<body>

  <?php include 'adminPanelnav.php'; ?>

  <?php
  $conn = mysqli_connect('localhost', 'root', '', 'voting_system');
  $select = "select * from admin where Username='$User'";
  $run = mysqli_query($conn, $select);
  $row_user = mysqli_fetch_array($run);
  $FullName = $row_user['FullName'];

  $Query = "select * from register ";
  $run1 = mysqli_query($conn, $Query);
  $row1 = mysqli_fetch_array($run1);
  $Status = $row1['Status'];
  ?>

  <div class="content">
    <h2>Profile :</h2>
    <?php echo date('D,d-M-y h:i:s A '); ?>
    <hr>
    <div class="main-body">
      <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
          <div class="card1">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <img src="junel.jpg" alt="Admin" class="rounded-circle" width="150" style="border-radius: 50%;">

                <div class="mt-3">
                  <h4 style="text-transform: capitalize;"><?php echo $FullName; ?></h4>
                  <p class="text-secondary mb-1">Admin</p>
                  <a href="adminPanel.php?str=<?php echo $Status ?>" class="btn btn-primary">Voting <?php echo $Status ?></a>
                  <a href="adminPanel.php?stp=<?php echo $Status ?>" class="btn btn-danger">Voting Stop</a>

                  <?php
                  if (isset($_GET['str'])) {
                    $str_Status = $_GET['str'];
                    $update = "update register set Status='ON' where Status='$str_Status'";
                    $run_str = mysqli_query($conn, $update);
                    if ($run_str === true) {
                      echo "<div style='color:green;text-align:center;'>Voting Start Successfully </div> ";
                    } else {
                      echo "<div style='color:red;text-align:center;'>Try Again</div>" . mysqli_error($conn);
                    }
                  }

                  if (isset($_GET['stp'])) {
                    $stp_Status = $_GET['stp'];
                    $update = "update register set Status='OFF' where Status='$stp_Status'";
                    $run_stp = mysqli_query($conn, $update);
                    if ($run_stp === true) {
                      echo "<div style='color:green;text-align:center;'>Voting Stop Successfully</div> ";
                    } else {
                      echo "<div style='color:red;text-align:center;'>Try Again</div>" . mysqli_error($conn);
                    }
                  }
                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h5 class="mb-0">Full Name</h5>
                </div>
                <div class="col-sm-9 text-secondary" style="text-transform: capitalize;">
                  <?php echo $FullName; ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h5 class="mb-0">Email</h5>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?php echo "$User"; ?>
                </div>
              </div>
              <hr>

              <div>
                <a href="addadmin.php" class="btn btn-primary" style="float: right;">Add New Admin</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><br>
    <hr><br>

    <form action="" method="POST" enctype="multipart/form-data">
      <h4 style="font-weight: bold;">Add Participants :</h4>
      <hr>
      <label for="FullName"><b>Full Name</b></label>
      <input type="text" placeholder="Enter Name" name="FullName" required>

      <label for="PartyName"><b>Party Name</b></label>
      <input type="text" placeholder="Enter Party Name" name="PartyName" required>
      <label for="Position"><b>Position</b></label>
      <select name="Position" required>
        <option value="">Select Position</option>
        <option value="President">President</option>
        <option value="Vice President">Vice President</option>
        <option value="Secretary">Secretary</option>
        <!-- Add more options as needed -->
      </select><br><br>
      <label for="Image"><b>Custom Image</b></label>
      <input type="file" name="Image" accept="image/*">
      <hr>
      <button type="submit" name="submit" class="btn btn-success" style="float: right;width: 120px;margin-left: 20px;">Register</button>
      <button type="reset" class="btn btn-primary" style="float: right;width: 120px;">Reset</button>
    </form>
    
    <?php
if (isset($_POST['submit'])) {
  $FullName = $_POST['FullName'];
  $PartyName = $_POST['PartyName'];
  $Position = $_POST['Position'];
  $Image = $_FILES['Image']['name'];
  $tmp_name = $_FILES['Image']['tmp_name'];

  // Check if Party Name or Position already exists
  $check_existing = "SELECT * FROM nominee WHERE PartyName='$PartyName' OR Position='$Position'";
  $run_check_existing = mysqli_query($conn, $check_existing);
  $existing_row = mysqli_fetch_array($run_check_existing);

  if ($existing_row) {
    if ($existing_row['PartyName'] == $PartyName && $existing_row['Position'] == $Position) {
      echo "<h5 style='color:red;text-align:center;'>Party Name and Position combination already exists. Please choose a different Party Name or Position.</h5>";
    } 
  } else {
    // Insert nominee if no duplicate Party Name or combination found
    $insert = "INSERT INTO nominee (FullName, PartyName, Position, Image, Votes, Status) VALUES ('$FullName', '$PartyName', '$Position', '$Image', 0, 'OFF')";
    try {
      $run = mysqli_query($conn, $insert);
      if ($run === true) {
        echo "<h5 style='color:green;text-align:center;'>Successfully Inserted</h5>";

        $qrCodeText = urlencode("Name: $FullName");
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?data={$qrCodeText}&size=300x300";

        echo "<img src='{$qrCodeUrl}' alt='QR Code'>";
        
        move_uploaded_file($tmp_name, "upload/$Image");
      } else {
        echo "<h5 style='color:red;text-align:center;'>Not Inserted</h5>"; 
      }
    } catch (mysqli_sql_exception $e) {
      $error_message = $e->getMessage();
      echo "<h5 style='color:red;text-align:center;'>An error occurred: $error_message</h5>";
    }
  }
}
?>


  </div>

</body>

</html>
