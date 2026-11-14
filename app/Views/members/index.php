<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Data Anggota</h3>
            <p class="text-muted mb-0">
                Kelola data anggota perpustakaan SIPUS.
            </p>
        </div>

        <a href="<?= site_url('members/new') ?>"
           class="btn btn-primary">
            Tambah Anggota
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

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="60">No.</th>
                            <th>Kode Anggota</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (! empty($members)): ?>

                            <?php $no = 1; ?>

                            <?php foreach ($members as $member): ?>
                                <tr>
                                    <td><?= $no++ ?></td>

                                    <td>
                                        <?= esc($member['member_code']) ?>
                                    </td>

                                    <td>
                                        <?= esc($member['name']) ?>
                                    </td>

                                    <td>
                                        <?= esc($member['class_name'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= esc($member['phone'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?php if ($member['status'] === 'active'): ?>
                                            <span class="badge bg-success">
                                                Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                Tidak Aktif
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="<?= site_url('members/edit/' . $member['id']) ?>"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <?php if ($member['status'] === 'active'): ?>
                                            <form
                                                action="<?= site_url('members/delete/' . $member['id']) ?>"
                                                method="post"
                                                class="d-inline"
                                                onsubmit="return confirm('Nonaktifkan anggota ini?')"
                                            >
                                                <?= csrf_field() ?>

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm">
                                                    Nonaktifkan
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada data anggota.
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>