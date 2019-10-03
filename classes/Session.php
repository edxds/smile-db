<?php
class Session {
  private static $instance;

  private function __construct() {
    session_start();
  }

  public static function getInstance() {
    if (self::$instance == null) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  public function stop() {
    session_unset();
    session_destroy();
  }

  public function areCredentialsSet() {
    return isset($_SESSION["conn_host"])
        && isset($_SESSION["conn_user"])
        && isset($_SESSION["conn_pass"]);
  }

  public function setConnectionCredentials($host, $user, $pass) {
    $_SESSION["conn_host"] = $host;
    $_SESSION["conn_user"] = $user;
    $_SESSION["conn_pass"] = $pass;
  }

  public function getHost(): MySqlHost {
    return MySqlHost::connect(
      $_SESSION["conn_host"],
      $_SESSION["conn_user"],
      $_SESSION["conn_pass"]
    );
  }
}