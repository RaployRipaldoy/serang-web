<?php

namespace App\Controllers;

use App\Models\JenisPerlengkapan;

class DataJenisPerlengkapan extends BaseController
{
    protected $jenisPerlengkapanModel;

    public function __construct()
    {
        $this->jenisPerlengkapanModel = new JenisPerlengkapan();
    }


    private function checkAccess()
    {
        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'management'])) {
            session()->setFlashdata('error', 'Access denied. Only admin and management can access this page.');
            return redirect()->to(base_url('/'));
        }
        return true;
    }

    public function index()
    {
        // Check access
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== true) {
            return $accessCheck;
        }

        log_activity('Mengakses halaman Data Jenis Perlengkapan');

        $keyword = $this->request->getGet('search');
        
        if ($keyword) {
            $data['jenisPerlengkapan'] = $this->jenisPerlengkapanModel->searchJenisPerlengkapan($keyword);
        } else {
            $data['jenisPerlengkapan'] = $this->jenisPerlengkapanModel->getJenisPerlengkapan();
        }

        $data['judul'] = 'Data Jenis Perlengkapan';
        $data['page'] = 'jenis_perlengkapan/index';
        $data['keyword'] = $keyword;

        return view('v_template_user', $data);
    }

    public function create()
    {
        // Check access
        $accessCheck = $this->checkAccess();
        if ($accessCheck !== true) {
            return $accessCheck;
        }

        log_activity('Mengakses halaman Tambah Jenis Perlengkapan');

        $data['judul'] = 'Tambah Jenis Perlengkapan';
        $data['page'] = 'jenis_perlengkapan/create';

        return view('v_template_user', $data);
    }

    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'nama_perlengkapan' => 'required|max_length[100]',
            'jenis_perlengkapan' => 'required|max_length[100]'
        ])) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_perlengkapan' => $this->request->getPost('nama_perlengkapan'),
            'jenis_perlengkapan' => $this->request->getPost('jenis_perlengkapan')
        ];

        if ($this->jenisPerlengkapanModel->insert($data)) {
            log_activity('Menambah data jenis perlengkapan: ' . $data['nama_perlengkapan']);
            session()->setFlashdata('success', 'Data jenis perlengkapan berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data jenis perlengkapan');
        }

        return redirect()->to('/DataJenisPerlengkapan');
    }

    public function edit($id)
    {
        log_activity('Mengakses halaman Edit Jenis Perlengkapan ID: ' . $id);

        $data['jenisPerlengkapan'] = $this->jenisPerlengkapanModel->getJenisPerlengkapan($id);
        
        if (!$data['jenisPerlengkapan']) {
            session()->setFlashdata('error', 'Data jenis perlengkapan tidak ditemukan');
            return redirect()->to('/DataJenisPerlengkapan');
        }

        $data['judul'] = 'Edit Jenis Perlengkapan';
        $data['page'] = 'jenis_perlengkapan/edit';

        return view('v_template_user', $data);
    }

    public function update($id)
    {
        // Validasi input
        if (!$this->validate([
            'nama_perlengkapan' => 'required|max_length[100]',
            'jenis_perlengkapan' => 'required|max_length[100]'
        ])) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_perlengkapan' => $this->request->getPost('nama_perlengkapan'),
            'jenis_perlengkapan' => $this->request->getPost('jenis_perlengkapan')
        ];

        if ($this->jenisPerlengkapanModel->update($id, $data)) {
            log_activity('Mengubah data jenis perlengkapan ID: ' . $id);
            session()->setFlashdata('success', 'Data jenis perlengkapan berhasil diubah');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah data jenis perlengkapan');
        }

        return redirect()->to('/DataJenisPerlengkapan');
    }

    public function delete($id)
    {
        $jenisPerlengkapan = $this->jenisPerlengkapanModel->getJenisPerlengkapan($id);
        
        if (!$jenisPerlengkapan) {
            session()->setFlashdata('error', 'Data jenis perlengkapan tidak ditemukan');
            return redirect()->to('/DataJenisPerlengkapan');
        }

        if ($this->jenisPerlengkapanModel->delete($id)) {
            log_activity('Menghapus data jenis perlengkapan: ' . $jenisPerlengkapan['nama_perlengkapan']);
            session()->setFlashdata('success', 'Data jenis perlengkapan berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data jenis perlengkapan');
        }

        return redirect()->to('/DataJenisPerlengkapan');
    }

    public function detail($id)
    {
        log_activity('Mengakses detail jenis perlengkapan ID: ' . $id);

        $data['jenisPerlengkapan'] = $this->jenisPerlengkapanModel->getJenisPerlengkapan($id);
        
        if (!$data['jenisPerlengkapan']) {
            session()->setFlashdata('error', 'Data jenis perlengkapan tidak ditemukan');
            return redirect()->to('/DataJenisPerlengkapan');
        }

        $data['judul'] = 'Detail Jenis Perlengkapan';
        $data['page'] = 'jenis_perlengkapan/detail';

        return view('v_template_user', $data);
    }
}
