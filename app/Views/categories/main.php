<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= esc($title ?? 'SIPUS - Sistem Informasi Perpustakaan') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sipus-sidebar {
            width: 250px;
            min-width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
        }

        .sipus-content {
            min-width: 0;
        }

        .sipus-sidebar .nav-link {
            color: #495057;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 4px;
        }

        .sipus-sidebar .nav-link:hover {
            background-color: #f0f4ff;
            color: #0d6efd;
        }

        .sipus-sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #ffffff;
        }

        .sipus-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }

        @media (max-width: 767.98px) {
            .sipus-sidebar {
                width: 100%;
                min-width: 100%;
                border-right: 0;
                border-bottom: 1px solid #dee2e6;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>
<body>

    <?= $this->include('layouts/navbar') ?>

    <div class="d-flex flex-column flex-md-row min-vh-100">

        <?= $this->include('layouts/sidebar') ?>

        <main class="sipus-content flex-grow-1 p-3 p-lg-4">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

    <footer class="bg-white border-top py-3 px-4 text-center text-muted">
        <small>
            &copy; <?= date('Y') ?> SIPUS —
            Sistem Informasi Perpustakaan Sekolah
        </small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>