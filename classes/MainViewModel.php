<?php
require_once "MySqlHost.php";
require_once "Session.php";

class MainViewModel {
    private $host;

    private $selected_db;
    private $selected_table;
    private $row_count;


    private $current_row_offset;
    private $row_limit = 10;

    private $should_redirect_to_connect;
    private $page_title;

    private $host_name;

    private $has_selected_db;
    private $has_selected_table;

    private $db_names;
    private $table_names;

    private $should_show_next_btn;
    private $should_show_previous_btn;

    public function __construct($selected_db = NULL, $selected_table = NULL, $current_offset = 0) {
        $session = Session::getInstance();

        $this->should_redirect_to_connect = !$session->areCredentialsSet();
        if (!$session->areCredentialsSet())
            return;

        $this->host = Session::getInstance()->getHost();
        $this->host_name = $this->host->getHostName();

        $this->selected_db = $selected_db;
        $this->selected_table = $selected_table;

        $this->current_row_offset = (int) $current_offset;

        $this->has_selected_db = isset($this->selected_db);
        $this->has_selected_table = isset($this->selected_table);

        $this->db_names = $this->host->fetchDatabaseNames();

        if ($this->has_selected_db) {
            $this->host->useDatabase($selected_db);
            $this->table_names = $this->host->fetchDatabaseTableNames();
        }

        if ($this->has_selected_table) {
          $this->row_count = $this->host->fetchTableRowCount($this->selected_table);
        }

        $this->should_show_next_btn = $this->row_count - ($this->current_row_offset + $this->row_limit) > 0;
        $this->should_show_previous_btn = $this->current_row_offset != 0;

        $this->page_title = $this->has_selected_table
            ? "Conteúdo | " . $this->selected_table
            : "Início";
    }

    public function shouldRedirectToConnect() : bool {
        return $this->should_redirect_to_connect;
    }

    public function pageTitle() : string {
        return $this->page_title;
    }

    public function hostName() : string {
        return $this->host_name;
    }

    public function hasSelectedDb() : bool {
        return $this->has_selected_db;
    }

    public function hasSelectedTable() : bool {
        return $this->has_selected_table;
    }

    public function dbNames() {
        return $this->db_names;
    }

    public function tableNames() {
        return $this->table_names;
    }

    public function tableSchema() {
      return $this->host->fetchTableColumnNames($this->selected_table);
    }

    public function tableState() {
        return $this->host->fetchTableState($this->selected_table, $this->current_row_offset, $this->row_limit);
    }

    public function selectDatabaseUrl($database) {
        return "index.php?db_name=$database";
    }

    public function matchesSelectedDatabase($name) {
      return $this->selected_db == $name;
    }

    public function selectTableUrl($table) {
        return "index.php?db_name=$this->selected_db&table_name=$table";
    }

    public function matchesSelectedTable($name) {
      return $this->selected_table == $name;
    }

    public function shouldShowNextButton() {
      return $this->should_show_next_btn;
    }

    public function shouldShowPreviousButton() {
      return $this->should_show_previous_btn;
    }

    public function nextPageUrl() {
      if (!$this->should_show_next_btn) return NULL;
      return "index.php"
          . "?db_name=$this->selected_db"
          . "&table_name=$this->selected_table"
          . "&row_offset=" . ($this->current_row_offset + $this->row_limit);
    }

    public function previousPageUrl() {
      if (!$this->should_show_previous_btn) return NULL;
      return "index.php"
          . "?db_name=$this->selected_db"
          . "&table_name=$this->selected_table"
          . "&row_offset=" . ($this->current_row_offset - $this->row_limit);
    }
}