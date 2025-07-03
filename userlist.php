<?php
if(!isset($_COOKIE['cookie_login'])) {
    header("location:index.php?msg = 'You are not a User.'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
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
            color: blueviolet;
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
                <div class="logo">My Logo</div>
                <a href="dashboard.php">🏠 Home</a>
                <a href="#">👥 User List</a>
                <a href="logout.php">↩️ Logout</a>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 p-4">
                <h1>Welcome <span class="span"><?php echo $_COOKIE['cookie_username'];?></span> to Dashboard Page</h1>
                
                <?php
                if(isset($_GET['']))
                ?>

            </div>
        </div>
    </div>

</body>

</html>