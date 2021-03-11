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
    <li><a href="contact.php">Contact Us!</a></li>
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
                    }
                    echo "<hr>";
                    echo "<p>Comment section:</p>";
                    $upit="SELECT * FROM comments WHERE news_id=$id";
                    $rez=$db->query($upit);
                    while($red=$db->fetch_object($rez))
                        {
                            $commentID=$red->id;
                            $id=$red->user_id;
                            //var_dump($id);
                            //var_dump($commentID);
                            $upit2="SELECT username, id FROM users WHERE id=$id";
                            $rez2=$db->query($upit2);
                            $red2=$db->fetch_object($rez2);
                            echo "<div style='border: 1px solid black; width:250px'>";
                            echo "<p>Posted by: <b>".$red2->username."</b></p>";
                            echo "<p>".$red->comment."</p>";
                            echo "<i>".$red->time."</i>";
                            echo "</div>"; ?>
                            <?php
                            if(isset($_SESSION['id']))
                                { if($_SESSION['id']==$red2->id)
                                    {
                            ?>
                            <form action="news.php?button=delete" method="GET">
                            <button name="button" value="delete">Delete</button>
                            <input name="comment_id" value="<?php echo $red->id ?>" hidden>
                            </form>
                            <br>
                        <?php       }
                                }
                            echo "<br>";
                        }
                     ?>
                    <p>Write a comment:</p>
                    <form action="news.php" method="post">
                    <textarea name="comment" id="coment" cols="30" rows="10" placeholder="Your comment"></textarea><br><br>
                    <button>Submit</button>
                    </form>
    <?php    }
    else echo "<p>Unable to find the given news id.<p>";
    }
    if(isset($_REQUEST['button']))
        {
            switch($_REQUEST['button'])
            {
            case 'delete':
                if($_REQUEST['button']=='delete')
                    {
                        $upit="DELETE FROM comments WHERE id=".$_GET['comment_id'];
                        //var_dump($upit);
                        $rez=$db->query($upit);
                        echo "Comment deleted.";
                    }
            break;
            }
        }
    if(isset($_POST['comment']))
                {
                    if($_POST['comment']!="")
                        {
                            if(isset($_SESSION['username']) and isset($_SESSION['status']) and isset($_SESSION['id']))
                            {
                                  $comment=$_POST['comment'];
                                        $comment=filter_var($comment, FILTER_SANITIZE_STRING);
                                        if($comment!="")
                                            {
                                                $id=$_COOKIE['id'];
                                                $userID=$_SESSION['id'];
                                                $upit="INSERT INTO comments (news_id,user_id,comment) VALUES ($id,$userID,'$comment')";
                                                $rez=$db->query($upit);
                                                setcookie("id","",time()-60,"/");
                                                echo "<p>You have added a new comment.</p>";
                                            }
                                        else echo "<p>Invalid comment.Please try again.</p>";
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