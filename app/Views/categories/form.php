<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-2">
    <h1 class="h3 mb-3">
        <?= $category ? 'Edit Kategori' : 'Tambah Kategori' ?>
    </h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    <?php
        $isEdit = $category !== null;
        $action = $isEdit
            ? site_url('categories/update/' . $category['id'])
            : site_url('categories/create');
    ?>
    <form action="<?= $action ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" id="name" name="name"
                   class="form-control"
                   value="<?= esc(old('name', $category['name'] ?? '')) ?>"
                   required maxlength="100">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea id="description" name="description"
                      class="form-control" rows="3"
                      maxlength="500"><?= esc(old('description', $category['description'] ?? '')) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('categories') ?>"
           class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?>