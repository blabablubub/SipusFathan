<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = db_connect();

        // Menghitung jumlah seluruh buku
        $totalBooks = $db->table('books')
            ->countAllResults();

        // Menghitung jumlah kategori
        $totalCategories = $db->table('categories')
            ->countAllResults();

        // Menghitung jumlah anggota
        $totalMembers = $db->table('members')
            ->countAllResults();

        // Menghitung jumlah transaksi peminjaman
        $totalLoans = $db->table('loans')
            ->countAllResults();

        return view('dashboard/index', [
            'totalBooks'      => $totalBooks,
            'totalCategories' => $totalCategories,
            'totalMembers'    => $totalMembers,
            'totalLoans'      => $totalLoans,
        ]);
    }
}