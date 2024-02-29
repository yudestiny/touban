<?php

class DatabaseManager
{
  private $dbh;
  private $models;

  public function connect($params)
  {

    $dbh = new pdo($params['hostnameAndDatabase'], $params['username'], $params['password']);
    if (!$dbh) {
      throw new RuntimeException('PDO接続エラー');
    }
    $this->dbh = $dbh;
  }

  public function makeDbhNull()
  {
    $this->dbh = null;
  }

  public function get($modelName)
  {
    if (!isset($this->models[$modelName])) {
       $model = new $modelName($this->dbh);
      $this->models[$modelName] = $model;
    }
    return $this->models[$modelName];
  }

  public function __destruct()
  {
    $this->dbh = null;
  }
}
