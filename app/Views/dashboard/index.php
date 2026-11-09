<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Judul Dashboard -->
    <div class="mb-4">
        <h3 class="fw-bold">Dashboard SIPUS</h3>
        <p class="text-muted">
            Selamat datang di Sistem Informasi Perpustakaan Sekolah.
        </p>
    </div>

    <!-- Kartu Ringkasan -->
    <div class="row g-3">

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Buku</div>
                    <h2 class="fw-bold text-primary">
                        <?= number_format($totalBooks) ?>
                    </h2>
                    <a href="<?= site_url('books') ?>"
                       class="small text-decoration-none">
                        Lihat Data Buku
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Kategori</div>
                    <h2 class="fw-bold text-success">
                        <?= number_format($totalCategories) ?>
                    </h2>
                    <a href="<?= site_url('categories') ?>"
                       class="small text-decoration-none">
                        Lihat Kategori
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Anggota</div>
                    <h2 class="fw-bold text-warning">
                        <?= number_format($totalMembers) ?>
                    </h2>
                    <span class="small text-muted">
                        Data anggota perpustakaan
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Peminjaman</div>
                    <h2 class="fw-bold text-danger">
                        <?= number_format($totalLoans) ?>
                    </h2>
                    <span class="small text-muted">
                        Seluruh transaksi peminjaman
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Menu Akses Cepat -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Akses Cepat</h5>

            <div class="d-flex flex-wrap gap-2">
                <a href="<?= site_url('books') ?>"
                   class="btn btn-primary">
                    Data Buku
                </a>

                <a href="<?= site_url('categories') ?>"
                   class="btn btn-success">
                    Data Kategori
                </a>

                <a href="<?= site_url('members') ?>"
                   class="btn btn-warning">
                    Data Anggota
                </a>

                <a href="<?= site_url('loans') ?>"
                   class="btn btn-danger">
                    Data Peminjaman
                </a>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>