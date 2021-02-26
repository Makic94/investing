<?php
session_start();
require_once("class/classBase.php");
$db=new Base();
if(!$db->connect())exit();
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
    <?php
    if(isset($_SESSION['username']) and isset($_SESSION['status']) and isset($_SESSION['id']))
        { if($_SESSION['status']!='owner')
            {
    ?>
    <h1>Profile</h1>
    <div class="click">
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="info.php">Info</a></li>
    <li><a href="news.php">News</a></li>
    <li><a href="profile.php">Profile</a></li>
    <li><a href="support.php">Support</a></li>
    <li><a href="post.php">Create a Topic</a></li>
    <li><a href="logout.php">Logout</a></li>
    </ul>
    <hr>
    </div>
    <?php
        }
        else
        {
    ?>
    <h1>Profile</h1>
    <div class="click">
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="info.php">Info</a></li>
    <li><a href="news.php">News</a></li>
    <li><a href="profile.php">Profile</a></li>
    <li><a href="users.php">Users</a></li>
    <li><a href="post.php">Create a Topic</a></li>
    <li><a href="approveDelete.php">Approve or Delete a Topic</a></li>
    <li><a href="logout.php">Logout</a></li>
    </ul>
    <hr>
    </div>
    <?php
        }
    ?>
    <?php
    }
    else header('Location: register.php');
    ?>
    <h2>Edit your Profile</h2>
    <?php
    unset($db);
    ?>
</body>
</html>