<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama','email','password'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUserByEmail($email){
        return $this->db->query("SELECT id, nama, email, `password` FROM user WHERE email = '". $email ."'")->getRowObject();
    }

    public function getUserByEmailWithoutPassword($email){
        return $this->db->query("SELECT id, nama, email FROM user WHERE email = '". $email ."'")->getRowObject();
    }
}
