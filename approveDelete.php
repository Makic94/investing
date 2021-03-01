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
    if (isset($_SESSION['id']) and isset($_SESSION['status']) and isset($_SESSION['username']) and $_SESSION['status']=='owner')
    {
    ?>
    <h1>Approve or Delete</h1>
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
    <p>Selecet a news category you would like to see</p>
    <form action="approveDelete.php" method="GET">
    <select name="category" id="category">
    <option value="0">Select a Category</option>
    <?php 
    $upit="SELECT * FROM categories";
    $rez=$db->query($upit);
    while($red=$db->fetch_object($rez)){
    echo "<option value=$red->id>".$red->name."</option>";
    }
    ?>
    </select><br><br>
    <button>Select</button>
    <?php
        if(isset($_GET['category']))
            {
                if($_GET['category']!=0)
                {
                    $category=$_GET['category'];
                    $upit="SELECT * FROM vnews WHERE deleted=1 and category='$category'";
                    $rez=$db->query($upit);
                    while($red=$db->fetch_object($rez))
                    {
                        echo "<div style='border: 1px solid black; width:300px'>";
                        echo "<h3><a href='approveDelete.php?id=".$red->id."'>".$red->title."</a></h3>";
                        echo "<p>".$red->text."</p>";
                        $upit2="SELECT * FROM images WHERE newsid=$red->id";
                        $rez2=$db->query($upit2);
                        while($red2=$db->fetch_object($rez2))
                            {
                                echo "<img src={$red2->path} width='100' height='100'>";
                            }
                        echo "<p>Author: ".$red->username.". Created: <i>".$red->time."</i></p>";
                        echo "</div>";
                        echo "<p></p>";
                    }

                }
                else echo "<p>You must select a category to view the news.</p>";
            }
            if(isset($_GET['id']))
            {
            if($_GET['id']!=0)
                {
                    $upit="SELECT * FROM vnews WHERE deleted=1 and id=".$_GET['id'];
                    $rez=$db->query($upit);
                            while($red=$db->fetch_object($rez))
                            {
                                echo "<div style='border: 1px solid black; width:400px'>";
                                echo "<h3><a href='approveDelete.php?id=".$red->id."'>".$red->title."</a></h3>";
                                echo "<p>".$red->text."</p>";
                                $upit2="SELECT * FROM images WHERE newsid=$red->id";
                                $rez2=$db->query($upit2);
                                while($red2=$db->fetch_object($rez2))
                                    {
                                        echo "<img src={$red2->path} width='380' height='250'>";
                                    }
                                echo "<p>Author: ".$red->username.". Created: <i>".$red->time."</i></p>";
                                echo "</div>";
                            } ?>
                                
                            <?php
                }
            else echo "<p>Unable to find the given news id.<p>";
            }
    ?>
    <?php
    }
    else header('Location: index.php');
?>
</body>
</html>