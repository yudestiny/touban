<?php

class DatabaseModel
{
  protected $dbh;

  public function __construct($dbh)
  {
    $this->dbh = $dbh;
  }

  public function beginTransaction()
  {
    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->dbh->beginTransaction();
    if (!$this->dbh->inTransaction()) {
      throw new Exception('あ');
    }
  }

  public function commit()
  {
    if (!$this->dbh->inTransaction()) {
      throw new Exception('い');
    }
    $res = $this->dbh->commit();

    if ($res) {
      $_SESSION['success_message'] = '登録に成功しました';
      return;
    } else {
      return '登録に失敗しました';
    }
  }

  public function rollBack()
  {
    if (!$this->dbh->inTransaction()) {
      throw new Exception('う');
    }
    $this->dbh->rollBack();
  }

  public function checkTableExistence($tableName)
  {
    // $sql = 'SHOW TABLES LIKE' .'\'' . "{$tableName}". '\'';
    // return $this->dbh->query($sql);
    $sql = 'SELECT 1 FROM information_schema.tables WHERE table_name = ' . '\'' . "{$tableName}". '\'';
    $query = $this->dbh->query($sql);
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($data) && array_key_exists('1', $data['0'])) {
      return true;
    }
    return false;
  }

  protected function createTable($tableName, $sql)
  {
      $this->dbh->query("DROP TABLE IF EXISTS {$tableName}");
      $this->dbh->query($sql);
  }

  protected function fetchAll($sql)
  {
    var_dump($sql);
    $results = $this->dbh->query($sql);

    if (!$results) {
      return;
    }
    return $results->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function execute($sql, $params = [])
  {
    $stmt = $this->dbh->prepare($sql);
    if ($params) {
      foreach ($params as $param) {
        $stmt->bindParam(...$param);
      }
    }

    $stmt->execute();
    $stmt = null;
    // $this->dbh = null;
  }
}
