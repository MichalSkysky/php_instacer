<?php

abstract class Model {

    protected static $_pdo;

    protected $_dbh;

    public $name;

    final function __construct() {
        $this->name = snake_case(get_class($this));

        if (!self::$_pdo) {
            $this->_connect();
        }

        $this->_dbh = self::$_pdo;
    }

    function tables() {
        return $this->_dbh->query('SHOW FULL TABLES WHERE Table_type = "BASE TABLE"')->fetchAll(PDO::FETCH_COLUMN);
    }

    function views() {
        return $this->_dbh->query('SHOW FULL TABLES WHERE Table_type = "VIEW"')->fetchAll(PDO::FETCH_COLUMN);
    }

    function columns() {
        return $this->_dbh->query('SHOW COLUMNS IN `' . $this->name . '`')->fetchAll(PDO::FETCH_COLUMN);
    }

    function save() {

    }

    protected function _insert() {

    }

    protected function _update() {

    }

    protected function _delete() {

    }

    protected function _connect()
    {
        $config = Config::read('database');
        $dsn = $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'];

        self::$_pdo = new PDO($dsn, $config['user'], $config['password']);
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$_pdo->query('SET NAMES UTF8');
    }
}
