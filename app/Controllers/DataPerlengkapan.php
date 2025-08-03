<?php

namespace App\Controllers;

use App\Models\perlengkapanJalan;
use App\Models\Pengadaan;
use Dompdf\Dompdf;
use Dompdf\Options;

class DataPerlengkapan extends BaseController
{
    public function __construct()
    {
        $this->perlengkapanJalan = new perlengkapanJalan();
        $this->pengadaanJalan = new Pengadaan();
    }


    public function index(): string
    {
        log_activity('Mengakses halaman Data Perlengkapan');

        $data = [
            'judul' => 'Data Perlengkapan',
            'page' => 'perlengkapan/v_data_perlengkapan',
        ];

        $role = session('role');

        if ($role === 'rekayasa') {
            $data['perlengkapan'] = $this->perlengkapanJalan
                ->whereIn('kondisi', ['baik', 'rusak'])
                ->findAll();

            log_activity('Melihat data perlengkapan dengan filter kondisi: baik, rusak (role: rekayasa)');

        } elseif ($role === 'management') {
            $data['perlengkapan'] = $this->perlengkapanJalan
                ->where('kondisi', 'Rencana')
                ->findAll();

            log_activity('Melihat data perlengkapan dengan filter kondisi: Rencana (role: management)');

        } else {
            $data['perlengkapan'] = $this->perlengkapanJalan->findAll();

            log_activity('Melihat semua data perlengkapan (role: ' . ($role ?? 'tidak diketahui') . ')');
        }

        return view('v_template_user', $data);
    }

    public function inputPerlengkapan(): string
    {
        log_activity('Mengakses halaman Input Perlengkapan');

        $data = [
            'judul' => 'Input Perlengkapan',
            'page' => 'perlengkapan/v_input_perlengkapan',
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
                'diupdate_oleh' => [
                    'label' => 'Diupdate Oleh',
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
                'foto_perlengkapan' => [
                    'label' => 'Foto Perlengkapan',
                    'rules' => 'uploaded[foto_perlengkapan]|max_size[foto_perlengkapan,1024]|mime_in[foto_perlengkapan,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => '{field} Tidak Boleh Kosong!',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB!',
                        'mime_in' => 'Format {field} Harus jpg, jpeg, dan png!',
                    ]
                ]
            ])
        ) {
            $pengadaan = $this->pengadaanJalan->where('id', $this->request->getPost('nama_perlengkapan'))->first();

            $foto_perlengkapan = $this->request->getFile('foto_perlengkapan');
            $nama_file_foto = $foto_perlengkapan->getRandomName();

            $data = [
                'pengadaan_id' => $this->request->getPost('nama_perlengkapan'),
                'nama_perlengkapan' => $pengadaan['nama_perlengkapan'],
                'jenis_perlengkapan' => $this->request->getPost('jenis_perlengkapan'),
                'lokasi_jalan' => $this->request->getPost('lokasi_jalan'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'terakhir_diupdate' => $this->request->getPost('terakhir_diupdate'),
                'diupdate_oleh' => $this->request->getPost('diupdate_oleh'),
                'keterangan' => $this->request->getPost('keterangan'),
                'foto_perlengkapan' => $nama_file_foto,
                'kondisi' => $this->request->getPost('kondisi'),
            ];
            $foto_perlengkapan->move(FCPATH . 'uploads', $nama_file_foto);
            $this->perlengkapanJalan->insertData($data);

            $role = session('role');

            if ($role === 'management') {
               $this->pengadaanJalan->decreementPengadaan($this->request->getPost('nama_perlengkapan'));
            }

            log_activity('Menambahkan data perlengkapan baru: ' . $data['nama_perlengkapan'] .
                ' (Jenis: ' . $data['jenis_perlengkapan'] . ', Kondisi: ' . $data['kondisi'] .
                ', Lokasi: ' . $data['lokasi_jalan'] . ')');

            session()->setFlashdata('pesan', 'Data berhasil di Tambahkan!');
            return redirect()->to('DataPerlengkapan/inputPerlengkapan');
        } else {
            log_activity('Gagal menambahkan data perlengkapan: validasi form tidak lolos');

            return redirect()->to('DataPerlengkapan/inputPerlengkapan')->withInput();
        }
    }

    public function editData($id)
    {
        log_activity('Mengakses halaman edit data perlengkapan dengan ID: ' . $id);

        $data = [
            'judul' => 'Edit Perlengkapan',
            'page' => 'perlengkapan/v_edit_data_perlengkapan',
            'perlengkapan' => $this->perlengkapanJalan->find($id),
        ];

        return view('v_template_user', $data);
    }

    public function updateData($id)
    {
        if (
            $this->validate([
                'nama_perlengkapan' => 'required',
                'jenis_perlengkapan' => 'required',
                'lokasi_jalan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'terakhir_diupdate' => 'required',
                'diupdate_oleh' => 'required',
                'keterangan' => 'required',
                'foto_perlengkapan' => [
                    'rules' => 'max_size[foto_perlengkapan,1024]|mime_in[foto_perlengkapan,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size' => 'Ukuran Foto Maksimal 1024 KB!',
                        'mime_in' => 'Format Foto Harus jpg, jpeg, atau png!',
                    ]
                ]
            ])
        ) {
            $perlengkapanLama = $this->perlengkapanJalan->find($id);
            $pengadaan = $this->pengadaanJalan->where('id', $this->request->getPost('nama_perlengkapan'))->first();

            $data = [
                'pengadaan_id' => $this->request->getPost('nama_perlengkapan'),
                'nama_perlengkapan' => $pengadaan['nama_perlengkapan'],
                'jenis_perlengkapan' => $this->request->getPost('jenis_perlengkapan'),
                'lokasi_jalan' => $this->request->getPost('lokasi_jalan'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'terakhir_diupdate' => $this->request->getPost('terakhir_diupdate'),
                'diupdate_oleh' => $this->request->getPost('diupdate_oleh'),
                'keterangan' => $this->request->getPost('keterangan'),
                'kondisi' => $this->request->getPost('kondisi'),
            ];

            $fotoDiganti = false;

            $foto = $this->request->getFile('foto_perlengkapan');
            if ($foto->isValid() && !$foto->hasMoved()) {
                $nama_file_foto = $foto->getRandomName();
                $foto->move(FCPATH . 'uploads', $nama_file_foto);

                if ($perlengkapanLama['foto_perlengkapan']) {
                    @unlink(FCPATH . 'uploads/' . $perlengkapanLama['foto_perlengkapan']);
                }

                $data['foto_perlengkapan'] = $nama_file_foto;
                $fotoDiganti = true;
            }

            $this->perlengkapanJalan->update($id, $data);

            $role = session('role');
            if ($role === 'management') {
                $this->pengadaanJalan->decreementPengadaan($this->request->getPost('nama_perlengkapan'));
            }
            

            $perubahanLog = 'Memperbarui data perlengkapan ID: ' . $id .
                ' dari "' . $perlengkapanLama['nama_perlengkapan'] . '" menjadi "' . $data['nama_perlengkapan'] . '"';

            if ($perlengkapanLama['kondisi'] != $data['kondisi']) {
                $perubahanLog .= ', perubahan kondisi dari "' . $perlengkapanLama['kondisi'] . '" menjadi "' . $data['kondisi'] . '"';
            }

            if ($perlengkapanLama['lokasi_jalan'] != $data['lokasi_jalan']) {
                $perubahanLog .= ', perubahan lokasi dari "' . $perlengkapanLama['lokasi_jalan'] . '" menjadi "' . $data['lokasi_jalan'] . '"';
            }

            if ($fotoDiganti) {
                $perubahanLog .= ', foto perlengkapan diganti';
            }

            log_activity($perubahanLog);

            session()->setFlashdata('pesan', 'Data berhasil diperbarui!');
            return redirect()->to('DataPerlengkapan');
        } else {
            log_activity('Gagal memperbarui data perlengkapan ID: ' . $id . ': validasi form tidak lolos');

            return redirect()->to('DataPerlengkapan/editPerlengkapan/' . $id)->withInput();
        }
    }

    public function removeData($id)
    {
        $perlengkapan = $this->perlengkapanJalan->find($id);

        log_activity('Menghapus data perlengkapan: ' . $perlengkapan['nama_perlengkapan'] .
            ' (Jenis: ' . $perlengkapan['jenis_perlengkapan'] . ', Kondisi: ' . $perlengkapan['kondisi'] .
            ', Lokasi: ' . $perlengkapan['lokasi_jalan'] . ') dengan ID: ' . $id);

        if ($perlengkapan && !empty($perlengkapan['foto_perlengkapan'])) {
            @unlink(FCPATH . 'uploads/' . $perlengkapan['foto_perlengkapan']);
        }

        $this->perlengkapanJalan->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('DataPerlengkapan');
    }

    public function exportPdf()
    {
        $data['perlengkapan'] = $this->perlengkapanJalan->findAll();;

        $html = view('perlengkapan/pdf_perlengkapan', $data);
        
        $options = new Options();
        $options->set('isRemoteEnabled', true); 
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream("data_perlengkapan.pdf", ["Attachment" => false]);
        exit();
    }
}