<?php
include_once('sendauth.php');
Authorization::send_auth($_SESSION['id']);
header('Location: /authorize');