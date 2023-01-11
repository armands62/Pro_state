<?php
if(empty($_GET['id'])) {
    header('Location: /admin_requests');
    exit();
}
include_once('dbconn.php');
$dbconn = new dbconn();
$con = $dbconn->db();

if($stmt = $con->prepare('DELETE FROM `request` WHERE `id` = ?')) {
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
}

header('Location: /admin_requests');