<?php
include('connection.php');

if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];
} else {
    $sid = "";
}

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
} else {
    $mode = "";
}

if ($mode == "edit" && $sid != "") {
    $sql = "SELECT * FROM user_login WHERE id = '$sid';";
    $result = mysqli_query($db, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $username = $row['user_name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $address = $row['address'];
        $old_image = $row['profile'];
    }
} else {
    $username = "";
    $email = "";
    $phone = "";
    $address = "";
}

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "SELECT profile FROM user_login WHERE id = '$sid';";
    $result1 = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result1);
    $old_profile = $row['profile'];

    // //delete old photo from folder
    // $old_path = "uploads/" . $old_profile;
    // if (file_exists($old_path)) {
    //     unlink($old_path);
    // }
    $new_profile = $_FILES['new_profile']['name'];
    if (!$new_profile == "") {
        // delete old photo from folder
        $old_path = "uploads/" . $old_profile;
        if (file_exists($old_path)) {
            unlink($old_path);
        }
        $new_profile_name = time() . "_" . $new_profile;
    } else {
        $new_profile_name = $old_profile;
    }
    // $new_profile = $_FILES['new_profile']['name'];
    // $new_profile_name = time() . "_" . $new_profile;

    $tmp_name = $_FILES['new_profile']['tmp_name'];
    $target_path = "uploads/" . $new_profile_name;
    move_uploaded_file($tmp_name, $target_path);

    $update = "UPDATE user_login SET user_name = '$username', email = '$email', phone = '$phone', 
    address = '$address', profile = '$new_profile_name' WHERE id = '$sid';";
    $result = mysqli_query($db, $update);

    if ($result) {
        echo "<script>alert('Data Updated Successfully.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Data is not updated.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Page</title>

    <link rel="icon" type="image/x-icon" href="images/edit_user_icon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function checkUsername(uname) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    res = this.responseText;
                    if (res == 1) {
                        alert("This username already exists.");
                        document.getElementById("username").value = "";
                    }
                }
            };
            xhttp.open("GET", "ajax.php?uname=" + uname, true);
            xhttp.send();
        }

    </script>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-5">
                <h2 class="text-center mb-4">User Update Page</h2>

                <div class="card shadow-lg rounded-4 p-4">
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" required onblur="checkUsername(this.value);">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" readonly required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>" placeholder="please enter valid 10 digit phone number" pattern="[6-9][0-9]{9}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <textarea class="form-control" name="address" id="address" rows="3" required><?php echo $address; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="profile" class="form-label">Profile:</label>
                            <input type="file" class="form-control" name="new_profile" id="profile">
                        </div>

                        <input type="text" name="old_image" id="old_image" value="<?php echo $old_image; ?>"> <br><br>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary px-4" value="Update" name="update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>