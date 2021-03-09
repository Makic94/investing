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
    <p>Select a news category you would like to approve or delete</p>
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
    <button name="button" value="select">Select</button>
    <?php
        if(isset($_REQUEST['button']))
            {
                switch($_REQUEST['button'])
            {
                case 'select':
                if(isset($_GET['category']) and isset($_REQUEST['button']))
                {
                    if($_GET['category']!=0 and $_REQUEST['button']=='select')
                    {
                        $category=$_GET['category'];
                        $upit="SELECT * FROM vnews WHERE deleted=1 and category='$category' ORDER BY time DESC";
                        $rez=$db->query($upit);
                        while($red=$db->fetch_object($rez))
                        {
                            if(strlen($red->text)>20)
                            {
                                $newtext=substr($red->text,0,25);
                                echo "<div style='border: 1px solid black; width:300px'>";
                                echo "<h3><a href='approveDelete.php?id=".$red->id."&button=select'>".$red->title."</a></h3>";
                                echo "<p>$newtext...</p>";
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
                            else
                            {
                            $tmp=explode(" ",$red->text);
                            $novi=array_slice($tmp, 0, 15);
                            echo "<div style='border: 1px solid black; width:300px'>";
                            echo "<h3><a href='approveDelete.php?id=".$red->id."&button=select'>".$red->title."</a></h3>";
                            echo "<p>".implode(" ",$novi)."...</p>";
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

                    }
                    else echo "<p>You must select a category to view the news.</p>"; 
                }
                if(isset($_GET['id']) and isset($_REQUEST['button']))
                {
                if($_GET['id']!=0 and $_REQUEST['button']=='select')
                    {
                        $id=$_GET['id'];
                        setcookie("id",$id,time()+3600,"/"); //cookie created to transfer the news ID for the sql command (update/delete)
                        $upit="SELECT * FROM vnews WHERE deleted=1 and id=".$_GET['id'];
                        $rez=$db->query($upit);
                                while($red=$db->fetch_object($rez))
                                {
                                    if(strlen($red->text)>20)
                                    {
                                        $newtext=$red->text;
                                        $newtext=chunk_split($newtext, 25);
                                        echo "<div style='border: 1px solid black; width:400px'>";
                                        echo "<h3><a href='approveDelete.php?id=".$red->id."&button=select'>".$red->title."</a></h3>";
                                        echo "<p>$newtext</p>";
                                        $upit2="SELECT * FROM images WHERE newsid=$red->id";
                                        $rez2=$db->query($upit2);
                                        while($red2=$db->fetch_object($rez2))
                                            {
                                                $id=$red2->id;
                                                $path=$red2->path;
                                                setcookie("path",$path,time()+3600,"/");  //cookie created to delete the image from tmpuserimages folder or to move it to the servers folder
                                                setcookie("img",$id,time()+3600,"/"); //cookie created to transfer the image ID for the sql command (delete)
                                                echo "<img src={$red2->path} width='380' height='250'>";
                                            }
                                        echo "<p>Author: ".$red->username.". Created: <i>".$red->time."</i></p>";
                                        echo "</div>";
                                    }
                                    else
                                        {
                                            echo "<div style='border: 1px solid black; width:400px'>";
                                            echo "<h3><a href='approveDelete.php?id=".$red->id."&button=select'>".$red->title."</a></h3>";
                                            echo "<p>".$red->text."</p>";
                                            $upit2="SELECT * FROM images WHERE newsid=$red->id";
                                            $rez2=$db->query($upit2);
                                            while($red2=$db->fetch_object($rez2))
                                                {
                                                    $id=$red2->id;
                                                    $path=$red2->path;
                                                    setcookie("path",$path,time()+3600,"/");  //cookie created to delete the image from tmpuserimages folder or to move it to the servers folder
                                                    setcookie("img",$id,time()+3600,"/"); //cookie created to transfer the image ID for the sql command (delete)
                                                    echo "<img src={$red2->path} width='380' height='250'>";
                                                }
                                            echo "<p>Author: ".$red->username.". Created: <i>".$red->time."</i></p>";
                                            echo "</div>";
                                        }
                                    
                                }
                        } ?>
                                <form action="approveDelete.php" method="GET">
                                <input type="radio" id="radio" name="radio" value="approve" checked>
                                <label for="huey">Approve</label><br>
                                <input type="radio" id="radio" name="radio" value="delete">
                                <label for="huey">Delete</label><br><br>
                                <button name="button" value="submit">Submit</button>
                                </form>
                            <?php
                }
                break;
                case'submit':
                   if(isset($_GET['radio']))
                {
                    if($_GET['radio']=='approve')
                        {
                            $upit="UPDATE news SET deleted=0 WHERE id={$_COOKIE['id']}";
                            $rez=$db->query($upit);
                            $name=$_COOKIE['path'];
                            $newname=str_replace("tmpuserimages/","server/","$name");
                            $upit="UPDATE images SET path='$newname' WHERE id={$_COOKIE['img']}";
                            $rez=$db->query($upit);
                            if(!rename($name, $newname))
                            {
                                echo "<p>There was an error while moving the image to the server folder!</p>";
                            }
                            setcookie("path","",time()-60,"/");
                            setcookie("img","",time()-60,"/");
                            setcookie("id","",time()-60,"/");
                            echo "<p>Selected news are successfully approved!</p>";
                        }
                    else
                        {
                            $upit="DELETE FROM news WHERE id={$_COOKIE['id']}";
                            $rez=$db->query($upit);
                            if(!unlink($_COOKIE['path']))
                            {
                                echo "<p>There was an error while deleting the image!</p>";
                            }
                            $upit="DELETE FROM images WHERE id={$_COOKIE['img']}";
                            $rez=$db->query($upit);
                            setcookie("path","",time()-60,"/");
                            setcookie("img","",time()-60,"/");
                            setcookie("id","",time()-60,"/");
                            echo "<p>Selected news are successfully deleted!</p>";
                        }
                } 
                break;
            } 

        }
    ?>
    <?php
    }
    else header('Location: index.php');
?>
</body>
</html>
<?php
unset($db);
?>