<?php
require_once("class/classUser.php");
session_start();
$user = new User();
if(isset($_SESSION['username']) and isset($_SESSION['status']) and isset($_SESSION['id']))
{
    header('Location: index.php');
}
else
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investing</title>
</head>
<body>
    <h1>Join Us</h1>
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="info.php">Info</a></li>
    <li><a href="news.php">News</a></li>
    <li><a href="register.php">Join Us!</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="contact.php">Contact Us!</a></li>
    </ul>
    <hr>
    <h2>Registration</h2>
    <div id="register">
    <form action="register.php" method="POST">
    <input type="email" name="email" id="email" placeholder="Email"><br><br>
    <input type="text" name="username" id="username" placeholder="Username"><br><br>
    <input type="password" name="password" id="password" placeholder="Password"><br><br>
    <input type="password" name="password2" id="password2" placeholder="Confirm Your Password"><br><br>
    <input type="radio" id="radio" name="radio" value="male" checked>
    <label for="huey">Male</label><br>
    <input type="radio" id="radio" name="radio" value="female">
    <label for="huey">Female</label><br><br>
    <button>Register</button>
    </form>
    </div>
    <div>
    <p>Already a member? Click <a href="login.php">Here!</a></p>
    </div>
    <?php
    if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['password2']) and isset($_POST['username']))
        {
            if($_POST['email']!="" and $_POST['password']!="" and $_POST['username']!="" and $_POST['password2']!="")
                {
                    $email=$_POST['email'];
                    $username=$_POST['username'];
                    $password=$_POST['password'];
                    $password2=$_POST['password2'];
                    $radio=$_POST['radio'];
                    $register = $user->register($email, $username,$password, $password2, $radio);
                }
            else echo "<p>All fields are required</p>";
        }
    ?>
</body>
</html>
<?php
}
unset($db);
?>