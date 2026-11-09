<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .rack-placeholder {
        border-left: 4px solid #0d6efd;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h1 class="h3 mb-1">Data Rak</h1>
    <p class="text-muted mb-0">Halaman pengelolaan rak perpustakaan.</p>
</div>

<div class="card rack-placeholder">
    <div class="card-body">
        <h2 class="h5">Data rak</h2>
        <p class="mb-0">Belum ada data rak yang ditambahkan.</p>
    </div>
</div>
<?= $this->endSection() ?>
