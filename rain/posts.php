<?php
$body = '';
if (isset($_GET['success'])) {
$body .= '
    <div data-alert class="alert-box info small-8 small-offset-1 large-4 large-offset-4 columns">
  '.$_GET['success'].'
  <a href="#" class="close">&times;</a>
</div>'; 
}
include('index.php');
/*remove everything below before deployment, testing graph drawing etc*/

?>