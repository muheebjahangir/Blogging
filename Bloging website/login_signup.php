<?php
require 'config.php';

session_start();

if(  isset(  $_SESSION['email']  )  ){
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    header("Location: index.php");
}


$username = '';
$email = '';
$password = '';

$usernameErr = '';
$emailErr = '';
$passwordErr = '';

if (isset($_POST['register'])) {
    if (empty($_POST['username'])) {
        $usernameErr = "Please Enter Username";
    } else {
        $username = trim(htmlspecialchars($_POST['username']));
    }
    if (empty($_POST['email'])) {
        $emailErr = "Please Enter Your Email";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Your email format is incorrect";
    } else {
        $email = $_POST['email'];
    }
    if (empty($_POST['password'])) {
        $passwordErr = "Please provide your password";
    } elseif (strlen($_POST['password']) < 8) {
        $passwordErr = "Password should be al least 8 characters";
    } else {
        $password = $_POST['password'];
    }
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr)) {

        $query = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_num_rows($result);

        if ($row > 0) {
            $emailErr = "Email is already in used";
        } else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username,email, pass) VALUES ('$username', '$email', '$hashPassword'  )";
            $result = mysqli_query($connection, $query);

            if ($result == true) {
                $successMsg = "Your account has been created!";
            } else {
                $emailErr = "Something went wrong";
            }
        }

        if ($result == true) {
            echo "<script>alert('Created Your Account')</script>";
        } else {
            echo "<script>alert('Someting went wrong')</script>";
        }
    }
}

// Login System

// session_start();

// if (isset($_SESSION['email']) == true) {
//     header('Location: index.php');
// }


if (isset($_POST['login'])) {

    
    $email_login = $_POST['email_login'];
    $password_login = $_POST['password_login'];




    $query = "SELECT * FROM users WHERE email = '$email_login'";
    $result =  mysqli_query($connection, $query);
    $row = mysqli_num_rows($result);

    if ($result == true   &&   $row > 0) {
        $data = mysqli_fetch_assoc($result);
        $dbPassword = $data['pass'];

        if (password_verify(    $password_login,  $dbPassword)) {


            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            header('Location: index.php');
        } else {
            $passwordErr = "Incorrect password";
        }
    } else {
        $emailErr = "No record found for this email";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Form</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="container">
        <div class="form-box login">

            <form method="post">
                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" name="username">
                    <i class='bx bxs-user'></i>
                    <span><?php echo $usernameErr ?></span>
                </div>
                <div class="input-box">
                    <input type="email" placeholder="Email" name="email">
                    <i class='bx bxs-envelope'></i>
                    <span><?php echo $emailErr ?></span>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" name="password" autocomplete="off">
                    <i class='bx bxs-lock-alt'></i>
                    <span><?php echo $passwordErr ?></span>
                </div>
                <button type="#" class="btn" name="register">Register</button>
                <p>or register with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <form method="post">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="email" placeholder="Email" required name="email_login">
                    <i class='bx bxs-user'></i>

                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" required name="password_login">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                   
                  <a href='forget.php'>Forgot Password?</a>
                  
                </div>
                <button type="submit" class="btn" name="login">Login</button>
                <p>or login with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                </div>
            </form>
        </div>

        <div class="toggle-box">

            <div class="toggle-panel toggle-left">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>

            </div>

            <div class="toggle-panel toggle-right">
                <h1>Hello, Welcome!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>

        </div>
    </div>

    <script>
        const container = document.querySelector('.container');
        const registerBtn = document.querySelector('.register-btn');
        const loginBtn = document.querySelector('.login-btn');

        registerBtn.addEventListener('click', () => {
            container.classList.remove('active');
        })

        loginBtn.addEventListener('click', () => {
            container.classList.add('active');
        })
    </script>
</body>

</html>