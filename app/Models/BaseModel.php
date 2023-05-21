<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';

    protected $beforeInsert = ['handleInsertUUID'];

    protected function handleInsertUUID($data)
    {
        helper('uuid');
        if (!isset($data['data'][$this->primaryKey])) {
            $data['data'][$this->primaryKey] = uuid();
        }
        return $data;
    }
}
