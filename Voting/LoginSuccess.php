<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Success</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <style>
        /* Add your custom styles here */
        .card {
            margin-bottom: 20px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php include "Loginnav.php"; ?>
            </div>
            <div class="col-md-9">
                <h2 style="text-align: center; font-weight: bolder;">Result Progress :</h2>
                <br>
                <hr>
                <?php
$conn = mysqli_connect('localhost', 'root', '', 'voting_system');
$query = "SELECT * FROM nominee ORDER BY Position ASC"; // Sort by Position in ascending order
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>                               
                    <th>Full Name</th>
                    <th>Party Name</th>
                    <th>Position</th>
                    <th>Votes</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display president first
                $presidentQuery = "SELECT * FROM nominee WHERE Position = 'President'";
                $presidentResult = mysqli_query($conn, $presidentQuery);
                $presidentRow = mysqli_fetch_assoc($presidentResult);

                $FullName1 = $presidentRow['FullName'];
                $PartyName = $presidentRow['PartyName'];
                $Position = $presidentRow['Position'];
                $Image = $presidentRow['Image'];
                $Votes = $presidentRow['Votes'];
                ?>
                <tr>
                    <td><?php echo $FullName1; ?></td>
                    <td><?php echo $PartyName; ?></td>
                    <td><?php echo $Position; ?></td>
                    <td><?php echo $Votes; ?></td>
                    <td><img src="upload/<?php echo $Image; ?>" alt="Image" style="width: 80px; height: 50px;"></td>
                </tr>
                
                <?php
                // Loop through the rest of the nominees
                while ($row = mysqli_fetch_assoc($result)) {
                    $FullName1 = $row['FullName'];
                    $PartyName = $row['PartyName'];
                    $Position = $row['Position'];
                    $Image = $row['Image'];
                    $Votes = $row['Votes'];
                ?>
                    <tr>
                        <td><?php echo $FullName1; ?></td>
                        <td><?php echo $PartyName; ?></td>
                        <td><?php echo $Position; ?></td>
                        <td><?php echo $Votes; ?></td>
                        <td><img src="upload/<?php echo $Image; ?>" alt="Image" style="width: 80px; height: 50px;"></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo "<br><br><br><br>";
    echo "<center style='margin-left: 270px;color:red;'><h3>Voting is Not Available.</h3></center>";
}
?>


            </div>
        </div>
    </div>
    <br>
</body>

</html>
