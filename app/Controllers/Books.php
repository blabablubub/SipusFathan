<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\CategoryModel;

class Books extends BaseController
{
    public function index()
    {
        $model = new BookModel();
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $active = $this->request->getGet('active');

        $search = is_string($search) ? trim($search) : '';
        $categoryId = is_string($category) && ctype_digit($category) && (int) $category > 0
            ? (int) $category
            : null;
        $activeOnly = $active === '1';
        $availableCopies = $model->selectSum('stock_available', 'total')
            ->first();

        return view('books/index', [
            'title' => 'Data Buku - SIPUS',
            'books' => $model->getBooksWithCategory($search, $categoryId, $activeOnly),
            'categories' => (new CategoryModel())->orderBy('name', 'ASC')->findAll(),
            'search' => $search,
            'selectedCategory' => $categoryId,
            'activeOnly' => $activeOnly,
            'totalBooks' => $model->countAll(),
            'availableCopies' => (int) ($availableCopies['total'] ?? 0),
        ]);
    }

    public function new()
    {
        $categoryModel = new CategoryModel();

        return view('books/form', [
            'title'      => 'Tambah Buku - SIPUS',
            'book'       => null,
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
            'errors'     => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function create()
    {
        $rules = [
            'category_id' => 'required|is_not_unique[categories.id]',
            'code'        => 'required|max_length[30]|is_unique[books.code]',
            'title'       => 'required|min_length[2]|max_length[200]',
            'author'      => 'required|max_length[150]',
            'publisher'   => 'permit_empty|max_length[150]',
            'published_year' => 'permit_empty|integer|greater_than_equal_to[1000]|less_than_equal_to[' . date('Y') . ']',
            'stock_total' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $stockTotal = (int) $this->request->getPost('stock_total');

        $model = new BookModel();

        $model->insert([
            'category_id'    => $this->request->getPost('category_id'),
            'code'           => trim($this->request->getPost('code')),
            'title'          => trim($this->request->getPost('title')),
            'author'         => trim($this->request->getPost('author')),
            'publisher'      => $this->request->getPost('publisher') ?: null,
            'published_year' => $this->request->getPost('published_year') ?: null,
            'stock_total'    => $stockTotal,
            'stock_available'=> $stockTotal,
            'is_active'      => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/books')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new BookModel();
        $book = $model->find($id);

        if (! $book) {
            return redirect()->to('/books')
                ->with('error', 'Buku tidak ditemukan.');
        }

        $categoryModel = new CategoryModel();

        return view('books/form', [
            'title'      => 'Edit Buku - SIPUS',
            'book'       => $book,
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
            'errors'     => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update($id)
    {
        $model = new BookModel();
        $book = $model->find($id);

        if (! $book) {
            return redirect()->to('/books')
                ->with('error', 'Buku tidak ditemukan.');
        }

        $rules = [
            'category_id' => 'required|is_not_unique[categories.id]',
            'code'        => "required|max_length[30]|is_unique[books.code,id,{$id}]",
            'title'       => 'required|min_length[2]|max_length[200]',
            'author'      => 'required|max_length[150]',
            'publisher'   => 'permit_empty|max_length[150]',
            'published_year' => 'permit_empty|integer|greater_than_equal_to[1000]|less_than_equal_to[' . date('Y') . ']',
            'stock_total' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $newStockTotal = (int) $this->request->getPost('stock_total');

        // Hitung jumlah buku yang sedang dipinjam.
        $borrowed = (int) $book['stock_total']
                  - (int) $book['stock_available'];

        if ($newStockTotal < $borrowed) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'stock_total' =>
                        'Stok total tidak boleh lebih kecil daripada jumlah buku yang sedang dipinjam.',
                ]);
        }

        $model->update($id, [
            'category_id'     => $this->request->getPost('category_id'),
            'code'            => trim($this->request->getPost('code')),
            'title'           => trim($this->request->getPost('title')),
            'author'          => trim($this->request->getPost('author')),
            'publisher'       => $this->request->getPost('publisher') ?: null,
            'published_year'  => $this->request->getPost('published_year') ?: null,
            'stock_total'     => $newStockTotal,
            'stock_available' => $newStockTotal - $borrowed,
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/books')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new BookModel();
        $book = $model->find($id);

        if (! $book) {
            return redirect()->to('/books')
                ->with('error', 'Buku tidak ditemukan.');
        }

        // Pertahankan buku yang sudah tercatat dalam riwayat transaksi.
        $used = db_connect()->table('loan_details')
            ->where('book_id', $id)
            ->countAllResults();

        if ($used > 0) {
            return redirect()->to('/books')
                ->with('error', 'Buku sudah memiliki riwayat transaksi dan tidak dapat dihapus.');
        }

        $model->delete($id);

        return redirect()->to('/books')
            ->with('success', 'Buku berhasil dihapus.');
    }
}