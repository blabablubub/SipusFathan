<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields = [
        'member_code',
        'name',
        'class_name',
        'phone',
        'status',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    // Aturan validasi data anggota.
    protected $validationRules = [
        'member_code' => 'required|max_length[30]|is_unique[members.member_code]',
        'name'        => 'required|min_length[2]|max_length[150]',
        'class_name'  => 'permit_empty|max_length[50]',
        'phone'       => 'permit_empty|max_length[30]',
        'status'      => 'required|in_list[active,inactive]',
    ];

    // Pesan kesalahan validasi.
    protected $validationMessages = [
        'member_code' => [
            'required'  => 'Kode anggota wajib diisi.',
            'max_length'=> 'Kode anggota maksimal 30 karakter.',
            'is_unique' => 'Kode anggota sudah digunakan.',
        ],

        'name' => [
            'required'   => 'Nama anggota wajib diisi.',
            'min_length' => 'Nama anggota minimal 2 karakter.',
            'max_length' => 'Nama anggota maksimal 150 karakter.',
        ],

        'class_name' => [
            'max_length' => 'Nama kelas maksimal 50 karakter.',
        ],

        'phone' => [
            'max_length' => 'Nomor telepon maksimal 30 karakter.',
        ],

        'status' => [
            'required' => 'Status anggota wajib dipilih.',
            'in_list'  => 'Status anggota tidak valid.',
        ],
    ];

    // Aturan khusus untuk proses update.
    public function setRulesForUpdate(int $id): void
    {
        $this->setValidationRule(
            'member_code',
            "required|max_length[30]|is_unique[members.member_code,id,{$id}]"
        );
    }
}     