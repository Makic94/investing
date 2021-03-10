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
    <h1>Contact Us</h1>
    <?php
    if(isset($_SESSION['username']) and isset($_SESSION['status']) and isset($_SESSION['id']))
    {
        if($_SESSION['status']=='owner')
            {
                header('Location: index.php');
            }
    
    ?>
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
    </div>
    <hr>
    <form action="contact.php" method="post">
    <input type="text" name="name" id="name" placeholder="Full name"><br><br>
    <input type="text" name="subject" id="subject" placeholder="Subject"><br><br>
    <textarea name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea><br><br>
    <button>Send</button>
    </form>
    <?php
    if(isset($_POST['name']) and isset($_POST['subject']) and isset($_POST['message']))
        {
            if($_POST['name']!="" and $_POST['subject']!="" and $_POST['message']!="")
                {
                    $name=$_POST['name'];
                    $email=$_SESSION['email'];
                    $subject=$_POST['subject'];
                    $message=$_POST['message'];
                    $clean_email=filter_var($email,FILTER_SANITIZE_EMAIL);
                    if(filter_var($clean_email,FILTER_VALIDATE_EMAIL))
                        {
                            $clean_email=strtolower($clean_email);
                            $clean_name=filter_var($name, FILTER_SANITIZE_STRING);
                            $clean_subject=filter_var($subject, FILTER_SANITIZE_STRING);
                            $clean_message=filter_var($message, FILTER_SANITIZE_STRING);
                            $mailTo="test7430@yandex.com";
                            $headers="From: ".$clean_email;
                            $txt="You have recieved an email from ".$clean_name.".\n\n".$clean_message;
                            if(!@mail($mailTo,$clean_subject,$txt,$headers))
                                {
                                    echo "<p>There was an error while sending the email, please try again later.</p>";
                                }
                            else echo "<p>Email sent. Our team will respond in 2 to 3 working days!</p>";
                        }
                    else echo "<p>Email is not valid, please try again.</p>";
                }
            else echo "<p>All fields are required!</p>";
        }
    }
    else
    {
    ?>
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="info.php">Info</a></li>
    <li><a href="news.php">News</a></li>
    <li><a href="register.php">Join Us!</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="contact.php">Contact Us!</a></li>
    </ul>
    <hr>
    <form action="contact.php" method="post">
    <input type="text" name="name" id="name" placeholder="Full name"><br><br>
    <input type="email" name="email" id="email" placeholder="Email"><br><br>
    <input type="text" name="subject" id="subject" placeholder="Subject"><br><br>
    <textarea name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea><br><br>
    <button>Send</button>
    </form>
    <?php
    if(isset($_POST['name']) and isset($_POST['email']) and isset($_POST['subject']) and isset($_POST['message']))
    {
        if($_POST['name']!="" and $_POST['email']!="" and $_POST['subject']!="" and $_POST['message']!="")
            {
                $name=$_POST['name'];
                $email=$_POST['email'];
                $subject=$_POST['subject'];
                $message=$_POST['message'];
                $clean_email=filter_var($email,FILTER_SANITIZE_EMAIL);
                if(filter_var($clean_email,FILTER_VALIDATE_EMAIL))
                    {
                        $clean_email=strtolower($clean_email);
                        $clean_name=filter_var($name, FILTER_SANITIZE_STRING);
                        $clean_subject=filter_var($subject, FILTER_SANITIZE_STRING);
                        $clean_message=filter_var($message, FILTER_SANITIZE_STRING);
                        $mailTo="test7430@yandex.com";
                        $headers="From: ".$clean_email;
                        $txt="You have recieved an email from ".$clean_name.".\n\n".$clean_message;
                        if(!@mail($mailTo,$clean_subject,$txt,$headers))
                            {
                                echo "<p>There was an error while sending the email, please try again later.</p>";
                            }
                        else echo "<p>Email sent. Our team will respond in 2 to 3 working days!</p>";
                    }
                else echo "<p>Email is not valid, please try again.</p>";
            }
        else echo "<p>All fields are required!</p>";
    }
    }
    ?>
</body>
</html>