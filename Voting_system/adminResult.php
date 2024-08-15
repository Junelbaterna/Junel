<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Result</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='adminPanel.css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src='main.js'></script>
</head>

<body>
    <?php include 'adminPanelnav.php'; ?>

    <div class="content">
        <h2 style="text-align: center;font-weight: bolder;">Result Progress :</h2>
        <br>
        <hr>
        <table class="table table-hover" style="overflow-x:auto;">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Position</th>
                    <th>Party Name</th>
                    <th>Total Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = mysqli_connect('localhost', 'root', '', 'voting_system');
                $select = "SELECT * FROM nominee";
                $run = mysqli_query($conn, $select);

                while ($row_user = mysqli_fetch_array($run)) {
                    $nFullName = $row_user['FullName'];
                    $nPartyName = $row_user['PartyName'];
                    $nPosition = $row_user['Position'];
                    $nVotes = $row_user['Votes'];
                ?>
                    <tr style="text-transform: capitalize;">
                        <td><?php echo $nFullName; ?></td>
                        <td><?php echo $nPosition; ?></td>
                        <td><?php echo $nPartyName; ?></td>
                        <td><?php echo $nVotes; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        $select = "SELECT MAX(Votes) AS MAX FROM nominee";
        $run = mysqli_query($conn, $select);
        $row_user = mysqli_fetch_array($run);
        $rVotes = $row_user['MAX'];
        if ($rVotes > 0) {
        ?>
            <hr>
            <?php echo date('r'); ?>
            <h2 style="text-align: center;font-weight: bolder;">Declared Winner :</h2>
            <hr>
            <table class="table table-hover" style="overflow-x:auto;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Party Name</th>
                        <th>Votes</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select = "SELECT * FROM nominee WHERE Votes='$rVotes'";
                    $run = mysqli_query($conn, $select);
                    $s = 0;
                    while ($row_user = mysqli_fetch_array($run)) {
                        $FullName = $row_user['FullName'];
                        $PartyName = $row_user['PartyName'];
                        $Votes = $row_user['Votes'];
                        $Image = $row_user['Image'];
                        $Status = $row_user['Status'];
                        $s++;
                    ?>
                        <tr style="text-transform: capitalize;">
                            <td><?php echo $s; ?></td>
                            <td><?php echo $FullName; ?></td>
                            <td><?php echo $PartyName; ?></td>
                            <td><?php echo $Votes; ?></td>
                            <td><img src="upload/<?php echo $Image; ?>" style="width: 100px;height: 100px; border-radius: 50%;"></td>
                            <td><?php echo $Status; ?></td>
                            <td>
                                <a href="adminResult.php?dcl=<?php echo $PartyName ?>" class="btn btn-primary" title="Declared"><i class="fa fa-bullhorn"></i></a>
                                <a href="adminResult.php?udcl=<?php echo $PartyName ?>" class="btn btn-danger" title="UnDeclared"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<div style='color:red;text-align:center;'>NO WINNER</div>" . mysqli_error($conn);
        } ?>

        <?php
        if (isset($_GET['dcl'])) {
            $dcl_PartyName = $_GET['dcl'];
            $update = "UPDATE nominee SET Status='ON' WHERE PartyName='$dcl_PartyName'";
            $nrun_dcl = mysqli_query($conn, $update);
            if ($nrun_dcl === true) {
                echo "<div style='color:green;text-align:center;'> Declared Winner Successfully </div> ";
            } else {
                echo "<div style='color:red;text-align:center;'>Try Again</div>" . mysqli_error($conn);
            }
        }
       
