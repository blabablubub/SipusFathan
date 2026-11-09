<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

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
    protected $dateFormat = 'datetime';

    public function getBooksWithCategory(
        string $search = '',
        ?int $categoryId = null,
        bool $activeOnly = false
    )
    {
        $query = $this->select('books.*, categories.name AS category_name')
            ->join('categories', 'categories.id = books.category_id')
            ->orderBy('books.title', 'ASC');

        if ($search !== '') {
            $query->like('books.title', $search);
        }

        if ($categoryId !== null) {
            $query->where('books.category_id', $categoryId);
        }

        if ($activeOnly) {
            $query->where('books.is_active', 1);
        }

        return $query->findAll();
    }
}