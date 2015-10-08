<?php
session_start();
if(isset($_POST['link'])){
$_SESSION['measurements'] = $_POST['link'];
}
else
{
    $_SESSION['measurements'] = $_POST['data'];
    $_SESSION['type'] = 'mintemp';
}
?>