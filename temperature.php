<?php
if (isset($_GET['success'])) {
    $body = '
    <div data-alert class="alert-box info radius small-8 small-offset-1 large-4 large-offset-4 columns">
  Temerature record added
  <a href="#" class="close">&times;</a>
</div>'; 
}
else
{
$body = '<div data-alert class="alert-box warning round small-8 small-offset-1 large-4 large-offset-4 columns">
  Temperature record not saved
  <a href="#" class="close">&times;</a>
</div>'; 
}
include('index.php');
?>