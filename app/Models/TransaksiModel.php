<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['id_admin', 'id_user', 'total_harga', 'jenis_transaksi'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType = 'array';
    public function __construct()
    {
        $this->builder = $this->builder($this->table);
        $this->user = new AuthModel();
        $this->detail = new DetailTransaksiModel();
    }
    public function setorSampah($data)
    {
        //tambahkan saldo ke akun user
        $this->user->tambahSaldo($data['id_user'], $data['total_harga']);
        //insert ke table transaksi
        $id_transaksi = $this->insert([
            'id_admin' => $data['id_admin'],
            'id_user' => $data['id_user'],
            'jenis_transaksi' => $data['jenis_transaksi'],
            'total_harga' => $data['total_harga']
        ], true);
        // lakukan insert ke table detail transaksi
        $this->detail->tambahDetail([
            'id_transaksi' => $id_transaksi,
            'detail' => $data['detail_transaksi']
        ], false);
        return $id_transaksi;
    }
    public function tarikSaldo($data)
    {
        //kurangi saldo ke akun user
        $this->user->tarikSaldo($data['id_user'], $data['total_harga']);
        return $this->insert($data, true);
    }
    public function getBy($id)
    {
        return
            $this->select('transaksi.*,users.id as user_id,users.sampul,users.nama')
            ->join('users', 'transaksi.id_user=users.id')
            ->where('transaksi.id', $id)->get()->getRowArray();
        // return $this->find($id)->getRow();
    }
    public function getTransaksi()
    {
        $this->select('transaksi.*,users.nama')
            ->join('users', 'transaksi.id_user=users.id')
            ->orderBy('transaksi.updated_at', 'DESC');
        return $this->get()->getResultObject();
        // return $this->builder($this->table)->join('users', 'id_user')->get()->getResultObject();
        // return $this->builder->select([$this->table . '.*', 'users.nama'])
        //     ->join('users', $this->table . '.id_user=users.id')
        //     ->get()->getResultObject();
    }
    public function listTransaksiByJenis($jenis)
    {
        $this->select('transaksi.*,users.nama,users.id as user_id')
            ->join('users', 'transaksi.id_user=users.id')
            ->where('transaksi.jenis_transaksi', $jenis)
            ->orderBy('transaksi.updated_at', 'DESC');
        return $this->get()->getResultObject();
    }
    public function kwitansi($id)
    {
        return $this->builder->select('*')
            ->join('users', $this->table . '.id_user=users.id')
            ->where('transaksi.id', $id)
            ->get()->getRowArray();
    }
    public function rekapTransaksi($dari, $sampai)
    {
        return $this->builder->select([$this->table . '.*', 'users.nama'])
            ->join('users', $this->table . '.id_user=users.id')
            ->where('transaksi.created_at>=', $dari)
            ->where('transaksi.created_at<=', $sampai)
            ->get()->getResultObject();
    }
    public function search($keyword)
    {
        return $this->table('transaksi')->like('users.nama', $keyword);
    }
    public function setor($id, $data, $admin)
    {
        $totalharga = 0;
        // dd($admin);
        foreach ($data as $d) {
            $totalharga += floatval($d['qty']) * floatval($d['harga']);
        }
        $transaksi = array(
            'id_admin' => $admin,
            'id_user' => $id,
            'jenis_transaksi' => 'masuk',
            'total_harga' => $totalharga
        );
        $idTransaksi = $this->insert($transaksi, true);
        // dd($idTransaksi);
        // insert ke detail transaksi
        // $detail = [];
        foreach ($data as $d) {
            $detailTr = [
                'id_transaksi' => $idTransaksi,
                'id_sampah' => $d['id_sampah'],
                'berat' => $d['qty'],
                'harga' => $d['harga'],
                'harga_total' => floatval($d['qty']) * floatval($d['harga'])
            ];
            // array_push($detail, $detailTr);
            $this->detail->addDetail($detailTr);
        }
        // var_dump($detail);
        // die;
        // update saldo
        $this->user->tambahSaldo($id, $totalharga);
        return true;
    }
}
