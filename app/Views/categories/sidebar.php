<?php
$currentSegment = service('uri')->getSegment(1);
?>

<aside class="sipus-sidebar p-3">
    <div class="mb-3">
        <div class="fw-bold">Menu Utama</div>
        <small class="text-muted">Sistem Perpustakaan</small>
    </div>

    <nav class="nav flex-column">

        <a href="<?= site_url('/') ?>"
           class="nav-link <?= $currentSegment === '' ? 'active' : '' ?>">
            <span class="me-2">⌂</span>
            Dashboard
        </a>

        <a href="<?= site_url('categories') ?>"
           class="nav-link <?= $currentSegment === 'categories' ? 'active' : '' ?>">
            <span class="me-2">▤</span>
            Data Kategori
        </a>

        <a href="<?= site_url('books') ?>"
           class="nav-link <?= $currentSegment === 'books' ? 'active' : '' ?>">
            <span class="me-2">▣</span>
            Data Buku
        </a>

        <a href="<?= site_url('members') ?>"
           class="nav-link <?= $currentSegment === 'members' ? 'active' : '' ?>">
            <span class="me-2">♙</span>
            Data Anggota
        </a>

        <hr>

        <div class="text-uppercase text-muted small fw-bold mb-2">
            Transaksi
        </div>

        <a href="<?= site_url('loans') ?>"
           class="nav-link <?= $currentSegment === 'loans' ? 'active' : '' ?>">
            <span class="me-2">⇄</span>
            Peminjaman
        </a>

        <a href="<?= site_url('returns') ?>"
           class="nav-link <?= $currentSegment === 'returns' ? 'active' : '' ?>">
            <span class="me-2">↩</span>
            Pengembalian
        </a>

        <hr>

        <div class="text-uppercase text-muted small fw-bold mb-2">
            Laporan
        </div>

        <a href="<?= site_url('reports') ?>"
           class="nav-link <?= $currentSegment === 'reports' ? 'active' : '' ?>">
            <span class="me-2">▥</span>
            Laporan Perpustakaan
        </a>

    </nav>
</aside>