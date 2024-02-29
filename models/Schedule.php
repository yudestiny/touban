<?php

class Schedule extends DatabaseModel
{
    public function registerSchedule($tableName)
  {

    // if (!in_array($tableName, $this->tables)) {
    // }
    $sql = <<<EOT
          CREATE TABLE IF NOT EXISTS {$tableName}
          (
            date VARCHAR(30) NOT NULL PRIMARY KEY,
            member1 VARCHAR(30) NOT NULL,
            member2 VARCHAR(30) NOT NULL
          ) DEFAULT CHARSET=utf8mb4
EOT;
    $this->createTable($tableName, $sql);
  }

  public function insert($tableName, $date, $member)
  {
    $sql = "INSERT INTO {$tableName} (date, member1, member2) VALUES(:date, :member1, :member2)";
    $params = [];

    // foreach ($schedule as $date => $member) {
      $params[] = [':date', $date, PDO::PARAM_STR];
      $params[] = [':member1', $member[0], PDO::PARAM_STR];
      $params[] = [':member2', $member[1], PDO::PARAM_STR];
      return $this->execute($sql, $params);
    // }
  }

    public function fetchAllMember($tableName)
    {
      $sql = "SELECT * FROM {$tableName}";

      return $this->fetchAll($sql);
    }
}
