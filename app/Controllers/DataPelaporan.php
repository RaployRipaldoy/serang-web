<?php

namespace App\Controllers;

use App\Models\Pelaporan;
use Dompdf\Options;

class DataPelaporan extends BaseController
{
    public function __construct()
    {
        $this->pelaporan = new Pelaporan();
    }

    public function index(): string
    {
        log_activity('Mengakses halaman Data Pelaporan');

        $data = [
            'judul' => 'Data Pelaporan',
            'page' => 'pelaporan/v_data_pelaporan',
        ];

        $data['pelaporan'] = $this->pelaporan->findAll();

        return view('v_template_user', $data);
    }

    public function inputPelaporan(): string
    {
        log_activity('Mengakses halaman Input Pelaporan');

        $data = [
            'judul' => 'Input Pelaporan',
            'page' => 'pelaporan/v_input_pelaporan',
        ];
        return view('v_template_user', $data);
    }

    public function insertData()
    {
        if (
            $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'valid_email' => '{field} Harus Berupa Alamat Email yang Valid!'
                    ]
                ],
                'no_hp' => [
                    'label' => 'Nomor HP',
                    'rules' => 'required|regex_match[/^[0-9]{10,15}$/]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'regex_match' => '{field} Harus Berupa Nomor HP yang Valid (10-15 digit)!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'foto_bukti' => [
                    'label' => 'Foto Pelaporan',
                    'rules' => 'uploaded[foto_bukti]|max_size[foto_bukti,1024]|mime_in[foto_bukti,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => '{field} Tidak Boleh Kosong!',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB!',
                        'mime_in' => 'Format {field} Harus jpg, jpeg, dan png!',
                    ]
                ]
            ])
        ) {
            

            $foto_bukti = $this->request->getFile('foto_bukti');
            $nama_file_foto = $foto_bukti->getRandomName();

            $data = [
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'keterangan' => $this->request->getPost('keterangan'),
                'foto_bukti' => $nama_file_foto,
            ];
            $foto_bukti->move(FCPATH . 'uploads', $nama_file_foto);
            $this->pelaporan->insertData($data);

            log_activity('Menambahkan data pelaporan baru: ' . $data['keterangan'] .
                ' (Email: ' . $data['email'] . ', No HP: ' . $data['no_hp'] . ')');

            session()->setFlashdata('pesan', 'Data berhasil di Tambahkan!');
            return redirect()->to('DataPelaporan/inputPelaporan');
        } else {
            log_activity('Gagal menambahkan data pelaporan: validasi form tidak lolos');

            return redirect()->to('DataPelaporan/inputPelaporan')->withInput();
        }
    }

    public function editData($id)
    {
        log_activity('Mengakses halaman edit data pelaporan dengan ID: ' . $id);

        $data = [
            'judul' => 'Edit Pelaporan',
            'page' => 'pelaporan/v_edit_data_pelaporan',
            'pelaporan' => $this->pelaporan->find($id),
        ];

        return view('v_template_user', $data);
    }

    public function detailData($id)
    {
        log_activity('Mengakses halaman detail data pelaporan dengan ID: ' . $id);

        $data = [
            'judul' => 'Edit Pelaporan',
            'page' => 'pelaporan/v_detail_data_pelaporan',
            'pelaporan' => $this->pelaporan->find($id),
        ];

        return view('v_template_user', $data);
    }

    public function updateData($id)
    {
        if (
            $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'valid_email' => '{field} Harus Berupa Alamat Email yang Valid!'
                    ]
                ],
                'no_hp' => [
                    'label' => 'Nomor HP',
                    'rules' => 'required|regex_match[/^[0-9]{10,15}$/]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'regex_match' => '{field} Harus Berupa Nomor HP yang Valid (10-15 digit)!'
                    ]
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'foto_bukti' => [
                    'label' => 'Foto Pelaporan',
                    'rules' => 'max_size[foto_bukti,1024]|mime_in[foto_bukti,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB!',
                        'mime_in' => 'Format {field} Harus jpg, jpeg, dan png!',
                    ]
                ]
            ])
        ) {
            $pelaporanLama = $this->pelaporan->find($id);

            $data = [
                'email' => $this->request->getPost('email'),
                'no_hp' => $this->request->getPost('no_hp'),
                'keterangan' => $this->request->getPost('keterangan'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $fotoDiganti = false;

            $foto = $this->request->getFile('foto_bukti');
            if ($foto->isValid() && !$foto->hasMoved()) {
                $nama_file_foto = $foto->getRandomName();
                $foto->move(FCPATH . 'uploads', $nama_file_foto);

                if ($pelaporanLama['foto_bukti']) {
                    @unlink(FCPATH . 'uploads/' . $pelaporanLama['foto_bukti']);
                }

                $data['foto_bukti'] = $nama_file_foto;
                $fotoDiganti = true;
            }

            $this->pelaporan->update($id, $data);



            $perubahanLog = 'Memperbarui data pelaporan ID: ' . $id .
                ' (Email: ' . $data['email'] . ', No HP: ' . $data['no_hp'] .
                ', Keterangan: ' . $data['keterangan'] . ')';

            log_activity($perubahanLog);

            session()->setFlashdata('pesan', 'Data berhasil diperbarui!');
            return redirect()->to('DataPelaporan');
        } else {
            log_activity('Gagal memperbarui data pelaporan ID: ' . $id . ': validasi form tidak lolos');

            return redirect()->to('DataPelaporan/editPelaporan/' . $id)->withInput();
        }
    }

    public function removeData($id)
    {
        $pelaporan = $this->pelaporan->find($id);

        log_activity('Menghapus data pelaporan ID: ' . $id);
        if ($pelaporan && !empty($pelaporan['foto_bukti'])) {
            @unlink(FCPATH . 'uploads/' . $pelaporan['foto_bukti']);
        }

        $this->pelaporan->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('DataPelaporan');
    }

}