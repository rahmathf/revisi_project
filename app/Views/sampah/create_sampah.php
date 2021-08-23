<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Blank Page</h1> -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Tambah Data Sampah</h5>
        </div>
        <br>
        <div class="col">
            <?= $validation->listErrors(); ?>
            <form action="/sampah/save" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <!-- form hanya bisa diinput lewat halaman ini saja -->
                <div class="row mb-3">
                    <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('jenis')) ? 'is-invalid' : ''; ?>" name="jenis" autofocus value="<?= old('jenis'); ?>">
                        <div id="validationServer04Feedback" class="invalid-feedback">
                            <?= $validation->getError('jenis'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="harga" name="harga" value="<?= old('harga'); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="des" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="des" name="des" value="<?= old('des'); ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="sampul" class="col-sm-2 col-form-label">Foto</label>
                    <div class="col-sm-4">
                        <img src="/img/sampah.png" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-6">
                        <div class="custom-file">
                            <input type="file" class="form-control <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>" id="sampul" name="sampul" onchange="previewImg()">

                            <div class="invalid-feedback">
                                <?= $validation->getError('sampul'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mb-3">Tambah Data</button>
            </form>
        </div>

    </div>

</div>
<?= $this->endSection(); ?>