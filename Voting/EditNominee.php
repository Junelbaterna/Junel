<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Edit Nominee</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='Register.css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
    <div class="registerform">
        <h1>Edit Nominee Form</h1>
        <?php
            $conn = mysqli_connect('localhost', 'root', '', 'voting_system');
            if (isset($_GET['nedit'])) {
                $edit_FullName = $_GET['nedit'];

                $select = "SELECT * FROM nominee WHERE FullName=?";
                $stmt = $conn->prepare($select);
                $stmt->bind_param("s", $edit_FullName);
                $stmt->execute();
                $result = $stmt->get_result();

                $row_user = $result->fetch_assoc();
                $eFullName = $row_user['FullName'];
                $ePartyName = $row_user['PartyName'];
                $eImage = $row_user['Image'];
            }
        ?>
        <form action="adminPanel.php" method="POST" enctype="multipart/form-data">
            <img src="upload/<?php echo $eImage; ?>" alt="Admin" class="rounded-circle" width="150"><br>
            <input type="text" name="FullName" required placeholder="Enter Full Name" value="<?php echo $eFullName; ?>">
            <input type="text" name="PartyName" required placeholder="Enter Party Name" value="<?php echo $ePartyName; ?>"><br>
            <input type="file" name="Image"> <br>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <?php
if (isset($_POST['submit'])) {
    $FullName = $_POST['FullName'];
    $PartyName = $_POST['PartyName'];
    $Image = $_FILES['Image']['name'];
    $tmp_name = $_FILES['Image']['tmp_name'];

    $updateQuery = "UPDATE nominee SET FullName=?, PartyName=?";
    $params = array($FullName, $PartyName);

    if (!empty($Image)) {
        $updateQuery .= ", Image=?";
        $params[] = $Image;
    }

    $updateQuery .= " WHERE FullName=?";
    $params[] = $edit_FullName;

    $stmt = $conn->prepare($updateQuery);
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<h5 style='color:green;text-align:center;'>Successfully Updated</h5>";
        if (!empty($Image)) {
            move_uploaded_file($tmp_name, "upload/$Image");
        }
    } else {
        echo "<h5 style='color:red;text-align:center;'>Error: Could not update nominee</h5>";
    }
}
?>

    <button class="open-button" onclick="back()">Back</button>

    <script>
        function back() {
            window.location = "admintable.php";
        }
    </script>
</body>

</html>
