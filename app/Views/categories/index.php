<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Data Kategori Buku</h1>
        <p class="text-muted mb-0">
            Kelola kategori koleksi perpustakaan.
        </p>
    </div>
    <a href="<?= site_url('categories/new') ?>"
       class="btn btn-primary">
        + Tambah Kategori
    </a>
</div>
<?php if ($message = session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= esc($message) ?>
    </div>
<?php endif ?>
<?php if ($message = session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc($message) ?>
    </div>
<?php endif ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data kategori.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $i => $category): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($category['name']) ?></td>
                            <td><?= esc($category['description'] ?? '') ?></td>
                            <td>
                                <a class="btn btn-sm btn-warning"
                                   href="<?= site_url('categories/edit/' . $category['id']) ?>">
                                    Edit
                                </a>
                                <form class="d-inline" method="post"
                                      action="<?= site_url('categories/delete/' . $category['id']) ?>"
                                      onsubmit="return confirm('Hapus kategori ini?')">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>