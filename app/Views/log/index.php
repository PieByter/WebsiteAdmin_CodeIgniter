<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Log Aktivitas Sistem</h1>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="card mb-3">
        <div class="card-header">Filter Log</div>
        <div class="card-body">
            <form action="<?= site_url('admin/logs') ?>" method="get" id="filterForm">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-select auto-submit" id="user_id" name="user_id">
                            <option value="">Semua User</option>
                            <?php foreach ($users ?? [] as $user): ?>
                                <option value="<?= $user['id'] ?>"
                                    <?= (isset($filters['user_id']) && $filters['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                    <?= $user['username'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_start" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control auto-submit" id="date_start" name="date_start"
                            value="<?= $filters['date_start'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="date_end" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control auto-submit" id="date_end" name="date_end"
                            value="<?= $filters['date_end'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="keyword" class="form-label">Kata Kunci</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="keyword" name="keyword"
                                placeholder="Cari aktivitas..." value="<?= $filters['keyword'] ?? '' ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="<?= site_url('admin/logs/resetFilter') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                        </a>
                        <button type="button" id="exportBtn" class="btn btn-success">
                            <i class="bi bi-download"></i> Export CSV
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Log -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Tanggal & Waktu</th>
                    <th width="15%">User</th>
                    <th width="60%">Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-inbox display-1"></i>
                                <p class="mt-2">
                                    <?= $filters['keyword'] ? 'Tidak ada log yang sesuai dengan pencarian "' . esc($filters['keyword']) . '"' : 'Belum ada data log' ?>
                                </p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php
                    $no = 1;
                    if ($pager) {
                        $no = 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage());
                    }
                    foreach ($logs as $log):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($log['created_at'])); ?></td>
                            <td><?= esc($log['username'] ?? 'Unknown') ?></td>
                            <td><?= esc($log['aktivitas']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    // Ambil semua filter aktif untuk query string
    $queryString = http_build_query([
        'user_id'    => $filters['user_id'] ?? '',
        'date_start' => $filters['date_start'] ?? '',
        'date_end'   => $filters['date_end'] ?? '',
        'keyword'    => $filters['keyword'] ?? '',
    ]);

    ?>

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
                (<?= number_format($pager->getTotal()) ?> total log)
            </small>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit saat dropdown atau tanggal berubah
        const autoSubmitElements = document.querySelectorAll('.auto-submit');
        autoSubmitElements.forEach(function(element) {
            element.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });

        // Untuk keyword, tetap gunakan tombol cari
        // (agar tidak submit pada setiap keystroke)

        // Export dengan filter yang sama
        document.getElementById('exportBtn').addEventListener('click', function() {
            window.location.href = '<?= site_url('admin/logs/export') ?>';
        });
    });
</script>

<style>
    .table td {
        vertical-align: middle;
    }
</style>
<?= $this->endSection() ?>