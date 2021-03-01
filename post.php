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
    {
        if($_SESSION['status']!='owner')
        {
    ?>
    <h1>Create a Topic</h1>
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
            <form action="post.php" method="POST" enctype="multipart/form-data">
            <select name="category" id="category">
            <option value="0">Select a Category</option>
            <?php 
            $upit="SELECT * FROM categories";
            $rez=$db->query($upit);
            while($red=$db->fetch_object($rez))
                {
                echo "<option value=$red->id>".$red->name."</option>";
                }
            ?>
            </select><br><br>
            <input type="text" name="title" id="title" placeholder="Title"><br><br>
            <textarea name="text" id="text" cols="30" rows="10"></textarea><br><br>
            <input type="file" name="upload" id="upload"><br><br>
            <button>Submit</button>
            </form>
            <?php
            if(isset($_POST['category']) and isset($_POST['title']) and isset($_POST['text']) and isset($_FILES['upload']['name']))
                {
                    if($_POST['category']!=0 and $_POST['title']!="" and $_POST['text']!="" and $_FILES['upload']['name']!="")
                        {
                            $author=$_SESSION['id'];
                            $category=$_POST['category'];
                            $title=$_POST['title'];
                            $text=$_POST['text'];
                            $name="tmpuserimages/".microtime(true).".".pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
                            $tmp=$_FILES['upload']['tmp_name'];
                            $error=$_FILES['upload']['error'];
                            $size=$_FILES['upload']['size'];
                            $title=filter_var($title, FILTER_SANITIZE_STRING);
                            $text=filter_var($text, FILTER_SANITIZE_STRING);
                                if($title!="" and $text!="")
                                    {
                                        if(strlen($title)<30)
                                            {
                                                if($size<2000000)
                                                    {
                                                        $formats=["jpg", "jpeg", "webp", "png"];
                                                        if(in_array(pathinfo($name, PATHINFO_EXTENSION), $formats))
                                                            {
                                                                $picture=getimagesize($tmp);
                                                                if($picture)
                                                                    {
                                                                        if($picture[0]<=800 and $picture[1]<=600)
                                                                            {
                                                                                if(@move_uploaded_file($tmp, $name))
                                                                                    {
                                                                                        $upit="INSERT INTO news (category,author,title,text,deleted) VALUES ($category,$author,'$title','$text',1)";
                                                                                        $db->query($upit);
                                                                                        $upit="SELECT id FROM news WHERE title='$title'";
                                                                                        $rez=$db->query($upit);
                                                                                        while($red=$db->fetch_object($rez))
                                                                                            {
                                                                                                $upit="INSERT INTO images (newsid,name,path) VALUES ($red->id, '$tmp', '$name')";
                                                                                                $db->query($upit);
                                                                                                echo "<p>Your post has been successfully uploaded. It is pending approval.</p>";
                                                                                            }
                                                                                    }
                                                                                else echo "<p>Error while uploading the image on server.</p>";
                                                                            }
                                                                        else echo "<p>Image is should not be larger than 800x600 format.</p>";
                                                                    }
                                                            }
                                                            else 
                                                            {
                                                            echo "The file is not correct format. Supported formats are: ";
                                                                for($i=0;$i<count($formats);$i++)
                                                                    {
                                                                        echo $formats[$i]." ";
                                                                    }
                                                                echo ".";
                                                            }
                                                    }
                                                else echo "<p>Image should not be larger than 2 MB.</p>";
                                            }
                                        else echo "<p>Title can not be longer than 30 characters!</p>";
                                    }
                                else echo "<p>Blank space is not allowed.</p>";
                        }
                    else echo "<p>All fields are required.</p>";
                }
            ?>
    <?php
    } else 
        {
    ?>
    <h1>Create a Topic</h1>
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
    <form action="post.php" method="POST" enctype="multipart/form-data">
            <select name="category" id="category">
            <option value="0">Select a Category</option>
            <?php 
            $upit="SELECT * FROM categories";
            $rez=$db->query($upit);
            while($red=$db->fetch_object($rez))
                {
                echo "<option value=$red->id>".$red->name."</option>";
                }
            ?>
            </select><br><br>
            <input type="text" name="title" id="title" placeholder="Title"><br><br>
            <textarea name="text" id="text" cols="30" rows="10"></textarea><br><br>
            <input type="file" name="upload" id="upload"><br><br>
            <button>Submit</button>
            </form>
            <?php
            if(isset($_POST['category']) and isset($_POST['title']) and isset($_POST['text']) and isset($_FILES['upload']['name']))
                {
                    if($_POST['category']!=0 and $_POST['title']!="" and $_POST['text']!="" and $_FILES['upload']['name']!="")
                        {
                            $author=$_SESSION['id'];
                            $category=$_POST['category'];
                            $title=$_POST['title'];
                            $text=$_POST['text'];
                            $name="server/".microtime(true).".".pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
                            $tmp=$_FILES['upload']['tmp_name'];
                            $error=$_FILES['upload']['error'];
                            $size=$_FILES['upload']['size'];
                            $title=filter_var($title, FILTER_SANITIZE_STRING);
                            $text=filter_var($text, FILTER_SANITIZE_STRING);
                                if($title!="" and $text!="")
                                    {
                                        if(strlen($title)<30)
                                            {
                                                if($size<2000000)
                                                    {
                                                        $formats=["jpg", "jpeg", "webp", "png"];
                                                        if(in_array(pathinfo($name, PATHINFO_EXTENSION), $formats))
                                                            {
                                                                $picture=getimagesize($tmp);
                                                                if($picture)
                                                                    {
                                                                        if($picture[0]<=800 and $picture[1]<=600)
                                                                            {
                                                                                if(@move_uploaded_file($tmp, $name))
                                                                                    {
                                                                                        $upit="INSERT INTO news (category,author,title,text) VALUES ($category,$author,'$title','$text')";
                                                                                        $db->query($upit);
                                                                                        $upit="SELECT id FROM news WHERE title='$title'";
                                                                                        $rez=$db->query($upit);
                                                                                        while($red=$db->fetch_object($rez))
                                                                                            {
                                                                                                $upit="INSERT INTO images (newsid,name,path) VALUES ($red->id, '$tmp', '$name')";
                                                                                                $db->query($upit);
                                                                                                echo "<p>Your post has been successfully uploaded.</p>";
                                                                                            }
                                                                                    }
                                                                                else echo "<p>Error while uploading image on the server.</p>";
                                                                            }
                                                                        else echo "<p>Image should not be larger than 800x600 format.</p>";
                                                                    }
                                                            }
                                                            else 
                                                            {
                                                            echo "Uploaded file is not the correct format. Supported formats are: ";
                                                                for($i=0;$i<count($formats);$i++)
                                                                    {
                                                                        echo $formats[$i]." ";
                                                                    }
                                                                echo ".";
                                                            }
                                                    }
                                                else echo "<p>Image should not be larger than 2 MB.</p>";
                                            }
                                        else echo "<p>Title can not be longer than 30 characters!</p>";
                                    }
                                else echo "<p>Blank space is not allowed.</p>";
                        }
                    else echo "<p>All fields are required.</p>";
                }
            ?>
    <?php
        }
    ?>
    <?php
    }
    else {
        header('Location: register.php');
    }
    ?>
</body>
</html>
<?php
unset($db);
?>