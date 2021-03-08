<?php
include_once("classBase.php");
class User{
public function register($email, $username, $password, $password2, $radio)
    {
    $clean_email=filter_var($email,FILTER_SANITIZE_EMAIL);
    if(filter_var($clean_email,FILTER_VALIDATE_EMAIL))
    {
        $clean_email=strtolower($clean_email);

                    if(strlen($clean_email)<30)
                        {
                            if($password==$password2)
                                {
                                    if(strlen($password)>8)
                                        {
                                            if(strpos($password, " ")===false)
                                                {
                                                    if(strcspn($password, '+-,.!@#$&*^?')!=mb_strlen($password))
                                                        {   
                                                            $password=filter_var($password, FILTER_SANITIZE_STRING);
                                                            if($password!="")
                                                                {
                                                                    $password=password_hash($password, PASSWORD_DEFAULT);
                                                                    $username=filter_var($username, FILTER_SANITIZE_STRING);
                                                                    $username=strtolower($username);
                                                                                $db=new Base();
                                                                                if(!$db->connect())exit();
                                                                                $upit="SELECT * FROM users";
                                                                                $rez=$db->query($upit);
                                                                                $rows=$db->num_rows($rez);
                                                                                if($rows!=0)
                                                                                {
                                                                                    while($red=$db->fetch_assoc($rez))
                                                                                        {
                                                                                            if($clean_email!=$red['email'])
                                                                                            {
                                                                                            if($username!=strtolower($red['username']))
                                                                                            {
                                                                                                if($radio=='male')
                                                                                                    {
                                                                                                        $clean_email = preg_replace('/\s+/', ' ', $clean_email);
                                                                                                        $username = str_replace(' ', '', $username);
                                                                                                        $upit="INSERT INTO users (username,email,password,gender) VALUES ('{$username}','{$email}', '{$password}', 'male')";
                                                                                                        $db->query($upit); 
                                                                                                        $upit="SELECT * FROM users WHERE username='$username'";
                                                                                                        $rez=$db->query($upit);
                                                                                                        while($red=$db->fetch_assoc($rez))
                                                                                                        {
                                                                                                        session_start();
                                                                                                        $_SESSION['id']=$red['id'];
                                                                                                        $_SESSION['username']=$red['username'];
                                                                                                        $_SESSION['status']=$red['status'];
                                                                                                        header('Location: index.php');
                                                                                                        }
                                                                                                    }
                                                                                                else
                                                                                                    {
                                                                                                        $clean_email = preg_replace('/\s+/', ' ', $clean_email);
                                                                                                        $username = str_replace(' ', '', $username);
                                                                                                        $upit="INSERT INTO users (username,email,password,gender) VALUES ('{$username}','{$email}', '{$password}', 'female')";
                                                                                                        $db->query($upit); 
                                                                                                        $upit="SELECT * FROM users WHERE username='$username'";
                                                                                                        $rez=$db->query($upit);
                                                                                                        while($red=$db->fetch_assoc($rez))
                                                                                                        {
                                                                                                        session_start();
                                                                                                        $_SESSION['id']=$red['id'];
                                                                                                        $_SESSION['username']=$red['username'];
                                                                                                        $_SESSION['status']=$red['status'];
                                                                                                        header('Location: index.php');
                                                                                                        }
                                                                                                    }
                                                                                                
                                                                                            }
                                                                                            else {echo "<p>This username ".$username." already exists. Please change.</p>"; exit();}
                                                                                            }
                                                                                            else {echo "<p>Email is already in use. Please enter another email adress.</p>"; exit();}
                                                                                        }
                                                                                }
                                                                            else
                                                                                {
                                                                                    if($radio=='male')
                                                                                        {
                                                                                            $upit="INSERT INTO users (username,email,password,gender) VALUES ('{$username}','{$email}', '{$password}', 'male')";
                                                                                            $db->query($upit); 
                                                                                            $upit="SELECT * FROM users WHERE username='$username'";
                                                                                            $rez=$db->query($upit);
                                                                                            while($red=$db->fetch_assoc($rez))
                                                                                            {
                                                                                            $_SESSION['id']=$red['id'];
                                                                                            $_SESSION['username']=$red['username'];
                                                                                            $_SESSION['status']=$red->status;
                                                                                            header('Location: index.php');  
                                                                                            }
                                                                                        }
                                                                                    else
                                                                                        {
                                                                                            $upit="INSERT INTO users (username,email,password,gender) VALUES ('{$username}','{$email}', '{$password}', 'female')";
                                                                                            $db->query($upit); 
                                                                                            $upit="SELECT * FROM users WHERE username='$username'";
                                                                                            $rez=$db->query($upit);
                                                                                            while($red=$db->fetch_assoc($rez))
                                                                                            {
                                                                                            $_SESSION['id']=$red['id'];
                                                                                            $_SESSION['username']=$red['username'];
                                                                                            $_SESSION['status']=$red->status;
                                                                                            header('Location: index.php');  
                                                                                            }
                                                                                        }
                                                                                    
                                                                                }  
                                                                }
                                                            else echo "<p>Invalid password.</p>";
                                                        }
                                                    else echo "<p>Password must have some of special carracters +-,!#$&*^.</p>";
                                                }
                                            else echo "<p>Password can't contain any blank space.</p>";
                                        }
                                    else echo "<p>Password should have more than 8 characters.</p>";
                                }
                            else echo "<p>Password does not match.</p>";
                        }
                    else echo "<p>Email can not be longer than 20 caracters.</p>";
                }
            else echo "<p>Email is not valid.</p>";
    }

public function login($email,$password)
    {
    $clean_email=filter_var($email,FILTER_SANITIZE_EMAIL);
    if(filter_var($clean_email,FILTER_VALIDATE_EMAIL))
    {
        $clean_email=strtolower($clean_email);
                
                    if(strlen($clean_email)<30)
                        {
                              if(strlen($password)>8)
                                        {
                                            if(strpos($password, " ")===false)
                                                {
                                                    if(strcspn($password, '+-,.!@#$&*^?')!=mb_strlen($password))
                                                        {   
                                                                $db=new Base();
                                                                if(!$db->connect())exit();
                                                                $upit="SELECT * FROM users";
                                                                $rez=$db->query($upit);
                                                                $rows=$db->num_rows($rez);
                                                                if($rows!=0)
                                                                {
                                                                    $upit="SELECT * FROM users where email='{$clean_email}'";
                                                                    $rez=$db->query($upit);
                                                                    $rows=$db->num_rows($rez);
                                                                    if($rows!=0)
                                                                    {
                                                                        while($red=$db->fetch_object($rez))
                                                                    {
                                                                        if($clean_email==$red->email)
                                                                        {
                                                                        $password=filter_var($password, FILTER_SANITIZE_STRING);
                                                                        $hashPwdDb = $red->password;
                                                                        if(password_verify($password,$hashPwdDb))
                                                                            {
                                                                                session_start();
                                                                                $_SESSION['id']=$red->id;
                                                                                $_SESSION['username']=$red->username;
                                                                                $_SESSION['status']=$red->status;
                                                                                header('Location: index.php');
                                                                            }
                                                                            else {echo "<p>Wrong password, please try again.</p>"; exit();} 
                                                                        }
                                                                        else {echo "<p>This email adress is not in our database. Please try again.</p>"; exit();}
                                                                    }
                                                                    }
                                                                    else echo "<p>Unknown email adress.Please try again.</p>";
                                                                }
                                                                else echo "<p>There are no registered users. Please go to <a href='register.php'>Register Page</a> in order to register.</p>";
                                                    }    
                                                    else echo "<p>Password must have some of special carracters +-,!#$&*^.</p>";
                                            }    
                                            else echo "<p>Password can't contain any blank space.</p>";
                                    }    
                                    else echo "<p>Password should have more than 8 characters.</p>"; 
                    }    
                    else echo "<p>Email can not be longer than 20 caracters.</p>";
                } 
                else echo "<p>Email is not valid.</p>";
}
public function username($username){
    $username=filter_var($username, FILTER_SANITIZE_STRING);
    $username=strtolower($username);
    if($username!="")
        {
            $db=new Base();
            if(!$db->connect())exit();
            $upit="SELECT username FROM users where username='$username'";
            $rez=$db->query($upit);
            $rows=$db->num_rows($rez);
            if($rows==0)
                {
                    $id=$_SESSION['id'];
                    $upit="UPDATE users SET username='$username' WHERE id=$id";
                    var_dump($upit);
                    $rez=$db->query($upit);
                    var_dump($rez);
                    echo "<p>You have succesfully changed your username! Your username now is $username.</p>";
                }
            else echo "<p>This username already exists. Please try another username.</p>";
        }
}
}
?>