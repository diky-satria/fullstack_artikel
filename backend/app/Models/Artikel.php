<?php

namespace App\Models;

use CodeIgniter\Model;

class Artikel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    protected $table            = 'artikel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['judul','penulis','slug','konten','thumbnail','kategori','tanggal_publikasi','view'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllArtikel($key){
        if(!$key){
            $query = "";
        }else{
            $query = "WHERE judul LIKE '%{$key}%' OR kategori LIKE '%{$key}%'";
        }

        return $this->db->query("SELECT id, judul, penulis, slug, konten, thumbnail, tanggal_publikasi, kategori, view FROM artikel {$query} ORDER BY tanggal_publikasi DESC")->getResult();
    }

    public function getArtikelById($id){
        return $this->db->query("SELECT id, judul, penulis, slug, konten, thumbnail, tanggal_publikasi, kategori, view FROM artikel WHERE id = ". $id ."")->getRowObject();
    }
}
