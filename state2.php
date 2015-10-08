<?php
session_start();
if(isset($_POST['link']) && isset($_POST['type'])){
$_SESSION['measurements'] = $_POST['link'];
$_SESSION['type'] = $_POST['type'];
}

?>