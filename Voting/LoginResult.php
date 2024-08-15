<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link rel='stylesheet' type='text/css' media='screen' href='LoginSuccess.css'>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

</head>

<body>
  
    <div style="margin-left: 270px;"><br>

        <hr>
        <center>
            <h1><b>Winner : </b></h1>
        </center>
        <hr>
    </div>
    <div class="container-fluid row ">
    <?php include "Loginnav.php"; ?>


        <?php
        $query = "SELECT * FROM nominee WHERE Status='ON' ORDER BY Position ASC"; // Order by Position in ascending order
        $run = mysqli_query($conn, $query);

        if (mysqli_num_rows($run) > 0) {
            while ($row = mysqli_fetch_array($run)) {
                $FullName = $row['FullName'];
                $PartyName = $row['PartyName'];
                $Image = $row['Image'];
                $Votes = $row['Votes'];
                $Status = $row['Status'];
        ?>
                <div class="card">
                    <h2 style="text-transform: capitalize;">
                        <!-- ========================php====================== -->
                        <i class='fab fa-<?php echo $PartyName; ?>'></i> <?php echo $PartyName; ?>
                        <!-- ========================php====================== -->
                    </h2>
                    <center>
                        <img class="card-img-top" src="upload/<?php echo $Image; ?>" alt="Card image">
                    </center>
                    <div class="card-body">
                        <h4 class="card-title" style="text-transform: capitalize;"><?php echo "$FullName"; ?></h4>
                        <a href="LoginSuccess.php" class="btn btn-primary" style="width: 100%;">OK</a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<center style='margin-left: 270px;color:red;'><h3>No Data Available.</h3></center>";
        }
        ?>
    </div>
</body>

</html>
