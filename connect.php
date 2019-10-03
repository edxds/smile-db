<?php
require_once "classes/Session.php";

$session = Session::getInstance();
$host = $_POST["conn_host"];
$username = $_POST["conn_user"];
$password = $_POST["conn_pass"];

if (isset($host) && isset($username) && isset($password)) {
    $session->setConnectionCredentials($host, $username, $password);
} else {
    header("Location: connect.html");
    exit();
}

header("Location: index.php");
exit();
