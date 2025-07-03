<?php
session_start();

include('connection.php');

if (isset($_REQUEST['msg']) != "") {
    $msg = $_REQUEST['msg'];
} else {
    $msg = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login with OTP</title>

    <link rel="icon" type="image/x-icon" href="images/login_icon.png">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="bg-light">
    <h1 style="text-align: center; color:red;"><?php echo $msg; ?></h1>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Login Page</h3>

                        <form method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required />
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required />
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" name="input_otp" id="input_otp" placeholder="Enter otp">
                            </div>

                            <div class="d-grid" id="one">
                                <button type="button" class="btn btn-primary" name="sendOtp" id="sendOtp">Send OTP</button>
                            </div>
                            <div class="d-grid" id="two" style="display: none;">
                                <button type="button" class="btn btn-primary" name="verifyotp" id="verifyotp" style="display: none;">Verify OTP</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="usersign.php" class="text-decoration-none">Create New User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#input_otp').hide();
            $('#sendOtp').click(function() {
                // console.log("one");
                var email = $('#email').val();
                var password = $('#password').val();
                $.ajax({
                    url: 'send_otp.php',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        action: 'sendOtp'
                    },
                    success: function(response) {
                        // alert(response);
                        //     $('#sendOtp').attr('id', 'verifyotp').text('Verify OTP');
                        //     $('#verifyotp').attr('name', 'verifyotp');
                        if (response === 'OTP has been sent successfully') {
                            alert(response);
                            $('#input_otp').show();
                            $('#verifyotp').css('display', 'block');
                            $('#sendOtp').css('display', 'none');
                        } else {
                            alert(response);
                        }
                    }
                });
            });

            $('#verifyotp').click(function() {
                // console.log("Two");
                var email = $('#email').val();
                var password = $('#password').val();
                var otp = $('#input_otp').val();

                $.ajax({
                    url: 'send_otp.php',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        otp: otp,
                        action: 'verify_otp'
                    },
                    success: function(response) {
                        if (response === 'success') {
                            alert('OTP Verified!!!');
                            window.location.href = 'dashboard.php';
                        } else {
                            alert('OTP does not match');
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>