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
                            <img src="/img/<?= $nasabah['sampul'] ?>" class="p-3 img-fluid">
                        </div>
                        <div class="container text-center pt-5">
                            <a href="/akun/<?= $nasabah['nama'] ?>" class="btn-success btn">Detail Member</a>
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
                            <input type="hidden" id="idUser" value="<?= $nasabah['id'] ?>">
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
                        <!--
                         <form action="<?= base_url('transaksi/setorSampah') ?>" id="formSetor" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $nasabah['id'] ?>">
                            <div class="p-3 mb-2 row border-bottom-dark border-left-danger" id="banyakSetor">
                                <div class="form-group col">
                                    <label for="jenis">Pilih Jenis Sampah</label>
                                    <select name="jenis[]" id="jenis" class="form-control form-control-user">
                                        <option value="">Pilih Satu</option>
                                        <?php foreach ($sampah as $s) : ?>
                                            <option data-harga="<?= $s['harga'] ?>" value="<?= $s['id'] ?>"><?= $s['jenis'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="qty">Banyaknya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                        <input type="text" name="qty[]" id="qty" class="form-control">
                                        <input type="hidden" name="hargaSatuan[]" id="hargaSatuan">
                                    </div>
                                </div>
                                <div class="text-right form-group">
                                    <button type="button" onclick="hapusField(this)" id="hapus" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="my-auto col">
                                    <button type="button" onclick="hitung()" class="btn btn-danger">Hitung Total</button>
                                </div>
                                <div class=" col">
                                    <label for="total">Total Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="total" id="total" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr class="border border-danger">
                            <div class="form-inline justify-content-between">
                                <button type="button" class="btn btn-primary" id="tambah"><i class="fas fa-plus"></i>Tambah Field</button>
                                <button type="button" onclick="cekTransaksi()" class="btn btn-success">
                                    <i class="fas fa-plane"></i> Setor Sampah
                                </button>
                            </div>
                        </form> 
                    -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row pt-5">
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
<?= $this->endsection() ?>
<?= $this->section('custom_script') ?>
<script>
    var idUser = $('#idUser').val()
    var admin = $('#idAdmin').val()
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

    function reloadTable(id_nasabah) {
        // empty the table first
        table.empty()
        $.ajax({
            type: "GET",
            url: "<?= base_url('transaksi/getTempSetoran') ?>",
            data: {
                id: id_nasabah
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
                    url: "<?= base_url('transaksi/setorSampah') ?>",
                    data: {
                        id: idUser,
                        admin: admin
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

    // function cekTransaksi() {
    //     const totalSetor = $('#total').val()
    //     if (totalSetor == "") {
    //         Swal.fire({
    //             icon: 'error',
    //             text: 'Hitung Total Harga terlebih dahulu untuk memastikan setoran!'
    //         })
    //     } else {
    //         Swal.fire({
    //             icon: 'question',
    //             text: `Nasabah akan menyetorkan sampah dengan nilai tukar Rp.${totalSetor}, Lanjutkan?`,
    //             footer: 'Tekan diluar kotak untuk membatalkan aksi'
    //         }).then((res) => {
    //             if (res.isConfirmed) {
    //                 $('form#formSetor').submit()
    //             }
    //         })
    //     }
    // }

    // function hapusField(e) {
    //     // cek banyaknya kolom
    //     const jumlahForm = $('div#banyakSetor').length
    //     if (jumlahForm <= 1) {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Peringatan',
    //             text: 'Form Tunggal tidak dapat dihapus!'
    //         })
    //     } else {
    //         $(e).parents('div#banyakSetor').remove()
    //     }
    // }
    // $('#formSetor').nestedForm({
    //     forms: '#banyakSetor',
    //     adder: '#tambah',
    // });

    // function hitung() {
    //     var total = 0;
    //     $('select > option:selected').each(function() {
    //         let harga = $(this).data('harga') // field data-harga pada option
    //         let qty = $(this).parents('div#banyakSetor').find('input#qty').val() //cari ke parent untuk mencari input qty
    //         let hargaSatuan = $(this).parents('div#banyakSetor').find('input#hargaSatuan').val(harga) //cari ke parent untuk mencari input qty
    //         total += harga * qty
    //     })
    //     $('#total').val(total);
    // }
</script>
<?= $this->endsection() ?>