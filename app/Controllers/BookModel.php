<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table            = 'books';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'category_id',
        'code',
        'title',
        'author',
        'publisher',
        'published_year',
        'stock_total',
        'stock_available',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    /**
     * Mengambil daftar buku beserta nama kategorinya.
     */
    public function getBooksWithCategory()
    {
        return $this->select('books.*, categories.name AS category_name')
            ->join('categories', 'categories.id = books.category_id')
            ->orderBy('books.id', 'DESC')
            ->findAll();
    }
}