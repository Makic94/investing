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
    <h1>News</h1>
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
    </div>
    <?php
    }else
    {
    ?>
    <h1>News</h1>
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
    <?php
    }}else
    {
    ?>
    <h1>News</h1>
    <div class="click">
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="info.php">Info</a></li>
    <li><a href="news.php">News</a></li>
    <li><a href="register.php">Join Us!</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="contact.php">Contact Us!</a></li>
    </ul>
    </div>
    <?php
    }
    ?>
    <hr>
    <p>Select a news category you would like to see</p>
    <form action="news.php" method="GET">
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
    </form>
    <br>
    <?php
    if(isset($_GET['category']))
    {
        if($_GET['category']!=0)
            {
                $category=$_GET['category'];
                    $upit="SELECT * FROM vnews WHERE deleted=0 and category='{$category}' ORDER BY time DESC";
                    $rez=$db->query($upit);
                    while($red=$db->fetch_object($rez))
                    {
                        $tmp=explode(" ",$red->text);
                        $novi=array_slice($tmp, 0, 15);
                        echo "<div style='border: 1px solid black; width:300px'>";
                        echo "<h3><a href='news.php?id=".$red->id."'>".$red->title."</a></h3>";
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
        else echo "<p>You must select a category</p>";
    }
if(isset($_GET['id']))
    {
    if($_GET['id']!=0)
        {
            $id=$_GET['id'];
            setcookie("id",$id,time()+3600,"/"); //created a cookie to transfer the id for comments
            $upit="SELECT * FROM vnews WHERE deleted=0 and id=$id";
            $rez=$db->query($upit);
                    while($red=$db->fetch_object($rez))
                    {
                        echo "<div style='border: 1px solid black; width:400px'>";
                        echo "<h3><a href='news.php?id=".$red->id."'>".$red->title."</a></h3>";
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
                    <br>
                    <form action="news.php" method="post">
                    <textarea name="comment" id="coment" cols="30" rows="10" placeholder="Your comment"></textarea><br><br>
                    <button>Submit</button>
                    </form>
    <?php    }
    else echo "<p>Unable to find the given news id.<p>";
    }
    if(isset($_POST['comment']))
                {
                    if($_POST['comment']!="")
                        {
                            if(isset($_SESSION['username']) and isset($_SESSION['status']) and isset($_SESSION['id']))
                            {
                                if($_SESSION['status']!='owner')
                                    {
                                        $comment=$_POST['comment'];
                                        $comment=filter_var($comment, FILTER_SANITIZE_STRING);
                                        if($comment!="")
                                            {   
                                                $id=$_COOKIE['id'];
                                                $upit="INSERT INTO comments (news_id,comment,deleted) VALUES ($id,'$comment',1)";
                                                $rez=$db->query($upit);
                                                setcookie("id","",time()-60,"/");
                                                echo "<p>You have added a new comment.</p>";
                                            }
                                        else echo "<p>Invalid comment.Please try again.</p>";
                                    }
                                else
                                    {
                                        $comment=$_POST['comment'];
                                        $comment=filter_var($comment, FILTER_SANITIZE_STRING);
                                        if($comment!="")
                                            {
                                                $id=$_COOKIE['id'];
                                                $upit="INSERT INTO comments (news_id,comment) VALUES ($id,'$comment')";
                                                $rez=$db->query($upit);
                                                setcookie("id","",time()-60,"/");
                                                echo "<p>You have added a new comment.</p>";
                                            }
                                        else echo "<p>Invalid comment.Please try again.</p>";
                                    }
                            }
                            else echo "<p>To post a comment you will have to <a href='register.php'>Register</a> or <a href='login.php'>Login</a> first!</p>";
                        }
                    else echo "<p>Sending blank space is not allowed. Type the comment first before you send it.</p>";
                }
    ?>
    <?php
    unset($db);
    ?>
</body>
</html>