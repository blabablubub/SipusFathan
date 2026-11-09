<?php
namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\BookModel;
class Categories extends BaseController
{
    public function index()
    {
        $model = new CategoryModel();
        return view('categories/index', [
            'title'      => 'Data Kategori - SIPUS',
            'categories' => $model->orderBy('id', 'DESC')
                                  ->findAll(),
        ]);
    }
    public function new()
    {
        return view('categories/form', [
            'title'    => 'Tambah Kategori - SIPUS',
            'category' => null,
            'errors'   => session()->getFlashdata('errors') ?? [],
        ]);
    }
    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]|is_unique[categories.name]',
            'description' => 'permit_empty|max_length[500]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $model = new CategoryModel();
        $model->insert(['name'=>trim($this->request->getPost('name')),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('/categories')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $model = new CategoryModel();
        $category = $model->find($id);
        if (! $category) {
            return redirect()->to('/categories')
                ->with('error', 'Kategori tidak ditemukan.');
        }
        return view('categories/form', [
            'title'    => 'Edit Kategori - SIPUS',
            'category' => $category,
            'errors'   => session()->getFlashdata('errors') ?? [],
        ]);
    }
    public function update($id)
    {
        $model = new CategoryModel();
        $category = $model->find($id);
        if (! $category) {
            return redirect()->to('/categories')
                ->with('error', 'Kategori tidak ditemukan.');
        }
        $rules = [
            'name' => "required|min_length[3]|max_length[100]|is_unique[categories.name,id,{$id}]",
            'description' => 'permit_empty|max_length[500]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $model->update($id, [
            'name'        => trim($this->request->getPost('name')),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to('/categories')
            ->with('success', 'Kategori berhasil diperbarui.');
    }
    public function delete($id)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);
        if (! $category) {
            return redirect()->to('/categories')
                ->with('error', 'Kategori tidak ditemukan.');
        }
        $bookModel = new BookModel();
        $used = $bookModel->where('category_id', $id)->countAllResults();if($used > 0) {
            return redirect()->to('/categories')
                ->with('error', 'Kategori masih digunakan oleh buku.');
        }
        $categoryModel->delete($id);
        return redirect()->to('/categories')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}