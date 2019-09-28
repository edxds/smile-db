<?php
class MySqlHost {
  private $connection;
  private $host;

  private function __construct($host, $username, $password) {
    $this->host = $host;
    $this->connection = new mysqli("p:" . $host, $username, $password);
  }

  public static function connect($host, $username, $password) {
    return new MySqlHost($host, $username, $password);
  }

  public function getHostName() {
    return $this->host;
  }

  public function useDatabase($database_name) {
    $this->connection->select_db($database_name);
  }

  public function fetchDatabaseNames() {
    return $this->queryMetadataToArray("show databases");
  }

  public function fetchDatabaseTableNames() {
    return $this->queryMetadataToArray("show tables");
  }

  public function fetchTableColumnNames($table_name) {
    return $this->queryMetadataToArray("show columns from $table_name");
  }

  public function fetchTableState($table, $offset = 0, $limit = 10) {
    $result = $this->connection->query("select * from $table limit $offset, $limit");
    $state = array();

    while ($row = $result->fetch_assoc()) {
      $state[] = $row;
    }

    return $state;
  }

  private function queryMetadataToArray($query) {
    $result = $this->connection->query($query);
    $metadata = array();

    while ($row = $result->fetch_array(MYSQLI_NUM)) {
      $metadata[] = $row[0];
    }

    return $metadata;
  }
}