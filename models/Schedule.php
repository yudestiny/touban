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

  public function insert($date, $month, $members)
  {
    $sql = "INSERT INTO schedule (date, month, member_id) VALUES(:date, :month, :member_id)";
    $params = [];

    foreach ($members as $member) {
      $params[] = [':date', $date, PDO::PARAM_STR];
      $params[] = [':member_id', $member, PDO::PARAM_STR];
      $params[] = [':month', $month, PDO::PARAM_STR];
      return $this->execute($sql, $params);
    }
  }

    public function fetchAllMember($month)
    {
      $sql = "SELECT * FROM schedule WHERE month = {$month}";

      return $this->fetchAll($sql);
    }
}
