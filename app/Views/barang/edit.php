<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning">
                    <h5 class="card-title mb-0"><i class="bi bi-pencil-square"></i> Form Edit Barang</h5>
                </div>
                <div class="card-body">
                    <!-- <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                    <?php endif ?>

                    <?php if (session()->has('validation')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('validation')->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endif ?> -->

                    <?php if (session()->has('_ci_validation_errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session('_ci_validation_errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('admin/barang/update/' . $barang['id']) ?>" method="post"
                        enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                    value="<?= old('nama_barang', $barang['nama_barang']) ?>" required>
                                <div class="form-text">Masukkan nama barang dengan jelas dan spesifik</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dekripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="dekripsi" name="dekripsi" rows="4"
                                    required><?= old('dekripsi', $barang['dekripsi']) ?></textarea>
                                <div class="form-text">Berikan deskripsi lengkap tentang barang</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kategori" name="kategori"
                                    value="<?= old('kategori', $barang['kategori']) ?>" required>
                                <div class="form-text">Masukkan kategori barang (misal: Minuman, Makanan, Elektronik)
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stok" name="stok" min="0"
                                    value="<?= old('stok', $barang['stok']) ?>" required>
                                <div class="form-text">Jumlah stok barang yang tersedia</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga" name="harga" min="0"
                                        value="<?= old('harga', $barang['harga']) ?>" required>
                                </div>
                                <div class="form-text">Harga per unit barang</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="foto" class="col-sm-3 col-form-label">Foto Barang</label>
                            <div class="col-sm-9">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <img id="preview-img"
                                            src="<?= base_url('uploads/barang/' . ($barang['foto'] ?? 'default.jpg')) ?>"
                                            alt="Foto Barang" class="img-thumbnail"
                                            style="max-width: 160px; max-height: 160px;"
                                            value="<?= old('foto', $barang['foto']) ?>">
                                    </div>
                                    <div class="col">
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                                            onchange="previewImage(event)">
                                        <div class="form-text">Upload gambar barang (jpg, png, jpeg)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Terakhir diperbarui:
                            <?= $barang['updated_at'] ?? 'Baru' ?>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="<?= site_url('admin/barang') ?>" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save"></i> Update Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview-img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>