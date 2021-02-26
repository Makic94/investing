<?php
require_once("class/classBase.php");
require_once("functions/functions.php");
session_start();
$db=new Base();
if(!$db->connect())exit();
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
    <h1>Investing</h1>
    <div id="click">
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="info.php">Info</a></li>
    <li><a href="news.php">News</a></li>
    <li><a href="register.php">Join Us!</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="contact.php">Contact Us!</a></li>
    </ul>
    </div>
    <hr>
    <h2>Login</h2>
    <form action="login.php" method="POST">
    <input type="email" name="email" id="email" placeholder="Email"
    autocomplete="off"><br><br>
    <input type="password" name="password" id="password" placeholder="Password"><br><br>
    <button>Login</button>
    </form>
    <?php
    if(isset($_POST['email']) and isset($_POST['password']))
        {
            if($_POST['email']!="" and $_POST['password']!="")
                {
                    login();
                }
            else echo "<p>All field are required.</p>";
        }
    ?>
</body>
</html>
<?php
}
unset($db);
?>