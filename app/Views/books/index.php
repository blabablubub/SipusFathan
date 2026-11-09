<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .book-summary-card {
        border: 0;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.06);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3>Data Buku</h3>
        <p class="text-muted mb-0">Kelola koleksi buku perpustakaan.</p>
    </div>

    <a href="<?= site_url('books/new') ?>" class="btn btn-primary">
        Tambah Buku
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-sm-6">
        <div class="card book-summary-card h-100">
            <div class="card-body">
                <div class="text-muted">Jumlah seluruh buku</div>
                <div class="fs-3 fw-bold"><?= esc($totalBooks) ?></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card book-summary-card h-100">
            <div class="card-body">
                <div class="text-muted">Eksemplar tersedia</div>
                <div class="fs-3 fw-bold"><?= esc($availableCopies) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="get" action="<?= site_url('books') ?>" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari judul buku</label>
                <input type="search" id="search" name="search" class="form-control"
                       value="<?= esc($search) ?>" placeholder="Masukkan judul">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Kategori</label>
                <select id="category" name="category" class="form-select">
                    <option value="">Semua kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= esc($category['id']) ?>"
                            <?= $selectedCategory === (int) $category['id'] ? 'selected' : '' ?>>
                            <?= esc($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input type="checkbox" id="active" name="active" value="1"
                           class="form-check-input" <?= $activeOnly ? 'checked' : '' ?>>
                    <label class="form-check-label" for="active">Buku aktif saja</label>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">Terapkan</button>
                <a href="<?= site_url('books') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($books)): ?>
                        <?php $no = 1; ?>

                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($book['code']) ?></td>
                                <td><?= esc($book['title']) ?></td>
                                <td><?= esc($book['category_name']) ?></td>
                                <td><?= esc($book['author']) ?></td>
                                <td>
                                    <?= esc($book['stock_available']) ?>
                                    /
                                    <?= esc($book['stock_total']) ?>
                                </td>
                                <td>
                                    <?php if ($book['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('books/edit/' . $book['id']) ?>"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="<?= site_url('books/delete/' . $book['id']) ?>"
                                          method="post"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">

                                        <?= csrf_field() ?>

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada data buku.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>