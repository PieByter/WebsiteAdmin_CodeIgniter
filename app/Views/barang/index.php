<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<?php $pager = $pager ?? null; ?>
<div class="container">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= session('role') == 'admin' ? 'Manajemen Barang' : 'Daftar Produk' ?></h1>
        <?php if (session('role') == 'admin'): ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="<?= site_url('admin/barang/create') ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Tambah Barang
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- Search Form -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Cari nama barang atau deskripsi..." value="<?= esc($search ?? '') ?>">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>
                <?php if ($search): ?>
                    <a href="<?= session('role') == 'admin' ? site_url('admin/barang') : site_url('barang') ?>"
                        class="btn btn-outline-danger ms-2">
                        <i class="bi bi-x"></i>
                    </a>
                <?php endif; ?>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <?php if ($pager && $pager->getTotal() > 0): ?>
                <small class="text-muted">
                    Total: <?= number_format($pager->getTotal()) ?> barang
                </small>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabel Barang -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Nama Item</th>
                    <th width="25%">Deskripsi</th>
                    <th width="10%">Kategori</th>
                    <th width="10%">Stok</th>
                    <th width="10%">Harga</th>
                    <th width="20%">Gambar Barang</th>
                    <?php if (session('role') == 'admin'): ?>
                        <th width="20%">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($barangs)): ?>
                    <tr>
                        <td colspan="<?= session('role') == 'admin' ? '8' : '7' ?>" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-inbox display-1"></i>
                                <p class="mt-2">
                                    <?= $search ? 'Tidak ada barang yang sesuai dengan pencarian "' . esc($search) . '"' : 'Belum ada data barang' ?>
                                </p>
                                <?php if (!$search && session('role') == 'admin'): ?>
                                    <a href="<?= site_url('admin/barang/create') ?>" class="btn btn-primary">
                                        <i class="bi bi-plus"></i> Tambah Barang Pertama
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php
                    $no = 1;
                    if ($pager) {
                        $no = 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage());
                    }
                    foreach ($barangs as $barang):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= esc($barang['nama_barang']) ?></strong>
                            </td>
                            <td>
                                <div class="description-cell" title="<?= esc($barang['dekripsi']) ?>">
                                    <?= esc($barang['dekripsi']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= esc($barang['kategori'] ?? 'Umum') ?></span>
                            <td>
                                <span
                                    class="badge <?= $barang['stok'] > 10 ? 'bg-success' : ($barang['stok'] > 0 ? 'bg-warning text-dark' : 'bg-danger') ?>">
                                    <?= number_format($barang['stok']) ?>
                                </span>
                            </td>
                            <td>
                                <strong>Rp <?= number_format($barang['harga'], 0, ',', '.') ?></strong>
                            </td>
                            <td>
                                <img src="<?= base_url('uploads/barang/' . ($barang['foto'] ?? 'default.jpg')) ?>"
                                    alt="Foto Barang" class="img-thumbnail" style="width: 160px; height: 120px;">
                                <!--max-width:
                        80px; max-height: 80px;-->
                            </td>
                            <?php if (session('role') == 'admin'): ?>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= site_url('admin/barang/edit/' . $barang['id']) ?>"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= site_url('admin/barang/delete/' . $barang['id']) ?>"
                                            class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus barang \'<?= esc($barang['nama_barang']) ?>\'?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($pager && $pager->getPageCount() > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                <?php if ($pager->getCurrentPage() > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pager->getPreviousPageURI() ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </span>
                    </li>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php
                $currentPage = $pager->getCurrentPage();
                $totalPages = $pager->getPageCount();
                $startPage = max(1, $currentPage - 2);
                $endPage = min($totalPages, $currentPage + 2);

                for ($i = $startPage; $i <= $endPage; $i++):
                ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $pager->getPageURI($i) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <?php if ($pager->getCurrentPage() < $pager->getPageCount()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pager->getNextPageURI() ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Info Pagination -->
        <div class="mt-3 text-center">
            <small class="text-muted">
                Halaman <?= $pager->getCurrentPage() ?> dari <?= $pager->getPageCount() ?>
                (<?= number_format($pager->getTotal()) ?> total barang)
            </small>
        </div>
    <?php endif; ?>
</div>

<style>
    .description-cell {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: help;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group .btn {
        margin: 0;
    }
</style>
<?= $this->endSection() ?>