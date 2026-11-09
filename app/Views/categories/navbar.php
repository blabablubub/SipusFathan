<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">

        <a class="navbar-brand sipus-brand"
           href="<?= site_url('/') ?>">
            SIPUS
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#sipusNavbar"
                aria-controls="sipusNavbar"
                aria-expanded="false"
                aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="sipusNavbar">

            <div class="navbar-nav ms-auto">
                <a class="nav-link"
                   href="<?= site_url('categories') ?>">
                    Kategori
                </a>

                <a class="nav-link"
                   href="<?= site_url('books') ?>">
                    Data Buku
                </a>
            </div>

        </div>
    </div>
</nav>  