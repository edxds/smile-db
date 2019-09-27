<?php
class MainViewModel {
    private $host;

    private $selected_db;
    private $selected_table;

    private $should_redirect_to_connect;
    private $page_title;

    private $host_name;

    private $has_selected_db;
    private $has_selected_table;

    private $db_names;
    private $table_names;

    public function __construct($selected_db = NULL, $selected_table = NULL) {
        $session = Session::getInstance();

        $this->should_redirect_to_connect = !$session->areCredentialsSet();
        if (!$session->areCredentialsSet())
            return;

        $this->host = Session::getInstance()->getHost();
        $this->host_name = $this->host->getHostName();

        $this->selected_db = $selected_db;
        $this->selected_table = $selected_table;

        $this->has_selected_db = isset($this->selected_db);
        $this->has_selected_table = isset($this->selected_table);

        $this->db_names = $this->host->fetchDatabaseNames();

        if ($this->has_selected_db) {
            $this->host->useDatabase($selected_db);
            $this->table_names = $this->host->fetchDatabaseTableNames();
        }

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
}