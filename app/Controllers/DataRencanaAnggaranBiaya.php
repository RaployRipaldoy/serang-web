<?php

namespace App\Controllers;

use App\Models\RencanaAnggaranBiaya;

class DataRencanaAnggaranBiaya extends BaseController
{
    public function __construct()
    {
        $this->rabModel = new RencanaAnggaranBiaya();
    }

    public function index(): string
    {
        log_activity('Mengakses halaman Data Rencana Anggaran Biaya');
        
        $data = [
            'judul' => 'Data Rencana Anggaran Biaya',
            'page' => 'rencana_anggaran_biaya/v_data_rencana_anggaran_biaya',
        ];
      
        $data['rencana_anggaran_biaya'] = $this->rabModel->findAll();

        return view('v_template_user', $data);
    }

    public function inputRencanaAnggaranBiaya(): string
    {
        log_activity('Mengakses halaman Input Rencana Anggaran Biaya');
        
        $data = [
            'judul' => 'Input Rencana Anggaran Biaya',
            'page' => 'rencana_anggaran_biaya/v_input_rencana_anggaran_biaya',
        ];
        return view('v_template_user', $data);
    }

    public function insertData()
    {
        if (
            $this->validate([
                'nama_perlengkapan' => [
                    'label' => 'Nama Perlengkapan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'jumlah_unit' => [
                    'label' => 'Jumlah unit',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'permit_empty',
                ],
                'biaya' => [
                    'label' => 'Biaya',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'numeric' => '{field} harus berupa angka!'
                    ]
                ],
            ])
        ) {
            $data = [
                'nama_perlengkapan'     => $this->request->getPost('nama_perlengkapan'),
                'jumlah_unit'           => $this->request->getPost('jumlah_unit'),
                'keterangan'            => $this->request->getPost('keterangan'),
                'biaya'                 => $this->request->getPost('biaya'),
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ];
            
            $this->rabModel->insertData($data);
            
            log_activity('Menambahkan data Rencana Anggaran Biaya baru: ' . $data['nama_perlengkapan']);
            
            session()->setFlashdata('pesan', 'Data berhasil di Tambahkan!');
            return redirect()->to('DataRencanaAnggaranBiaya/inputRencanaAnggaranBiaya');
        } else {
            log_activity('Gagal menambahkan data rencana_anggaran_biaya: validasi form tidak lolos');
            
            return redirect()->to('DataRencanaAnggaranBiaya/inputRencanaAnggaranBiaya')->withInput();
        }
    }

    public function editData($id)
    {
        log_activity('Mengakses halaman edit data rencana_anggaran_biaya dengan ID: ' . $id);
        
        $data = [
            'judul' => 'Edit rencana_anggaran_biaya',
            'page' => 'rencana_anggaran_biaya/v_edit_data_rencana_anggaran_biaya',
            'rencana_anggaran_biaya' => $this->rabModel->find($id),
        ];

        return view('v_template_user', $data);
    }

    public function updateData($id)
    {
        if (
            $this->validate([
                'nama_perlengkapan' => [
                    'label' => 'Nama Perlengkapan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'jumlah_unit' => [
                    'label' => 'Jumlah unit',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'permit_empty',
                ],
                'biaya' => [
                    'label' => 'Biaya',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'numeric' => '{field} harus berupa angka!'
                    ]
                ],
            ])
        ) {
            $rencana_anggaran_biaya_lama = $this->rabModel->find($id);
            
            $data = [
                'nama_perlengkapan'     => $this->request->getPost('nama_perlengkapan'),
                'jumlah_unit'           => $this->request->getPost('jumlah_unit'),
                'keterangan'            => $this->request->getPost('keterangan'),
                'biaya'                 => $this->request->getPost('biaya'),
                'updated_at'            => date('Y-m-d H:i:s'),
                'updated_by'            => session('name'),
            ];

            $this->rabModel->update($id, $data);
            
            log_activity('Memperbarui data Rencana Anggaran Biaya ID: ' . $id . ' dari "' . $rencana_anggaran_biaya_lama['nama_perlengkapan'] . 
                '" menjadi "' . $data['nama_perlengkapan'] . '"');
            
            session()->setFlashdata('pesan', 'Data berhasil diperbarui!');
            return redirect()->to('DataRencanaAnggaranBiaya');
        } else {
            log_activity('Gagal memperbarui data rencana_anggaran_biaya ID: ' . $id . ': validasi form tidak lolos');
            
            return redirect()->to('DataRencanaAnggaranBiaya/editRencanaAnggaranBiaya/' . $id)->withInput();
        }
    }

    public function removeData($id)
    {
        $rencana_anggaran_biaya = $this->rabModel->find($id);
        
        log_activity('Menghapus data rencana_anggaran_biaya: ' . $rencana_anggaran_biaya['nama_perlengkapan']. ' dengan ID: ' . $id);
        
        $this->rabModel->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('DataRencanaAnggaranBiaya');
    }
    
}