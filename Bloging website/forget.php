<?php
require 'config.php';

$email = '';
$emailErr = '';
$token_sent = false;    

// Using PHPMailer for sending OTP email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($email, $token) {
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = false;  // Use SMTP debugging to troubleshoot email issues
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'muheebahmed2022@gmail.com'; 
        $mail->Password = 'rnri nqvr vjdd yzij';  // Use an App Password if 2FA is enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('muheebahmed2022@gmail.com', 'Muheeb Ahmed');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request for Your Blog Account';
        $mail->Body = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; }
                    .email-content { background-color: #f9f9f9; padding: 20px; border-radius: 5px; border: 1px solid #ddd; }
                    .otp-box { background-color: #4CAF50; color: white; padding: 15px; font-size: 20px; font-weight: bold; border-radius: 5px; margin-top: 10px; }
                    .footer { font-size: 12px; color: #888; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class="email-content">
                    <h2>Forgot Your Password?</h2>
                    <p>Hello,</p>
                    <p>We received a request to reset the password for your account on our blogging platform. Please use the One-Time Password (OTP) below to reset your password.</p>
                    <div class="otp-box">
                        OTP: <strong>' . $token . '</strong>
                    </div>
                    <p>The OTP is valid for the next 10 minutes. If you did not request a password reset, please ignore this email.</p>
                    <p>Best regards,<br>Your Blogging Platform Team</p>
                    <div class="footer">
                        <p>If you have any issues, feel free to contact our support at <a href="mailto:support@muheebahmed2022.com">support@muheebahmed2022.com</a>.</p>
                        <p>&copy; 2024 Your Blogging Platform. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ';
        $mail->AltBody = 'Hello, We received a request to reset the password for your account. Use the following OTP to reset your password: ' . $token . '. The OTP is valid for the next 10 minutes.';

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Password reset OTP sent successfully!';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['reset'])) {
    // Validate email
    if (empty($_POST['email'])) {
        $emailErr = 'Email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailErr = 'Please provide a valid email address';
    } else {
        $email = $_POST['email'];
    }

    // If no errors, process OTP
    if (empty($emailErr)) {
        // Direct SQL query to fetch user
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            // Generate OTP and expiry time
            $token = rand(10000, 99999);
            date_default_timezone_set("Asia/Karachi");
            $token_expiry = date('Y-m-d H:i:s', time() + 10 * 60); // 10 minutes expiry time
            
            // Update token and expiry time in DB
            $updateQuery = "UPDATE users SET token = '$token', token_expiry = '$token_expiry' WHERE email = '$email'";
            if (mysqli_query($connection, $updateQuery)) {
                sendEmail($email, $token);
                $token_sent = true;
            } else {
                echo "<script>alert('Error saving token to database.')</script>";
            }
        } else {
            echo "<script>alert('Email not found in database.')</script>";
        }
    }
}

if (isset($_POST['submit'])) {
    // Validate OTP and password reset
    $otp = $_POST['otp'];
    $pass = $_POST['password'];
    $hashPassword = password_hash($pass, PASSWORD_DEFAULT);

    // Direct SQL query to fetch user data
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $token = $row['token'];
        $token_expiry = $row['token_expiry'];
        
        // Check if OTP is valid and not expired
        if ($token === $otp && strtotime($token_expiry) > time()) {
            // Update password if OTP is valid
            $updateQuery = "UPDATE users SET pass = '$hashPassword' WHERE email = '$email'";
            if (mysqli_query($connection, $updateQuery)) {
                echo "Password has been saved.";
            } else {
                echo "Something went wrong.";
            }
        } else {
            echo "Invalid OTP or OTP has expired.";
        }
    } else {
        echo "No user found for the given email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
    <title>Forget Password</title>
</head>
<body>
   <div class="container py-5">
    <h1 class="display-3 text-center">Forget Password</h1>
    <form method="post">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Enter Email" name="email" aria-describedby="button-addon2">
            <input class="btn btn-outline-primary" type="submit" name="reset" value="Send OTP">
        </div>
        <?php 
            if (!empty($emailErr)) {
                echo "<div class='alert alert-danger' role='alert'>$emailErr</div>";
            }
        ?>
    </form>

    <?php
    if ($token_sent) {
        echo <<<HTML
        <form method="post">
            <label for="inputOTP" class="form-label">OTP</label>
            <input type="text" id="inputOTP" class="form-control" required name="otp">
            
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" id="inputPassword" class="form-control" required name="password">
            
            <div class="d-grid gap-2 col-6 mx-auto mt-3">
                <input type="submit" value="Submit" class="btn btn-outline-primary py-2" name="submit" id="submit">
            </div>
        </form>
HTML;
    }
    ?>
   </div>

</body>
</html>
