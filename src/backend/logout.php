<?php
include_once('userinfo.php');
UserInfo::send_activity_registry($_SESSION['id'], 'logout', 1);
session_destroy();
header("Location: /");
exit();