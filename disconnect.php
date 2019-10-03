<?php
require_once "classes/Session.php";

$session = Session::getInstance();
$session->stop();

header("Location: index.php");
exit();
