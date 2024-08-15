<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Success</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' type='text/css' media='screen' href='loginnav&succes.css'>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }

    .container-fluid {
      margin-top: 20px;
      display: flex;
    }

    .profile {
      width: 30%;
      padding: 20px;
      background-color: #4CAF50;
      color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-right: 20px;
    }

    .profile h3 {
      margin-top: 0;
    }

    .profile-image {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    .profile p {
      margin: 5px 0;
    }

    .main-content {
      flex: 1;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow-x: auto; /* Added to allow horizontal scrolling if needed */
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #4CAF50;
      color: white;
    }

    td {
      background-color: #f2f2f2;
    }

    .btn-primary {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 8px 16px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #45a049;
    }

    .background-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url("Images/phinma.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      background-color: rgba(255, 255, 255, 0.8);
      filter: blur(5px);
      z-index: -1;
    }
  </style>
</head>
<body>
  <div class="background-container"></div> <!-- Background image container -->

  <div class="container-fluid">
    <!-- Profile section -->
    <?php include 'loginnav.php'; ?>

    <!-- Main content section -->
    <div class="main-content">
      <table>
        <thead>
          <tr>
            <th>Party Name</th>
            <th>Image</th>
            <th>Full Name</th>
            <th>Position</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Connect to the database
          $conn = mysqli_connect('localhost', 'root', '', 'voting_system');
          // Check connection
          if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
          }
          // Fetch nominees from the database
          $query = "SELECT * FROM nominee";
          $result = mysqli_query($conn, $query);
          // Check if there are any nominees
          if (mysqli_num_rows($result) > 0) {
            // Loop through each nominee and display their information
            while ($row = mysqli_fetch_assoc($result)) {
              $FullName = $row['FullName'];
              $PartyName = $row['PartyName'];
              $Image = $row['Image'];
              $Position = $row['Position'];
          ?>
              <tr>
                <td><?php echo $PartyName; ?></td>
                <td><img class="profile-image" src="upload/<?php echo $Image; ?>" alt="Nominee Image"></td>
                <td><?php echo $FullName; ?></td>
                <td><?php echo $Position; ?></td>
                <td><a href="LoginVoteS.php?Party=<?php echo $PartyName; ?>" class="btn btn-primary">Vote</a></td>
              </tr>
          <?php
            }
          } else {
            // Display a message if there are no nominees
            echo "<tr><td colspan='5' class='text-center' style='color:red;'>No nominees available.</td></tr>";
          }
          // Close database connection
          mysqli_close($conn);
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br>

  <script>
    function logout() {
     
      window.location.href = "Logout.php";
    }
  </script>
</body>
</html>