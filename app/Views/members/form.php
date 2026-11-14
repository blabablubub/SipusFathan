<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
    $member = $member ?? null;
    $errors = $errors ?? [];

    $isEdit = $member !== null;
?>

<div class="container-fluid">

    <div class="mb-4">
        <h3>
            <?= $isEdit ? 'Edit Anggota' : 'Tambah Anggota' ?>
        </h3>

        <p class="text-muted">
            <?= $isEdit
                ? 'Perbarui informasi anggota perpustakaan.'
                : 'Masukkan informasi anggota baru.' ?>
        </p>
    </div>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>Periksa kembali data berikut:</strong>

            <ul class="mb-0 mt-2">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form
                action="<?= $isEdit
                    ? site_url('members/update/' . $member['id'])
                    : site_url('members/create') ?>"
                method="post"
            >

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Kode Anggota</label>

                    <input
                        type="text"
                        name="member_code"
                        class="form-control"
                        value="<?= esc(old('member_code', $member['member_code'] ?? '')) ?>"
                        maxlength="30"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Anggota</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= esc(old('name', $member['name'] ?? '')) ?>"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>

                    <input
                        type="text"
                        name="class_name"
                        class="form-control"
                        value="<?= esc(old('class_name', $member['class_name'] ?? '')) ?>"
                        maxlength="50"
                        placeholder="Contoh: X IPA 1"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="<?= esc(old('phone', $member['phone'] ?? '')) ?>"
                        maxlength="30"
                        placeholder="Contoh: 081234567890"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Anggota</label>

                    <?php
                        $status = old(
                            'status',
                            $member['status'] ?? 'active'
                        );
                    ?>

                    <select name="status" class="form-select" required>
                        <option value="active"
                            <?= $status === 'active' ? 'selected' : '' ?>>
                            Aktif
                        </option>

                        <option value="inactive"
                            <?= $status === 'inactive' ? 'selected' : '' ?>>
                            Tidak Aktif
                        </option>
                    </select>
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Anggota' ?>
                    </button>

                    <a href="<?= site_url('members') ?>"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>