<?php
<<<<<<< HEAD
include_once('sendauth.php');
Authorization::send_auth($_SESSION['id']);
=======
include_once('userinfo.php');
UserInfo::send_auth($_SESSION['id']);
>>>>>>> e0fd626e40a30e329c84a54a8a7815ef696795e5
header('Location: /authorize');