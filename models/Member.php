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

  public function insert($name, $type, $max, $min)
  {
    $params = [];
    $sql = 'INSERT INTO members (name, type_id, maxLimit, minLimit) VALUES(:name, :type_id, :maxLimit, :minLimit)';
    $params[] = [':name', $name, PDO::PARAM_STR];
    $params[] = [':type_id', $type, PDO::PARAM_STR];
    $params[] = [':maxLimit', $max, PDO::PARAM_STR];
    $params[] = [':minLimit', $min, PDO::PARAM_STR];
    return $this->execute($sql, $params);
  }

  public function update($id, $name, $type, $max, $min)
  {
    $params = [];
    $sql = 'UPDATE members SET name=(:name), type_id=(:type), maxLimit=(:maxLimit), minLimit=(:minLimit) WHERE id=(:id)';
    $params[] = [':name', $name, PDO::PARAM_STR];
    $params[] = [':type', $type, PDO::PARAM_STR];
    $params[] = [':maxLimit', $max, PDO::PARAM_STR];
    $params[] = [':minLimit', $min, PDO::PARAM_STR];
    $params[] = [':id', $id, PDO::PARAM_STR];
    return $this->execute($sql, $params);
  }
}
