<?php

class Type extends DatabaseModel {

    public function fetchAllType ()
    {
        $sql = 'SELECT * FROM types';

        return $this->fetchAll($sql);
    }
}