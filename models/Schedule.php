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

  public function insert($year, $month, $members)
  {
    $sql = "INSERT INTO schedule (year, month, day, member_id) VALUES(:year, :month, :day, :member_id)";
    $params = [];
    var_dump($year);
    var_dump($members);
    var_dump($month);
    foreach ($members as $day => $member) {
      $params[] = [':year', $year, PDO::PARAM_STR];
      $params[] = [':month', $month, PDO::PARAM_STR];
      $params[] = [':day', $day, PDO::PARAM_STR];
      $params[] = [':member_id', $member[0], PDO::PARAM_STR];
      $this->execute($sql, $params);
      $params[3] = [':member_id', $member[1], PDO::PARAM_STR];
      $this->execute($sql, $params);
      $params = [];
    }
  }

    public function fetchAllMember($ym)
    {
      $year = mb_substr($ym, 0, 4);
      $month = mb_substr($ym, -2);
      $sql = "SELECT * FROM schedule WHERE month = {$month} and year = {$year}";

      return $this->fetchAll($sql);
    }
}
