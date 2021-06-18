<?php

class Database {
    protected $dbHost = DBHOST;
    protected $dbUser = DBUSER;
    protected $dbPass = DBPASS;
    protected $dbName = DBNAME;
    protected $charset = CHARSET;
    protected $dsn = '';
    protected $dbh;

    public function __construct() {
        $dsn = "mysql:host=$this->dbHost;dbname=$this->dbName;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];
        
        try {
            $this->dbh = new PDO($dsn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}