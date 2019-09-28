<?php
require_once "Session.php";

$session = Session::getInstance();
$session->stop();

header("Location: index.php");
exit();
