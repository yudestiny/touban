<?php

class Member extends DatabaseModel
{


  public function fetchAllName($order = '')
  {
    $sql = 'SELECT * FROM members';
    // if ($order) {
    //   $sql .= ' ORDER BY maxLimit ' . $order;
    // }
    return $this->fetchAll($sql);
  }

  public function insert($name, $limit)
  {
    $params = [];
    $sql = 'INSERT INTO members (name, maxLimit) VALUES(:name, :maxLimit)';
    $params[] = [':name', $name, PDO::PARAM_STR];
    $params[] = [':maxLimit', $limit, PDO::PARAM_STR];
    return $this->execute($sql, $params);
  }

  public function update($id, $name, $limit)
  {
    $params = [];
    $sql = 'UPDATE members SET name=(:name), maxLimit=(:maxLimit) WHERE id=(:id)';
    $params[] = [':name', $name, PDO::PARAM_STR];
    $params[] = [':maxLimit', $limit, PDO::PARAM_STR];
    $params[] = [':id', $id, PDO::PARAM_STR];
    return $this->execute($sql, $params);
  }
}
