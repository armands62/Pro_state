<?php
include_once('userinfo.php');
UserInfo::send_auth($_SESSION['id']);
header('Location: /authorize');