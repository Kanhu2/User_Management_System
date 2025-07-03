<?php
session_start();

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
// print_r($_POST);

if (isset($_POST['action']) && $_POST['action'] == 'sendOtp') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $otp = $_POST['otp'];

    $select = "SELECT * FROM user_login WHERE email = '$email';";
    $result = mysqli_query($db, $select);
    // print_r($result);
    // die;

    if ($row = mysqli_fetch_array($result)) {
        $email_id = $row['email'];
        $pass = $row['password'];   //database password stored

        if (password_verify($password, $pass)) {
            // $_SESSION['session_username'] = $user;
            $_SESSION['session_login'] = true;

            $random_no = rand(1000, 9999); //generate random no between 1000 and 9999
            $_SESSION['inputotp'] = $random_no;
            $_SESSION['email'] = $email_id;
            
            $update = "UPDATE user_login SET otp = '$random_no' WHERE email = '$email'";
            mysqli_query($db, $update);
            
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
                $mail->setFrom('jyotiprakashkanhu914@gmail.com', 'verify');
                $mail->addAddress($email, $password);     //Add a recipient

                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = 'Verify <b>OTP</b> is ' . $random_no;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if ($mail->send()) {
                    echo 'OTP has been sent successfully';
                } else {
                    echo "OTP could not be sent.";
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Email not found";
    }
}

if (isset($_POST['action']) && $_POST['action'] == "verify_otp") {
    // print_r($_POST['action']);
    $email = $_POST['email'];
    $enter_otp = $_POST['otp'];
    // print_r($enter_otp);
    $select = "SELECT otp FROM user_login WHERE email = '$email'";
    $result = mysqli_query($db, $select);

    if ($row = mysqli_fetch_array($result)) {
        $otp = $row['otp'];
        // print_r($otp);
        if ($enter_otp == $otp) {
            echo "success";
        } else {
            echo "failed";
        }
    }
}
