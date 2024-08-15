<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <link rel='stylesheet' type='text/css' media='screen' href='LoginSuccess.css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style>

        




        body {
            background-color: #5a5e62;
        }

        .container {
            margin-top: 50px;
            background-color: #65696d;

            
        }

        .vote-form {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ced4da;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .vote-form h2 {
            background-color: #dc3545;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
        }

        .vote-details {
            margin-top: 20px;
            text-align: center;
        }

        .vote-details img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 5px solid #ced4da;
        }

        .btn-primary,
        .btn-warning {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <center>
        <?php
        include "Loginnav.php";
        $select = "select * from register where Email='$user'";

        $run = mysqli_query($conn, $select);
        $row_user = mysqli_fetch_array($run);
        $FullName = $row_user['FullName'];

        ?>

        <div class="container">
            <div class="vote-form">
                <h2>Please confirm Your Vote</h2>

                <!-- ============PHP GET=================================== -->
                <?php
                $conn = mysqli_connect('localhost', 'root', '', 'voting_system');
                if (isset($_GET['Party'])) {
                    $PartyVote = $_GET['Party'];

                    // Check if the user has already voted for this position
                    $position = ''; // Set this variable to the position the user is voting for (e.g., president, vice-president, secretary)
                    $selectVote = "SELECT * FROM nominee WHERE FullName='$FullName' AND Position='$position'";
                    $runVote = mysqli_query($conn, $selectVote);

                    if (!$runVote) {
                        // Error handling if the query fails
                        echo "<h5 style='color:red;text-align:center;'>Error executing query: " . mysqli_error($conn) . "</h5>";
                    } else {
                        if (mysqli_num_rows($runVote) > 0) {
                            // User has already voted for this position, display a message or redirect them
                            echo "<h5 style='color:red;text-align:center;'>You have already voted for $position</h5>";
                        } else {
                            // User has not voted for this position yet, proceed with the voting process
                            $selectNominee = "select * from nominee where PartyName='$PartyVote'";
                            $runNominee = mysqli_query($conn, $selectNominee);

                            $row_user = mysqli_fetch_array($runNominee);
                            $eFullName = $row_user['FullName'];
                            $eVotes = $row_user['Votes'];
                            $eImage = $row_user['Image'];
                ?>
                            <!-- ============PHP GET=================================== -->

                            <div class="vote-details">
                                <h5 style="text-transform: capitalize;">You Voted : <?php echo $PartyVote; ?></h5>
                                <img src="upload/<?php echo $eImage; ?>" alt="Nominee Image">
                                <form action="" method="POST">
                                    <input type="hidden" name="Votes" value="<?php echo $eVotes; ?>" required placeholder="Enter Party Name">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit Vote</button>
                                    <a href="LoginSuccess.php" class="btn btn-warning">Cancel</a>
                                </form>
                            </div>

                            <!-- ============PHP Update=================================== -->
                <?php
                            if (isset($_POST['submit'])) {
                                $Votes = $_POST['Votes'];

                                $eVotes = $eVotes + 1;
                                $update = "update nominee set Votes='$eVotes' where PartyName='$PartyVote'";

                                $run_update = mysqli_query($conn, $update);
                                if ($run_update === true) {
                                    echo "<script> window.open('LoginVoteSuccess.php','_self') </script>";
                                } else {
                                    echo "<center><H5 style='color:red;text-align:center;'>Something Went Wrong</h5></center>" . mysqli_error($conn);
                                }

                                $Rupdate = "update register set Voted='YES' where FullName='$FullName'";

                                $Rrun_update = mysqli_query($conn, $Rupdate);
                                if ($Rrun_update === true) {
                                    echo "<H5 style='color:green;text-align:center;'>Voted YES</h5>";
                                } else {
                                    echo "<center><H5 style='color:red;text-align:center;'>Something Went Wrong</h5></center>" . mysqli_error($conn);
                                }
                            }
                        }
                    }
                }
                ?>
                <!-- ============PHP Update=================================== -->
            </div>
        </div>
    </center>
</body>

</html>
