<?php
session_start();
if (!isset($_GET['img'])) die;
if (!isset($_SESSION[$_GET['img']])) die;
$url = $_SESSION[$_GET['img']];

header("Content-type: image/jpeg");
readfile( $url );