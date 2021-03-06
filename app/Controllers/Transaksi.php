<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\DetailTransaksiModel;
use App\Models\SampahModel;
use App\Models\TempModel;
use App\Models\TransaksiModel;
use TCPDF;

class Transaksi extends BaseController
{
    protected $authModel;
    protected $sampahModel;
    protected $transaksiModel;
    public function __construct()
    {
        $this->authModel = new AuthModel();
        $this->sampahModel = new SampahModel();
        $this->transaksiModel = new TransaksiModel();
        $this->detail = new DetailTransaksiModel();
        $this->tempModel = new TempModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Transaksi | SemangatePoor',
            'transaksiMasuk' =>  $this->transaksiModel->listTransaksiByJenis('masuk'),
            'transaksiKeluar' =>  $this->transaksiModel->listTransaksiByJenis('keluar'),
            'user' => $this->authModel->find(session('id'))
        ];
        return view('transaksi/index', $data);
    }
    public function addTransaksi($idTransaksi)
    {
        // dd($this->transaksiModel->getBy(51));
        $data = [
            'title' => 'Setor Sampah (Lagi) | SemangatePoor',
            'transaksi' => $this->transaksiModel->getBy($idTransaksi),
            'detail_transaksi' => $this->detail->getDetail($idTransaksi),
            'user' => $this->authModel->find(session('id'))
        ];
        // dd($data);
        return view('transaksi/setorTambah', $data);
    }
    public function setor($id)
    {
        // get temp
        // dd($this->authModel->find($id));
        $temp = $this->tempModel->getTemp($id);
        $idSampah = array();
        $sampah = null;
        if (!empty($temp)) {
            foreach ($temp as $t) :
                array_push($idSampah, $t['id_sampah']);
            endforeach;
            $sampah = $this->sampahModel->getWithout($idSampah);
        } else {
            $sampah = $this->sampahModel->findAll();
        }
        $data = [
            'title' => 'Transaksi | SemangatePoor',
            'nasabah' => $this->authModel->find($id),
            'sampah' => $sampah,
            'user' => $this->authModel->find(session('id'))

        ];
        return view('transaksi/setor', $data);
    }
    public function tarik($id)
    {
        $data = [
            'title' => 'Tarik Saldo | SemangatePoor',
            'user' => $this->authModel->getById($id)
        ];
        // dd($data);
        return view('transaksi/tarik', $data);
    }

    public function setorSampah()
    {
        $id = $this->request->getPost('id');
        $admin = $this->request->getPost('admin');
        $data = $this->tempModel->getTemp($id);
        // var_dump($data);
        // die;
        $go = $this->transaksiModel->setor($id, $data, $admin);
        if ($go) {
            // kalau success kosongkan tabel temp berdasarkan id_user
            $this->tempModel->removeByUser($id);
            echo json_encode(['pesan' => 'success']);
        }
    }
    public function ahah()
    {
        dd($this->transaksiModel->getBy(51));
    }
    public function setorSampahLanjutan()
    {
        $id = $this->request->getPost('id');
        $admin = $this->request->getPost('admin');
        $idTransaksi = $this->request->getPost('idTransaksi');
        $temp = [];
        $data = $this->tempModel->getTemp($id);
        // langsung save ke detail by idTransaksi
        foreach ($data as $d) {
            $new = [
                'id_transaksi' => $idTransaksi,
                'id_sampah' => $d['id_sampah'],
                'berat' => $d['qty'],
                'harga' => $d['harga'],
                'harga_total' => floatval($d['qty']) * floatval($d['harga'])
            ];
            array_push($temp, $new);
        }
        $totalharga = 0;
        // dd($admin);
        foreach ($data as $d) {
            $totalharga += floatval($d['qty']) * floatval($d['harga']);
        }
        // update nominal transaksi
        $transaksiLama=$this->transaksiModel->getBy($idTransaksi);
        // jumlahkan nominal lama + total baru
        $totalbaru=floatval($transaksiLama['total_harga'])+floatval($totalharga);
        $this->transaksiModel->set('total_harga',$totalbaru);
        $this->transaksiModel->update($idTransaksi);
        // var_dump($data);
        // die;
        $this->detail->insertBatch($temp);
        $this->authModel->tambahSaldo($id, $totalharga);
        $this->tempModel->removeByUser($id);
        echo json_encode(['pesan' => 'success']);
    }
    public function tarikSaldo()
    {
        // dapatkan user yang saat ini login, untuk isi kolom admin pada tabel transaksi
        $admin = (object)$this->authModel->find(session()->id);
        $data = [
            'id_admin' => $admin->id,
            'id_user' => $this->request->getPost('id'),
            'jenis_transaksi' => 'keluar',
            'total_harga' => $this->request->getPost('tarik')
        ];
        $result = $this->transaksiModel->tarikSaldo($data);
        return redirect()->to('/transaksi')->with('pesan', 'Transaksi Berhasil dengan ID Transaksi = ' . $result);
    }
    public function coba()
    {
        $data = [
            'title' => 'Tarik Saldo | SemangatePoor',
            'user' => (object)$this->authModel->getById(1),
            'sampah' => $this->sampahModel->findAll()
        ];
        return view('transaksi/coba', $data);
    }
    public function getDetail()
    {
        $id_transaksi = $this->request->getGet('id_transaksi');
        $data = $this->detail->getDetail($id_transaksi);
        // $data = $this->detail->where(['id_transaksi' => $id_transaksi])->findAll();
        echo json_encode($data);
    }
    public function cetakTransaksi($id)
    {
        $data = [
            'transaksi' => $this->transaksiModel->kwitansi($id),
            'detail' => $this->detail->getDetail($id)
        ];
        // $transaksi = $this->transaksiModel->kwitansi($id);
        // $detail = $this->detail->getDetail($id);
        // dd(session()->getTempdata());

        $html = view('transaksi/kwitansi', $data);
        $pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);

        $pdf->SetCreator('SemangatePoor');
        $pdf->SetAuthor('Rahmat Hidayat F');
        $pdf->SetTitle('Kwitansi ' . $data['transaksi']['jenis_transaksi']);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, 'L');
        //line ini penting
        $this->response->setContentType('application/pdf');
        //Close and output PDF document
        $pdf->Output('Kwitansi.pdf', 'I');
        // Output I untuk display saja, D untuk download pilih sendiri
        // $pdf->Output('Kwitansi.pdf', 'D');
    }
    public function rekap()
    {
        $dari = $this->request->getVar('dari');
        $sampai = $this->request->getVar('sampai');
        $data = [
            'transaksi' => $this->transaksiModel->rekapTransaksi($dari, $sampai),
            'dari' => $dari,
            'sampai' => $sampai
        ];
        // $html = view('transaksi/rekap', [
        //     'transaksi'
        //     => $this->transaksiModel->rekapTransaksi($dari, $sampai),
        //     'dari' => $dari,
        //     'sampai' => $sampai
        // ]);
        // dd($data);
        $html = view('transaksi/rekap', $data);
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('SemangatePoor');
        $pdf->SetTitle('Rekap Transaksi');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->addPage();
        // dd($pdf);
        $pdf->writeHTML($html, true, false, true, false, '');
        // $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('Rekap-Transaksi.pdf', 'I');
    }
    public function hapus()
    {
        $id = $this->request->getPost('id');
        $hapus = $this->transaksiModel->delete($id, true);
        if ($hapus)
            echo 'sukses';
        else echo 'gagal';
    }
    public function dropdownList()
    {
        $id = $this->request->getGet('id');
        $temp = $this->tempModel->getTemp($id);
        $idSampah = array();
        $sampah = null;
        if (!empty($temp)) {
            foreach ($temp as $t) :
                array_push($idSampah, $t['id_sampah']);
            endforeach;
            $sampah = $this->sampahModel->getWithout($idSampah);
        } else {
            $sampah = $this->sampahModel->findAll();
        }
        echo json_encode($sampah);
    }
    public function getTempSetoran()
    {
        $id = $this->request->getGet('id');
        $data = $this->tempModel->getTemp($id);
        // dd($data);
        $hasil = array();
        foreach ($data as $d) {
            $value = array(
                'id_sampah' => $d['id_sampah'],
                'jenis' => $d['jenis'],
                'harga' => $d['harga'],
                'banyak' => $d['qty'],
                'harga_final' => $d['harga'] * $d['qty'],
                'aksi' => '<button onclick="hapusTemp(this)" data-id="' . $d['id'] . '" class="btn btn-danger"><i class="fas fa-trash"></i></button>'
            );
            array_push($hasil, $value);
        }
        echo json_encode($hasil);
    }
    public function setTempSetoran()
    {
        $id_jenis = $this->request->getPost('id_sampah');
        $id_user = $this->request->getPost('id_user');
        $qty = $this->request->getPost('qty');
        $data = array(
            'id_user' => $id_user,
            'id_sampah' => $id_jenis,
            'qty' => $qty,
        );
        $this->tempModel->save($data);
        echo json_encode(['pesan' => true]);
    }
    public function hapusTemp()
    {
        $id = $this->request->getPost('id');
        $this->tempModel->delete($id);
        echo 'success';
    }
}
