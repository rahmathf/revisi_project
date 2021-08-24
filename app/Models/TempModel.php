<?php

namespace App\Models;

use CodeIgniter\Model;

class TempModel extends Model
{
    protected $table      = 'temp';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_user', 'id_sampah', 'qty'];

    
    public function getTemp($user)
    {
        return $this->table($this->table)->select('temp.*,sampah.jenis,sampah.harga,users.id as id_user')
            ->join('sampah', 'sampah.id=temp.id_sampah')
            ->join('users', 'users.id=temp.id_user')
            ->where('temp.id_user', $user)->get()->getResultArray();
    }
    public function removeByUser($user)
    {
        $this->where('id_user',$user);
        $this->delete(null,true);
        return $this->purgeDeleted();
    }
}
