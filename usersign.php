<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

include('connection.php');
if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profile = $_FILES['profile']['name'];

    $currentTime = time();
    $new_photo_name = $currentTime . "." . $profile;

    $profile_tmp = $_FILES['profile']['tmp_name'];
    $target_file = "uploads/" . $new_photo_name;
    move_uploaded_file($profile_tmp, $target_file);

    $validate_email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($validate_email) {

        $insert = "INSERT INTO user_login(user_name, password, email, phone, address, profile)
            VALUES('$username', '$hash_password', '$email', '$phone', '$address', '$new_photo_name')";
        $result = mysqli_query($db, $insert);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'jyotiprakashkanhu914@gmail.com';                     //SMTP username
            $mail->Password   = 'yauu gfyg yqho eeyg';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jyotiprakashkanhu914@gmail.com', 'Mailer');
            $mail->addAddress($email, $username);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the message body for your signin <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if ($mail->send()) {
                echo 'Message has been sent successfully';
            } else {
                echo "Message could not be sent.";
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        if ($result) {
            header("location:index.php");
        } else {
            header("location:usersign.php");
        }
    } else {
        echo "<script>alert('Please enter valid email'); window.location.href='usersign.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin Page</title>

    <link rel="icon" type="image/x-icon" href="images/signin_icon.png">

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

        function checkEmail(email) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    res = this.responseText;
                    if (res == 1) {
                        alert("This email already exists.");
                        document.getElementById("email").value = "";
                    }
                }
            };
            xhttp.open("GET", "ajax.php?email=" + email, true);
            xhttp.send();
        }
    </script>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-5">
                <h2 class="text-center mb-4">User Signin Page</h2>

                <div class="card shadow-lg rounded-4 p-4">
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" name="username" id="username" required onblur="checkUsername(this.value);">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required onblur="checkEmail(this.value);">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="please enter valid 10 digit phone number" pattern="[6-9][0-9]{9}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="profile" class="form-label">Profile:</label>
                            <input type="file" class="form-control" name="profile" id="profile" required>
                        </div>

                        <div class="text-center">
                            <input type="submit" class="btn btn-primary px-4" value="Signin" name="signin">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>