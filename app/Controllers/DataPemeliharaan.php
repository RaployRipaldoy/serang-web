<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Pemeliharaan;

class DataPemeliharaan extends BaseController
{
    public function __construct()
    {
        $this->pemeliharaanJalan = new Pemeliharaan();
    }

    public function index(): string
    {
        log_activity('Mengakses halaman Data Pemeliharaan');
        
        $data = [
            'judul' => 'Data Pemeliharaan',
            'page' => 'pemeliharaan/v_data_pemeliharaan',
        ];

        $data['pemeliharaan'] = $this->pemeliharaanJalan->findAll();

        return view('v_template_user', $data);
    }

    public function exportPdf()
    {
        $data['pemeliharaan'] = $this->pemeliharaanJalan->findAll();

        $html = view('pemeliharaan/pdf_pemeliharaan', $data);
        
        $options = new Options();
        $options->set('isRemoteEnabled', true); 
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream("data_pemeliharaan.pdf", ["Attachment" => false]);
        exit();
    }

    public function inputpemeliharaan(): string
    {
        log_activity('Mengakses halaman Input Pemeliharaan');
        
        $data = [
            'judul' => 'Input pemeliharaan',
            'page' => 'pemeliharaan/v_input_pemeliharaan',
        ];
        return view('v_template_user', $data);
    }

    public function insertData()
    {
        if (
            $this->validate([
                'nama_pemeliharaan' => [
                    'label' => 'Nama pemeliharaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]

                ],
                'jenis_pemeliharaan' => [
                    'label' => 'Jenis pemeliharaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'lokasi_jalan' => [
                    'label' => 'Lokasi Ruas Jalan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'latitude' => [
                    'label' => 'Latitude',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'longitude' => [
                    'label' => 'Longitude',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'terakhir_diupdate' => [
                    'label' => 'Terakhir diupdate',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'foto_pemeliharaan' => [
                    'label' => 'Foto pemeliharaan',
                    'rules' => 'uploaded[foto_pemeliharaan]|max_size[foto_pemeliharaan,1024]|mime_in[foto_pemeliharaan,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => '{field} Tidak Boleh Kosong!',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB!',
                        'mime_in' => 'Format {field} Harus jpg, jpeg, dan png!',
                    ]
                ]
            ])
        ) {
            $foto_pemeliharaan = $this->request->getFile('foto_pemeliharaan');
            $nama_file_foto = $foto_pemeliharaan->getRandomName();

            $data = [
                'nama_pemeliharaan' => $this->request->getPost('nama_pemeliharaan'),
                'jenis_pemeliharaan' => $this->request->getPost('jenis_pemeliharaan'),
                'lokasi_jalan' => $this->request->getPost('lokasi_jalan'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'terakhir_diupdate' => $this->request->getPost('terakhir_diupdate'),
                'diupdate_oleh' => session('name'),
                'keterangan' => $this->request->getPost('keterangan'),
                'foto_pemeliharaan' => $nama_file_foto,
                'kondisi' => $this->request->getPost('kondisi'),
            ];
            $foto_pemeliharaan->move(FCPATH . 'uploads', $nama_file_foto);
            $this->pemeliharaanJalan->insertData($data);
            
            log_activity('Menambahkan data pemeliharaan baru: ' . $data['nama_pemeliharaan'] . 
                ' (Jenis: ' . $data['jenis_pemeliharaan'] . ', Kondisi: ' . $data['kondisi'] . 
                ', Lokasi: ' . $data['lokasi_jalan'] . ')');
                
            session()->setFlashdata('pesan', 'Data berhasil di Tambahkan!');
            return redirect()->to('Datapemeliharaan/inputpemeliharaan');
        } else {
            log_activity('Gagal menambahkan data pemeliharaan: validasi form tidak lolos');
            
            return redirect()->to('Datapemeliharaan/inputpemeliharaan')->withInput();
        }
    }

    public function editData($id)
    {
        log_activity('Mengakses halaman edit data pemeliharaan dengan ID: ' . $id);
        
        $data = [
            'judul' => 'Edit pemeliharaan',
            'page' => 'pemeliharaan/v_edit_data_pemeliharaan',
            'pemeliharaan' => $this->pemeliharaanJalan->find($id),
        ];

        return view('v_template_user', $data);
    }

    public function updateData($id)
    {
        if (
            $this->validate([
                'nama_pemeliharaan' => 'required',
                'jenis_pemeliharaan' => 'required',
                'lokasi_jalan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'terakhir_diupdate' => 'required',
                'keterangan' => 'required',
                'foto_pemeliharaan' => [
                    'rules' => 'max_size[foto_pemeliharaan,1024]|mime_in[foto_pemeliharaan,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size' => 'Ukuran Foto Maksimal 1024 KB!',
                        'mime_in' => 'Format Foto Harus jpg, jpeg, atau png!',
                    ]
                ]
            ])
        ) {
            $pemeliharaanLama = $this->pemeliharaanJalan->find($id);
            
            $data = [
                'nama_pemeliharaan' => $this->request->getPost('nama_pemeliharaan'),
                'jenis_pemeliharaan' => $this->request->getPost('jenis_pemeliharaan'),
                'lokasi_jalan' => $this->request->getPost('lokasi_jalan'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'terakhir_diupdate' => $this->request->getPost('terakhir_diupdate'),
                'diupdate_oleh' => session('name'),
                'keterangan' => $this->request->getPost('keterangan'),
                'kondisi' => $this->request->getPost('kondisi'),
            ];

            $fotoDiganti = false;
            
            $foto = $this->request->getFile('foto_pemeliharaan');
            if ($foto->isValid() && !$foto->hasMoved()) {
                $nama_file_foto = $foto->getRandomName();
                $foto->move(FCPATH . 'uploads', $nama_file_foto);

                if ($pemeliharaanLama['foto_pemeliharaan']) {
                    @unlink(FCPATH . 'uploads/' . $pemeliharaanLama['foto_pemeliharaan']);
                }

                $data['foto_pemeliharaan'] = $nama_file_foto;
                $fotoDiganti = true;
            }

            $this->pemeliharaanJalan->update($id, $data);
            
            $perubahanLog = 'Memperbarui data pemeliharaan ID: ' . $id . 
                ' dari "' . $pemeliharaanLama['nama_pemeliharaan'] . '" menjadi "' . $data['nama_pemeliharaan'] . '"';
                
            if ($pemeliharaanLama['jenis_pemeliharaan'] != $data['jenis_pemeliharaan']) {
                $perubahanLog .= ', perubahan jenis dari "' . $pemeliharaanLama['jenis_pemeliharaan'] . 
                    '" menjadi "' . $data['jenis_pemeliharaan'] . '"';
            }
            
            if ($pemeliharaanLama['kondisi'] != $data['kondisi']) {
                $perubahanLog .= ', perubahan kondisi dari "' . $pemeliharaanLama['kondisi'] . 
                    '" menjadi "' . $data['kondisi'] . '"';
            }
            
            if ($pemeliharaanLama['lokasi_jalan'] != $data['lokasi_jalan']) {
                $perubahanLog .= ', perubahan lokasi dari "' . $pemeliharaanLama['lokasi_jalan'] . 
                    '" menjadi "' . $data['lokasi_jalan'] . '"';
            }
            
            if ($pemeliharaanLama['keterangan'] != $data['keterangan']) {
                $perubahanLog .= ', keterangan diperbarui';
            }
            
            if ($fotoDiganti) {
                $perubahanLog .= ', foto pemeliharaan diganti';
            }
            
            log_activity($perubahanLog);
            
            session()->setFlashdata('pesan', 'Data berhasil diperbarui!');
            return redirect()->to('Datapemeliharaan');
        } else {
            log_activity('Gagal memperbarui data pemeliharaan ID: ' . $id . ': validasi form tidak lolos');
            
            return redirect()->to('Datapemeliharaan/editpemeliharaan/' . $id)->withInput();
        }
    }

    public function removeData($id)
    {
        $pemeliharaan = $this->pemeliharaanJalan->find($id);

        log_activity('Menghapus data pemeliharaan: ' . $pemeliharaan['nama_pemeliharaan'] . 
            ' (Jenis: ' . $pemeliharaan['jenis_pemeliharaan'] . ', Kondisi: ' . $pemeliharaan['kondisi'] . 
            ', Lokasi: ' . $pemeliharaan['lokasi_jalan'] . ') dengan ID: ' . $id);
            
        if ($pemeliharaan && !empty($pemeliharaan['foto_pemeliharaan'])) {
            @unlink(FCPATH . 'uploads/' . $pemeliharaan['foto_pemeliharaan']);
        }

        $this->pemeliharaanJalan->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('Datapemeliharaan');
    }
}