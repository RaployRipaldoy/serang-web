<?php

namespace App\Controllers;

use App\Models\Pengadaan;

class DataPengadaan extends BaseController
{
    public function __construct()
    {
        $this->pengadaanJalan = new Pengadaan();
    }

    public function index(): string
    {
        log_activity('Mengakses halaman Data Pengadaan');
        
        $data = [
            'judul' => 'Data Pengadaan',
            'page' => 'pengadaan/v_data_pengadaan',
        ];
      
        $data['pengadaan'] = $this->pengadaanJalan->findAll();

        return view('v_template_user', $data);
    }

    public function inputpengadaan(): string
    {
        log_activity('Mengakses halaman Input Pengadaan');
        
        $data = [
            'judul' => 'Input pengadaan',
            'page' => 'pengadaan/v_input_pengadaan',
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
                'jenis_perlengkapan' => [
                    'label' => 'Jenis Perlengkapan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'jumlah_ketersediaan' => [
                    'label' => 'Jumlah Ketersediaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'permit_empty',
                ],
            ])
        ) {
            $data = [
                'nama_perlengkapan'     => $this->request->getPost('nama_perlengkapan'),
                'jenis_perlengkapan'    => $this->request->getPost('jenis_perlengkapan'),
                'jumlah_ketersediaan'   => $this->request->getPost('jumlah_ketersediaan'),
                'keterangan'            => $this->request->getPost('keterangan'),
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
                'updated_by'            => session('name'),
            ];
            
            $this->pengadaanJalan->insertData($data);
            
            log_activity('Menambahkan data pengadaan baru: ' . $data['nama_perlengkapan'] . ' (' . $data['jenis_perlengkapan'] . ')');
            
            session()->setFlashdata('pesan', 'Data berhasil di Tambahkan!');
            return redirect()->to('Datapengadaan/inputpengadaan');
        } else {
            log_activity('Gagal menambahkan data pengadaan: validasi form tidak lolos');
            
            return redirect()->to('Datapengadaan/inputpengadaan')->withInput();
        }
    }

    public function editData($id)
    {
        log_activity('Mengakses halaman edit data pengadaan dengan ID: ' . $id);
        
        $data = [
            'judul' => 'Edit pengadaan',
            'page' => 'pengadaan/v_edit_data_pengadaan',
            'pengadaan' => $this->pengadaanJalan->find($id),
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
                'jenis_perlengkapan' => [
                    'label' => 'Jenis Perlengkapan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'jumlah_ketersediaan' => [
                    'label' => 'Jumlah Ketersediaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'permit_empty',
                ],
            ])
        ) {
            $pengadaanLama = $this->pengadaanJalan->find($id);
            
            $data = [
                'nama_perlengkapan'     => $this->request->getPost('nama_perlengkapan'),
                'jenis_perlengkapan'    => $this->request->getPost('jenis_perlengkapan'),
                'jumlah_ketersediaan'   => $this->request->getPost('jumlah_ketersediaan'),
                'keterangan'            => $this->request->getPost('keterangan'),
                'updated_at'            => date('Y-m-d H:i:s'),
                'updated_by'            => session('name'),
            ];

            $this->pengadaanJalan->update($id, $data);
            
            log_activity('Memperbarui data pengadaan ID: ' . $id . ' dari "' . $pengadaanLama['nama_perlengkapan'] . 
                '" menjadi "' . $data['nama_perlengkapan'] . '"');
            
            session()->setFlashdata('pesan', 'Data berhasil diperbarui!');
            return redirect()->to('Datapengadaan');
        } else {
            log_activity('Gagal memperbarui data pengadaan ID: ' . $id . ': validasi form tidak lolos');
            
            return redirect()->to('Datapengadaan/editpengadaan/' . $id)->withInput();
        }
    }

    public function removeData($id)
    {
        $pengadaan = $this->pengadaanJalan->find($id);
        
        log_activity('Menghapus data pengadaan: ' . $pengadaan['nama_perlengkapan'] . ' (' . $pengadaan['jenis_perlengkapan'] . ') dengan ID: ' . $id);
        
        $this->pengadaanJalan->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('Datapengadaan');
    }

    public function getPengadaanByPerlengkapan()
    {
        
        $jenis_perlengkapan = $this->request->getGet('jenis'); // atau 'jenis_perlengkapan'

        log_activity('Mengambil data pengadaan berdasarkan jenis perlengkapan: ' . $jenis_perlengkapan);
        
        $pengadaan = $this->pengadaanJalan->getPengadaanByPerlengkapan($jenis_perlengkapan);

        if ($pengadaan) {
            return $this->response->setJSON($pengadaan);
        } else {
            log_activity('Tidak ada data pengadaan ditemukan untuk jenis perlengkapan: ' . $jenis_perlengkapan);
            return $this->response->setJSON([]);
        }
    }
    
}