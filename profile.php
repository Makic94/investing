<?php
include_once("class/classUser.php");
$user = new User();
session_start();
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
    <li><a href="contact.php">Contact Us!</a></li>
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
    <li><a href="post.php">Create a Topic</a></li>
    <li><a href="approveDelete.php">Approve or Delete a Topic</a></li>
    <li><a href="logout.php">Logout</a></li>
    </ul>
    <hr>
    </div>
    <?php
        }
    ?>
    <h2>Edit your Profile</h2>
    <p>You can change your username down bellow!</p>
    <p>Your current username is <?php echo $_SESSION['username']."."; ?></p>
    <form action="profile.php" method="POST">
    <input type="text" name="username" placeholder="Username"><br><br>
    <button>Change</button>
    </form>
    <?php
    if(isset($_POST['username']))
        {
            if($_POST['username']!="")
                {
                    $username=$_POST['username'];
                    $namechange = $user->username($username);
                }
            else echo "<p>All fields are required</p>";
        }
    ?>
    <?php
    }
    else header('Location: register.php');
    ?>
    <?php
    unset($db);
    ?>
</body>
</html>