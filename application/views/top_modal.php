<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>
<!-- Latest compiled and minified CSS -->

<!-- Optional theme -->
<link rel="stylesheet" href="https://bootswatch.com/darkly/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mootools/1.6.0/mootools-core-compat.js"></script>
<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
input {
    background-color:blue;
    color: white;
}
/* Modal Content */
.modal-content {
        background-color: black;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>




<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
             <?php
     $key = file_get_contents('data/licence');
    $LICENSE_SERV = 'http://flare.miscy.net/server/check.php?key=';
    $licserv = "$LICENSE_SERV$key";

    $license = file_get_contents($licserv);

    if ($license == 'INVALID') {
        ?>
<div class="alert alert-danger">This copy that was supposed to be licenced to <?php echo file_get_contents('data/name'); ?> is not valid or licenced.</div>
<?php

    } else {
        ?>
<div class="alert alert-success">This copy is licenced to <?php echo file_get_contents('data/name'); ?> from <b>Orion</b>.</div>
<?php

    }
?>
<?php
if ($license == 'INVALID') {
    if ($_GET['p'] != 'Licence') {
        $folders = scandir('plugins');
        $pl = 0;
        foreach ($folders as $plugin) {
            $pl = $pl.'1';
        }
        if ($pl == '011111') {
            include 'application/views/panel.php'; ?>
    
    <h1>The free VERSION has expired.</h1>
    <p>If you would like to continue using this application please activate it.</p>
    <p>You can buy the full version for $13.00. Its a great offer so hurry and</p>
    <p>and activate the server.</p>
    <?php
    include 'application/views/bottom_modal.php';
            die();
        }
    }
}
?>