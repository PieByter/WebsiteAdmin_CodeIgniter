<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-box-seam"></i> Form Tambah Barang</h5>
                </div>
                <div class="card-body">

                    <!-- <?php $validation = \Config\Services::validation(); ?>
                    <?php if ($validation->getErrors()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?> -->

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

                    <form action="<?= site_url('admin/barang/save') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                    value="<?= old('nama_barang') ?>" required>
                                <div class="form-text">Masukkan nama barang dengan jelas dan spesifik</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dekripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="dekripsi" name="dekripsi" rows="4"
                                    required><?= old('dekripsi') ?></textarea>
                                <div class="form-text">Berikan deskripsi lengkap tentang barang</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kategori" name="kategori"
                                    value="<?= old('kategori') ?>" required>
                                <div class="form-text">Masukkan kategori barang (misal: Minuman, Makanan, Elektronik)
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stok" name="stok" min="0"
                                    value="<?= old('stok', null) ?>" required>
                                <div class="form-text">Jumlah stok barang yang tersedia</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga" name="harga" min="0"
                                        value="<?= old('harga', null) ?>" required>
                                </div>
                                <div class="form-text">Harga per unit barang</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foto" class="col-sm-3 col-form-label">Foto Barang</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <div class="form-text">Format gambar: jpg, jpeg, png. Maksimal 2MB.</div>
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label for="foto" class="col-sm-3 col-form-label">Foto Barang</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <div class="form-text">Upload gambar barang (jpg, png, jpeg)</div>
                            </div>
                        </div>
                        <hr> -->
                        <div class="d-flex justify-content-end">
                            <a href="<?= site_url('admin/barang') ?>" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>