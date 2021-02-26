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
    <h1>Approve or Delete</h1>
</body>
</html>