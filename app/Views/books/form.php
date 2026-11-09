<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$book = $book ?? null;
$errors = $errors ?? [];
$isEdit = $book !== null;
?>

<div class="mb-4">
    <h3><?= $isEdit ? 'Edit Buku' : 'Tambah Buku' ?></h3>
    <p class="text-muted">Lengkapi informasi buku perpustakaan.</p>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>Periksa kembali data berikut:</strong>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">

        <form action="<?= $isEdit
            ? site_url('books/update/' . $book['id'])
            : site_url('books/create') ?>"
            method="post">

            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"
                            <?= old('category_id', $book['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                            <?= esc($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Buku</label>
                <input type="text"
                       name="code"
                       class="form-control"
                       maxlength="30"
                       value="<?= esc(old('code', $book['code'] ?? '')) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       maxlength="200"
                       value="<?= esc(old('title', $book['title'] ?? '')) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penulis</label>
                <input type="text"
                       name="author"
                       class="form-control"
                       maxlength="150"
                       value="<?= esc(old('author', $book['author'] ?? '')) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text"
                       name="publisher"
                       class="form-control"
                       maxlength="150"
                       value="<?= esc(old('publisher', $book['publisher'] ?? '')) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun Terbit</label>
                <input type="number"
                       name="published_year"
                       class="form-control"
                       min="1000"
                       max="<?= date('Y') ?>"
                       value="<?= esc(old('published_year', $book['published_year'] ?? '')) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok Total</label>
                <input type="number"
                       name="stock_total"
                       class="form-control"
                       min="0"
                       value="<?= esc(old('stock_total', $book['stock_total'] ?? 0)) ?>"
                       required>
                <small class="text-muted">
                    Masukkan jumlah seluruh eksemplar buku.
                </small>
            </div>

            <div class="form-check mb-4">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       class="form-check-input"
                       id="is_active"
                       <?= old('is_active', $book['is_active'] ?? 1) ? 'checked' : '' ?>>

                <label class="form-check-label" for="is_active">
                    Buku aktif
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $isEdit ? 'Update Buku' : 'Simpan Buku' ?>
            </button>

            <a href="<?= site_url('books') ?>" class="btn btn-secondary">
                Kembali
            </a>

        </form>
    </div>
</div>

<?= $this->endSection() ?>