<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">


    <div class="container-fluid">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('del')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('del'); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <h4>Transaksi</h4>
            <div class="col-12 col-sm-8 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="list-menu" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tmasuk" role="tab" aria-selected="true">Transaksi Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tkeluar" role="tab" aria-controls="history" aria-selected="false">Transaksi Keluar</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Daftar Transaksi</h4>
                        <h6 class="card-subtitle mb-2">Bank Sampah Purbalingga</h6>
                        <div class="col-sm-6">
                            <button data-toggle="modal" data-target="#rekapModal" class="my-3 btn btn-primary"><i class="fas fa-file-pdf"></i> Rekap Transaksi</button>
                        </div>
                        <div class="tab-content mt-3">
                            <div class="tab-pane active" id="tmasuk" role="tabpanel">
                                <table data-toggle="table" data-search="true" data-pagination="true" class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Nasabah</th>
                                            <th>Nominal</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($transaksiMasuk as $tr) : ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $tr->nama ?></td>
                                                <td>Rp.<?= $tr->total_harga ?></td>
                                                <td class=" text-center">
                                                    <div class="badge badge-success"><?= $tr->jenis_transaksi ?></div>
                                                </td>
                                                <td><?= $tr->updated_at ?></td>
                                                <td>
                                                    <button data-user="<?=$tr->user_id?>" data-toggle="modal" data-target="#detailModal" data-jenis="<?= $tr->jenis_transaksi ?>" data-total="<?= $tr->total_harga ?>" data-nama="<?= $tr->nama ?>" data-tanggal="<?= $tr->created_at ?>" data-id="<?= $tr->id ?>" class="btn btn-primary btn-sm btn-icon-split">
                                                        <i class="fas fa-eye"></i>
                                                        <span class="text">Detail</span>
                                                    </button>

                                                    <button  data-id="<?= $tr->id ?>" onclick="hapus(this)" class="btn btn-sm btn-danger btn-icon-split">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="text">Hapus</span>
                                                    </button>
                                                    <?php if (date('d m y', strtotime($tr->created_at)) == date('d m y')) : ?>
                                                        <a href="transaksi/addTransaksi/<?=$tr->id?>" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                        <?php $no++;
                                        endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tkeluar" role="tabpanel" aria-labelledby="history-tab">
                                <table data-toggle="table" data-search="true" data-pagination="true" class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Nasabah</th>
                                            <th>Nominal</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($transaksiKeluar as $tr) : ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $tr->nama ?></td>
                                                <td>Rp.<?= $tr->total_harga ?></td>
                                                <td class=" text-center">
                                                    <div class="badge badge-danger"><?= $tr->jenis_transaksi ?></div>
                                                </td>
                                                <td><?= $tr->created_at ?></td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#tarikModal" data-jenis="<?= $tr->jenis_transaksi ?>" data-total="<?= $tr->total_harga ?>" data-nama="<?= $tr->nama ?>" data-tanggal="<?= $tr->created_at ?>" data-id="<?= $tr->id ?>" class="btn btn-primary btn-sm btn-icon-split">
                                                        <i class="fas fa-eye"></i>
                                                        <span class="text">Detail</span>
                                                    </button>

                                                    <button data-id="<?= $tr->id ?>" onclick="hapus(this)" class="btn btn-sm btn-danger btn-icon-split">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="text">Hapus</span>
                                                    </button>

                                                </td>
                                            </tr>
                                        <?php $no++;
                                        endforeach ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Page Heading -->
    <!-- <h1 class="mb-4 text-gray-800 h3">Blank Page</h1> -->
    <!--
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h5 class="m-0 font-weight-bold text-primary">Transaksi</h5>
        </div>
        <div class="col">

            <div class="row my-3">
                <div class="col-sm-6">
                    <button data-toggle="modal" data-target="#rekapModal" class="my-3 btn btn-primary"><i class="fas fa-file-pdf"></i> Rekap Transaksi</button>
                </div>

                <div class="col-sm-6">
                    <form action="" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukkan keyword pencarian.." name="keyword">
                            <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama User</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Jenis Transaksi</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>

        </div>
    </div>
                                -->
</div>
<div class="modal modal-fade" id="detailModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Transaksi Setor</h5>
                <a id="cetak" class="btn btn-danger"><span><i class="fas fa-file-pdf"> </i></span> Cetak</a>
                <a id="tarikSaldo" class="btn btn-warning text-white"><span><i class="fas fa-coins"> </i></span> Tarik Saldo</a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h6>Nama Nasabah</h6>
                        <h6>Tanggal Transaksi</h6>
                    </div>
                    <div class="col">
                        <h6 id="namaNasabah"></h6>
                        <h6 id="tanggalTransaksi"></h6>
                    </div>
                </div>
                <table class="table" id="detailTable">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Berat (KG)</th>
                            <th>Harga/KG</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="text-right col">
                    <h6 id="totalTR"></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-fade" id="tarikModal">
    <div role="dialog" class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Penarikan Saldo</h5>
                <a class="btn btn-danger"><i class="fas fa-file-pdf"></i>Cetak</a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h6>Nama Nasabah</h6>
                        <h6>Tanggal Penarikan</h6>
                        <h6>Saldo Keluar</h6>
                    </div>
                    <div class="col">
                        <h6 id="namaNasabah"></h6>
                        <h6 id="tanggalTarik"></h6>
                        <h6 id="saldo"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-fade" id="rekapModal">
    <div class="modal-dialog modal-dialog-centered" role="dialog">
        <div class="modal-content">
            <div class="modal-header">Rekap Transaksi</div>
            <div class="modal-body">
                <h5>Pilih Rentang Tanggal</h5>
                <form action="/transaksi/rekap" method="get">
                    <div class="form-group">
                        <label>Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control">
                    </div>
                    <div class="text-center form-group">
                        <button class="btn btn-success" type="submit"><i class="fas fa-print"></i> Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('custom_script') ?>
<script>
    $('#detailModal').on('show.bs.modal', function(e) {
        var tombol = $(e.relatedTarget)
        var modal = $(this)
        //kosongkan tabel
        $('table#detailTable > tbody>tr').remove()
        modal.find('h6#namaNasabah').text(tombol.data('nama'))
        modal.find('h6#tanggalTransaksi').text(tombol.data('tanggal'))
        modal.find('#totalTR').text('Total Transaksi: Rp.' + tombol.data('total'))
        modal.find('#cetak').attr('href', '/transaksi/cetakTransaksi/' + tombol.data('id'))
        modal.find('#tarikSaldo').attr('href', '/transaksi/tarik/' + tombol.data('user'))
        $.ajax({
            type: "GET",
            url: window.origin + "/transaksi/getDetail",
            data: {
                id_transaksi: tombol.data('id')
            },
            dataType: "text",
            success: function(response) {
                const data = JSON.parse(response);
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    $('table#detailTable > tbody').append(
                        `<tr>
                        <td>${element.jenis}</td>
                        <td>${element.berat}</td>
                        <td>${element.harga}</td>
                        <td>${element.harga_total}</td>
                    </tr>`
                    )

                }
            }
        });
    })
    $('#tarikModal').on('show.bs.modal', function(e) {
        var tombol = $(e.relatedTarget)
        var modal = $(this)
        modal.find('#namaNasabah').text(tombol.data('nama'))
        modal.find('#tanggalTarik').text(tombol.data('tanggal'))
        modal.find('#saldo').text(tombol.data('total'))
        modal.find('a').attr('href', '/transaksi/cetakTransaksi/' + tombol.data('id'))
    })

    function hapus(e) {
        const id = $(e).data('id')
        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi Aksi',
            text: 'Apakah Anda yakin akan menghapus transaksi ini?',
            footer: 'Setelah dihapus, data tidak dapat dikembalikan!',
            showCancelButton: true
        }).then((res) => {
            Swal.showLoading()
            if (res.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/hapus') ?>",
                    data: {
                        // id: id
                        id: id,
                        <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                    },
                    dataType: "text",
                    success: function(response) {
                        if (response == 'sukses') {
                            Swal.fire({
                                icon: 'success',
                                text: 'Data Berhasil dihapus'
                            }).then((res) => {
                                if (res.isConfirmed)
                                    window.location.reload(true)
                            })
                        }
                    }
                });
            }
        })
    }

    $('#list-menu a').on('click', function(e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>
<?= $this->endSection(); ?>