<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPerlengkapan extends Model
{
    protected $table = 'tb_jenis_perlengkapan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_perlengkapan',
        'jenis_perlengkapan',
        'created_by',
        'updated_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_perlengkapan' => 'required|max_length[100]',
        'jenis_perlengkapan' => 'required|max_length[100]'
    ];

    protected $validationMessages = [
        'nama_perlengkapan' => [
            'required' => 'Nama perlengkapan harus diisi',
            'max_length' => 'Nama perlengkapan maksimal 100 karakter'
        ],
        'jenis_perlengkapan' => [
            'required' => 'Jenis perlengkapan harus diisi',
            'max_length' => 'Jenis perlengkapan maksimal 100 karakter'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        if (session()->get('role')) {
            $data['data']['created_by'] = session()->get('role');
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if (session()->get('role')) {
            $data['data']['updated_by'] = session()->get('role');
        }
        return $data;
    }

    public function getJenisPerlengkapan($id = null)
    {
        if ($id === null) {
            return $this->orderBy('created_at', 'DESC')->findAll();
        }
        return $this->find($id);
    }

    public function searchJenisPerlengkapan($keyword)
    {
        return $this->like('nama_perlengkapan', $keyword)
                    ->orLike('jenis_perlengkapan', $keyword)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
