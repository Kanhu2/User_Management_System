<?php
session_start();
include('connection.php');
if (!isset($_SESSION['session_login'])) {
    header("location:index.php?msg='You are not a User.'");
}

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

if ($mode == "delete" && $sid != "") {
    $get_photo = "SELECT profile FROM user_login WHERE id = '$sid';";
    $result = mysqli_query($db, $get_photo);
    $row = mysqli_fetch_array($result);

    $profile = $row['profile'];

    //delete photo from folder
    $file = "uploads/" . $profile;

    if (file_exists($file)) {
        unlink($file); //delete file
    }

    $sql = "DELETE FROM user_login WHERE id = '$sid';";
    mysqli_query($db, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <link rel="icon" type="image/x-icon" href="images/dashboard_icon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url("https://png.pngtree.com/background/20230401/original/pngtree-starry-sky-moon-stars-picture-image_2235480.jpg");
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #495057;
        }

        h1 {
            color: chartreuse;
            text-align: center;
            text-decoration: underline;
        }

        .span {
            color: chartreuse;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="logo">👤 My Logo</div>
                <a href="dashboard.php">🏠 Home</a>
                <a href="dashboard.php?page=userlist">👥 User List</a>
                <!-- <a href="dashboard.php?page=search">Search User</a> -->
                <a href="logout.php" onclick="return confirm('Are you sure you want to logout')">↩️ Logout</a>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 p-4">

                <h1>Welcome to Dashboard Page</h1>

                <?php
                if (isset($_GET['page']) && $_GET['page'] == 'userlist') {
                    // echo "<h2 class='text-center text-primary my-4'>Registered Users</h2>
                    //     <label for='username' class='form-label'>Username</label>
                    //     <input type='text' class='form-control' name='username' id='username'>
                    //     <input type='submit' class='btn btn-primary px-4' value='Search' name='search'><br><br>";


                    echo "
                        <h2 class='text-center text-primary mb-4'>Registered Users</h2>
        
                        <div class='row justify-content-center'>
                            <div class='col-md-6 col-lg-4'>
                                <form method='post' action=''>
                                    <div class='mb-3'>
                                        <input type='text' class='form-control' name='search_data' id='search_data' value='" . (isset($_POST['search_data']) ? $_POST['search_data'] : "") . "' required placeholder='Enter your username / phone number'>
                                    </div>
                                    <div class='mb-3 text-center'>
                                        <input type='submit' class='btn btn-primary px-4' value='Search' name='search'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    ";

                    if (isset($_POST['search'])) {
                        $search_data = $_POST['search_data'];
                        $query = "SELECT * FROM user_login WHERE BINARY user_name LIKE '%$search_data%' OR phone = '$search_data';";
                    } else {
                        $query = "SELECT * FROM user_login";
                    }
                    $result = mysqli_query($db, $query);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead class='table-dark'>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Profile</th>
                                    <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['user_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['address']}</td>
                                    <td><img src='uploads/{$row['profile']}' width='60' height='60'></td>
                                    <td><a href='update.php?sid=" . $row['id'] . "&mode=edit' style='text-decoration:none;'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href='dashboard.php?sid=" . $row['id'] . "&mode=delete' style='text-decoration:none;' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                                    </td>
                                </tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        // echo "<p class='text-danger'>No users found.</p>";
                        echo "<script>alert('No user found.');</script>";
                    }
                }
                ?>

            </div>
        </div>
    </div>

</body>

</html>