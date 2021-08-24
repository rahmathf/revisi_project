<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content') ?>
<div class="container m-2">
    <div class="row">
        <div class="card border-left-primary">
            <div class="card-header font-weight-bold text-primary">Form Setor Sampah</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="container-fluid">
                            <img src="/img/<?= $transaksi['sampul'] ?>" class="p-3 img-fluid">
                        </div>
                        <div class="container text-center pt-5">
                            <a href="/akun/<?= $transaksi['nama'] ?>" class="btn-success btn">Detail Member</a>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card border border-danger p-3">
                            <h4>Tatacara Setor Sampah</h4>
                            <ol>
                                <li>Pilih Jenis Sampah</li>
                                <li>Masukan Berat Sampah (KG)</li>
                                <li>Klik Tambah</li>
                                <li>Untuk Menghapus, Tekan Icon <i class="fas fa-trash"></i> Pada Tabel</li>
                                <li>Setelah Semua Data Benar, Tekan Tombol Setor</li>
                            </ol>
                        </div>
                        <hr>
                        <div class="card p-3">
                            <h5>Form Setor Sampah</h5>
                            <input type="hidden" id="idUser" value="<?= $transaksi['id_user'] ?>">
                            <input type="hidden" id="idTransaksi" value="<?= $transaksi['id'] ?>">
                            <input type="hidden" id="idAdmin" value="<?= $user['id'] ?>">
                            <div class="form-group">
                                <label for="jenis">Pilih Jenis Sampah</label>
                                <select id="jenis" class="form-control form-control-user">

                                </select>
                                <p class="text-center">Jenis sampah tidak tersedia? tambah baru <a href="/sampah/create">Disini</a></p>
                            </div>
                            <div class="form-group">
                                <label for="qty">Banyaknya - KG</label>
                                <input type="number" id="qty" class="form-control" placeholder="dalam Kilogram">
                            </div>
                            <div class="text-center form-group">
                                <button onclick="addSampah()" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-lg-6">
            <div class="card border-left-danger">
                <div class="card-header">Daftar Setoran Sampah Sebelumnya</div>
                <div class="card-body">
                    <table class="table table-hover table-stripped" id="setoranLama">
                        <thead>
                            <tr>
                                <th>Jenis Sampah</th>
                                <th>Harga Satuan</th>
                                <th>Banyaknya (KG)</th>
                                <th>Harga Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail_transaksi as $dt) : ?>
                                <tr>
                                    <td><?= $dt->jenis ?></td>
                                    <td><?= $dt->harga ?></td>
                                    <td><?= $dt->berat ?></td>
                                    <td><?= $dt->harga_total ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-left-danger">
                <div class="card-header">Daftar Setoran Sampah</div>
                <div class="card-body">
                    <table class="table table-hover table-stripped" id="tempSetoran">
                        <thead>
                            <tr>
                                <th>Jenis Sampah</th>
                                <th>Harga Satuan</th>
                                <th>Banyaknya (KG)</th>
                                <th>Harga Final</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td id="finalHarga"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <button onclick="simpanSetoran()" class="btn btn-success">Setor Sampah</button>
                </div>
            </div>
        </div>

    </div>


</div>
<?= $this->endsection() ?>
<?= $this->section('custom_script') ?>
<script>
    var idUser = $('#idUser').val()
    var admin = $('#idAdmin').val()
    var idTransaksi = $('#idTransaksi').val()
    var table = $('#tempSetoran>tbody')
    $(document).ready(function() {
        // if ready, get table from temp
        reloadTable(idUser)
        // total()
    })

    function loadDropdown(id) {
        let dropdown = $('#jenis')
        dropdown.empty()
        $.ajax({
            type: "GET",
            url: "<?= base_url('transaksi/dropdownList') ?>",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                let content = `<option value="">Pilih Satu</option>`
                $.each(response, function(indexInArray, valueOfElement) {
                    content += `<option value="${valueOfElement.id}">${valueOfElement.jenis}</option>`
                });
                dropdown.append(content);
            }
        });
    }

    function total() {
        let tabel = $('#tempSetoran>tbody>tr')
        let total = 0
        tabel.each(function() {
            total += parseFloat($(this).find('td:eq(3)').text())
        })
        $('#finalHarga').text('Rp. ' + total)
    }

    function addSampah() {
        /*
        1. Get Data from select and input first
        2. add it into table
        3. remove selected index from select
        4. reset input to blank
        */

        const jenis = $('#jenis').val()
        const qty = $('#qty').val()
        $.ajax({
            type: "POST",
            url: "<?= base_url('transaksi/setTempSetoran') ?>",
            data: {
                id_user: idUser,
                id_sampah: jenis,
                qty: qty
            },
            dataType: "json",
            success: function(response) {
                if (response.pesan) {
                    reloadTable(idUser)
                    // delete jenis from select box, but don't delete if the selected option is "pilih satu"
                    if (!$('option:selected').val() == "")
                        $('option:selected').remove()
                    $('#qty').val('')
                }
            }
        });
    }

    function reloadTable(id_transaksi) {
        // empty the table first
        table.empty()
        $.ajax({
            type: "GET",
            url: "<?= base_url('transaksi/getTempSetoran') ?>",
            data: {
                id: id_transaksi
            },
            dataType: "json",
            success: function(response) {
                $.each(response, function(index, value) {
                    let content = "<tr>"
                    content += `<td>${value.jenis}</td>
                            <td>${value.harga}</td>
                            <td>${value.banyak}</td>
                            <td id="final">${value.harga_final}</td>
                            <td>${value.aksi}</td>`
                    content += "</tr>"
                    table.append(content)
                });
                total()
                loadDropdown(idUser)
            }
        });
    }

    function hapusTemp(e) {
        const id = $(e).data('id')
        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin akan menghapus list ini?',
            showCancelButton: true
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/hapusTemp') ?>",
                    data: {
                        id: id
                    },
                    dataType: "text",
                    success: function(response) {
                        if (response == 'success')
                            reloadTable(idUser)
                        // location.reload(true);
                    }
                });
            }
        })
    }

    function simpanSetoran() {
        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi Setoran',
            text: 'Anda akan mensetorkan semua data yang telah di input. Lanjutkan?'
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/setorSampahLanjutan') ?>",
                    data: {
                        id: idUser,
                        admin: admin,
                        idTransaksi:idTransaksi
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.pesan == 'success') {
                            window.location.href = "/transaksi"
                        }
                    }
                });
            }
        })
    }
</script>
<?= $this->endsection() ?>