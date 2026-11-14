<?php

namespace App\Controllers;

use App\Models\MemberModel;

class Members extends BaseController
{
    // Menampilkan daftar anggota.
    public function index()
    {
        $model = new MemberModel();

        return view('members/index', [
            'members' => $model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    // Menampilkan formulir tambah anggota.
    public function new()
    {
        return view('members/form', [
            'member' => null,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    // Menyimpan anggota baru.
    public function create()
    {
        $model = new MemberModel();

        $data = [
            'member_code' => trim($this->request->getPost('member_code')),
            'name'        => trim($this->request->getPost('name')),
            'class_name'  => trim((string) $this->request->getPost('class_name')) ?: null,
            'phone'       => trim((string) $this->request->getPost('phone')) ?: null,
            'status'      => $this->request->getPost('status') ?: 'active',
        ];

        // Model menjalankan validasi secara otomatis.
        if ($model->insert($data) === false) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $model->errors());
        }

        return redirect()->to('/members')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    // Menampilkan formulir edit anggota.
    public function edit($id)
    {
        $model = new MemberModel();

        $member = $model->find($id);

        if (! $member) {
            return redirect()->to('/members')
                ->with('error', 'Data anggota tidak ditemukan.');
        }

        return view('members/form', [
            'member' => $member,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    // Memperbarui data anggota.
    public function update($id)
    {
        $model = new MemberModel();

        $member = $model->find($id);

        if (! $member) {
            return redirect()->to('/members')
                ->with('error', 'Data anggota tidak ditemukan.');
        }

        // Gunakan aturan unik yang mengecualikan ID anggota saat ini.
        $model->setRulesForUpdate((int) $id);

        $data = [
            'member_code' => trim($this->request->getPost('member_code')),
            'name'        => trim($this->request->getPost('name')),
            'class_name'  => trim((string) $this->request->getPost('class_name')) ?: null,
            'phone'       => trim((string) $this->request->getPost('phone')) ?: null,
            'status'      => $this->request->getPost('status'),
        ];

        if ($model->update($id, $data) === false) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $model->errors());
        }

        return redirect()->to('/members')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // Menonaktifkan anggota.
    public function delete($id)
    {
        $model = new MemberModel();

        $member = $model->find($id);

        if (! $member) {
            return redirect()->to('/members')
                ->with('error', 'Data anggota tidak ditemukan.');
        }

        if ($member['status'] === 'inactive') {
            return redirect()->to('/members')
                ->with('error', 'Anggota sudah berstatus tidak aktif.');
        }

        // Tidak menghapus data secara permanen.
        // Kita hanya mengubah status anggota.
        if ($model->update($id, [
            'status' => 'inactive',
        ]) === false) {
            return redirect()->to('/members')
                ->with('error', 'Anggota gagal dinonaktifkan.');
        }

        return redirect()->to('/members')
            ->with('success', 'Anggota berhasil dinonaktifkan.');
    }
}