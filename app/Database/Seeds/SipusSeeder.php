<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use RuntimeException;

class SipusSeeder extends Seeder
{
    public function run()
    {
        // Password wajib ditentukan di .env agar tidak ada password default tersembunyi.
        $adminPassword = env('SIPUS_ADMIN_PASSWORD');

        if (! is_string($adminPassword) || strlen($adminPassword) < 2) {
            throw new RuntimeException(
                'Atur SIPUS_ADMIN_PASSWORD di .env (minimal 2 karakter) sebelum menjalankan seeder.'
            );
        }

        $users = $this->db->table('users');
        $adminEmail = 'atmin@s.local';

        if (! $users->where('email', $adminEmail)->get()->getRowArray()) {
            $users->insert([
                'name'          => 'Administrator SIPUS',
                'email'         => $adminEmail,
                'password_hash' => password_hash($adminPassword, PASSWORD_DEFAULT),
                'role'          => 'admin',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        }

        $categories = [
            ['name' => 'Fiksi', 'description' => 'Novel, cerpen, dan karya fiksi.'],
            ['name' => 'Pendidikan', 'description' => 'Buku pelajaran dan materi pembelajaran.'],
            ['name' => 'Sains', 'description' => 'Ilmu pengetahuan alam dan teknologi.'],
        ];

        foreach ($categories as $category) {
            $exists = $this->db->table('categories')
                ->where('name', $category['name'])
                ->get()
                ->getRowArray();

            if (! $exists) {
                $this->db->table('categories')->insert($category);
            }
        }

        $categoryRows = $this->db->table('categories')
            ->get()
            ->getResultArray();

        $categoryIds = [];

        foreach ($categoryRows as $category) {
            $categoryIds[$category['name']] = $category['id'];
        }

        $books = [
            [
                'category_id'    => $categoryIds['Fiksi'],
                'code'           => 'BK-0001',
                'title'          => 'Laskar Pelangi',
                'author'         => 'Andrea Hirata',
                'publisher'      => 'Bentang Pustaka',
                'published_year' => 2005,
                'stock_total'    => 4,
                'stock_available' => 4,
                'is_active'      => 1,
            ],
            [
                'category_id'    => $categoryIds['Pendidikan'],
                'code'           => 'BK-0002',
                'title'          => 'Matematika SMA',
                'author'         => 'Tim Penyusun',
                'publisher'      => 'Penerbit Contoh',
                'published_year' => 2024,
                'stock_total'    => 5,
                'stock_available' => 5,
                'is_active'      => 1,
            ],
            [
                'category_id'    => $categoryIds['Sains'],
                'code'           => 'BK-0003',
                'title'          => 'Pengantar Ilmu Sains',
                'author'         => 'Tim Penyusun',
                'publisher'      => 'Penerbit Contoh',
                'published_year' => 2023,
                'stock_total'    => 3,
                'stock_available' => 3,
                'is_active'      => 1,
            ],
        ];

        foreach ($books as $book) {
            $exists = $this->db->table('books')
                ->where('code', $book['code'])
                ->get()
                ->getRowArray();

            if (! $exists) {
                $book['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('books')->insert($book);
            }
        }

        $members = [
            [
                'member_code' => 'AG-0001',
                'name'        => 'Andi Pratama',
                'class_name'  => 'X-1',
                'phone'       => '081200000001',
                'status'      => 'active',
            ],
            [
                'member_code' => 'AG-0002',
                'name'        => 'Siti Rahma',
                'class_name'  => 'X-2',
                'phone'       => '081200000002',
                'status'      => 'active',
            ],
            [
                'member_code' => 'AG-0003',
                'name'        => 'Budi Santoso',
                'class_name'  => 'XI-1',
                'phone'       => '081200000003',
                'status'      => 'inactive',
            ],
        ];

        foreach ($members as $member) {
            $exists = $this->db->table('members')
                ->where('member_code', $member['member_code'])
                ->get()
                ->getRowArray();

            if (! $exists) {
                $member['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('members')->insert($member);
            }
        }
    }
}
