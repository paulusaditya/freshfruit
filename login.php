<?php
session_start();

if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($db, "SELECT email FROM users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);


    if($key === hash('sha256', $row['password'])){
        $_SESSION['login'] = true;
    } 
}

if(isset($_SESSION["login"])){
    header("Location: admin/WEB/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <title>Fresh Fruit | Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        *{
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url(images/bg_2.png);
            background-repeat: no-repeat;
            background-size: 100%;
            font-family: cursive;
        }
        form {
            display: flex;
            flex-direction: column;
        }

        .login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            padding: 40px;
            margin: 20px auto;
            transform: translate(-50%, -55%);
            background: white;
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
            border-radius: 10px;
        }

        .login-box p:first-child {
            margin: 0 0 30px;
            padding: 0;
            color: #EC9F13;
            text-align: center;
            font-weight: bold;
            letter-spacing: 1px;
            font-size: 25px;
            font-weight: 600;
        }

        .login-box .user-box {
            position: relative;
        }

        .login-box .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: black;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid black;
            outline: none;
            background: transparent;
        }

        .login-box .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: black;
            pointer-events: none;
            transition: .5s;
        }

        .login-box .user-box input:focus~label,
        .login-box .user-box input:valid~label {
            top: -20px;
            left: 0;
            color: black;
            font-size: 12px;
        }

        .login-box form a {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            color: black;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 40px;
            letter-spacing: 3px
        }

        .login-box a:hover {
            background: #EC9F13;
            color: black;
            border-radius: 5px;
        }

        .login-box a span {
            position: absolute;
            display: block;
        }

        button {
            --button_radius: 0.75em;
            --button_color: #e8e8e8;
            --button_outline_color: #EC9F13;
            font-size: 17px;
            font-weight: bold;
            border: none;
            border-radius: var(--button_radius);
            background: var(--button_outline_color);
        }

        .button_top {
            display: block;
            box-sizing: border-box;
            border: 2px solid var(--button_outline_color);
            border-radius: var(--button_radius);
            padding: 0.75em 1.5em;
            background: var(--button_color);
            color: var(--button_outline_color);
            transform: translateY(-0.2em);
            transition: transform 0.1s ease;
        }

        button:hover .button_top {
            /* Pull the button upwards when hovered */
            transform: translateY(-0.33em);
        }

        button:active .button_top {
            /* Push the button downwards when pressed */
            transform: translateY(0);
        }

        .login-box p:last-child {
            color: black;
            font-size: 14px;
        }

        .login-box a.a2 {
            color: #EC9F13;
            text-decoration: none;
        }

        .login-box a.a2:hover {
            background: transparent;
            color: #aaa;
            border-radius: 5px;
        }

        .remember{
            display: flex;
            position: relative;
            bottom: 20px;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <p>Login Fresh Fruit</p>
            <form action="login1.php" method="post">
                <div class="user-box">
                    <input required="" name="email" type="text" id="email">
                    <label for="email">Email</label>
                </div>
                <div class="user-box">
                    <input required="" name="password" type="password" id="password">
                    <label for="password">Password</label>
                </div>
                <div class="remember">
                    <input name="remember" type="checkbox" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <button>
                    <span class="button_top"> Login
                    </span>
                </button>
            </form>
            <!-- <p>Don't have an account? <a href="register.php" class="a2">Register.</a></p> -->
        </div>
    </div>
</body>

</html>