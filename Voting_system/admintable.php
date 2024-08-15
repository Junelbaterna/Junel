<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Panel</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='adminPanel.css'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php include 'adminPanelnav.php'; ?>

    <div class="content">
        <div style="overflow-x:auto;">
            <h2 style="text-align: center;font-weight: bolder;">User Data Table:</h2>
            <hr>

            <?php
            $conn = mysqli_connect('localhost', 'root', '', 'voting_system');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if (isset($_GET['deactivate'])) {
                $deactivate_email = $_GET['deactivate'];
                $update_status = "UPDATE register SET Status='inactive' WHERE Email='$deactivate_email'";
                $run_update = mysqli_query($conn, $update_status);
                if ($run_update === true) {
                    echo "<div style='color:green;text-align:center;'>User Deactivated Successfully</div>";
                } else {
                    echo "<div style='color:red;text-align:center;'>Error occurred while deactivating user</div>";
                }
            }
            ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>DOB</th>
                        <th>Password</th>
                        <th>Voted Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                $select = "SELECT * FROM register";
                $run = mysqli_query($conn, $select);

                if (!$run) {
                    die("Query execution failed: " . mysqli_error($conn));
                }

                while ($row_user = mysqli_fetch_array($run)) {
                    $FullName = $row_user['FullName'];
                    $MobileNo = $row_user['MobileNo'];
                    $Email = $row_user['Email'];
                    $DOB = $row_user['DOB'];
                    $Password = $row_user['Password'];
                    $Voted = $row_user['Voted'];
                ?>
                <tbody>
                    <tr>
                        <td style="text-transform: capitalize;"><?php echo $FullName; ?></td>
                        <td><?php echo $MobileNo; ?></td>
                        <td><?php echo $Email; ?></td>
                        <td><?php echo $DOB; ?></td>
                        <td><?php echo $Password; ?></td>
                        <td><?php echo $Voted; ?></td>
                        <td>
                            <a href="EditUser.php?edit=<?php echo $Email; ?>" class="btn btn-primary"
                                title="Edit"><i class="fas fa-pen"></i></a>
                            <a href="admintable.php?deactivate=<?php echo $Email; ?>" class="btn btn-warning"
                                title="Deactivate"><i class="fas fa-ban"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
        <hr style="border:solid 1px black;background-color: blue;"><br>
        <div style="overflow-x:auto;">
            <h2 style="text-align: center;font-weight: bolder;">Nominee Data Table :</h2>

            <?php
            if (isset($_GET['ndel'])) {
                $ndel_FullName = $_GET['ndel'];
                $ndelete = "DELETE FROM nominee WHERE FullName='$ndel_FullName'";
                $nrun_del = mysqli_query($conn, $ndelete);
                if ($nrun_del === true) {
                    echo "<div style='color:green;text-align:center;'>Record Deleted Successfully </div> ";
                } else {
                    echo "<div style='color:red;text-align:center;'>Try Again</div>";
                }
            }
            ?>

            <hr>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Party Name</th>
                        <th>Position</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                $select_nominee = "SELECT * FROM nominee ORDER BY FIELD(Position, 'president', 'vice-president', 'secretary')";

                $run_nominee = mysqli_query($conn, $select_nominee);

                if (!$run_nominee) {
                    die("Query execution failed: " . mysqli_error($conn));
                }

                while ($row_nominee = mysqli_fetch_array($run_nominee)) {
                    $nFullName = $row_nominee['FullName'];
                    $nPartyName = $row_nominee['PartyName'];
                    $nPosition = $row_nominee['Position'];
                    $nImage = $row_nominee['Image'];
                ?>

                <tbody>
                    <tr style="text-transform: capitalize;">
                        <td><?php echo $nFullName; ?></td>
                        <td><?php echo $nPartyName; ?></td>
                        <td><?php echo $nPosition; ?></td>
                        <td><img src="upload/<?php echo $nImage; ?>"
                                style="width: 100px;height: 100px; border-radius: 50%;"></td>
                        <td>
                            <a href="EditNominee.php?nedit=<?php echo $nFullName; ?>" class="btn btn-primary"
                                title="Edit"><i class="fas fa-pen"></i></a>
                            <a href="admintable.php?ndel=<?php echo $nFullName; ?>" class="btn btn-danger"
                                title="Delete"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
</body>

</html>
