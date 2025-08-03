<?php

namespace App\Controllers;
use App\Models\perlengkapanJalan;

class Home extends BaseController
{
    public function __construct()
    {
        $this->perlengkapanJalan = new perlengkapanJalan();
        $this->categories = [
            'rambu' => "Rambu Jalan",
            'marka' => "Marka Jalan",
            'apill' => "APILL",
            'pju' => "PJU",
            'pengaman' => "Pengaman Jalan",
            'pengendali' => "Pengendali Pemakai Jalan"
        ];

        $this->conditions = [
            'good' => "Baik",
            'damaged' => "Rusak",
            'plan' => "Rencana"
        ];
    }

    public function index(): string
    {
        log_activity('Mengakses halaman Dashboard');
        
        $data = [
            'judul' => 'Dashboard',
            'page' => 'v_dashboard',
        ];

        $builder = $this->perlengkapanJalan;

        $tahunDipilih = $this->request->getGet('tahun');

        $query = $builder
            ->select("jenis_perlengkapan, kondisi, COUNT(*) as total")
            ->groupBy('jenis_perlengkapan, kondisi')
            ->orderBy('kondisi', 'asc');

        if ($tahunDipilih) {
            $query->where("YEAR(terakhir_diupdate)", $tahunDipilih);
        }

        $dataTipe = $query->findAll();

        $daftarTahun = $builder
            ->select("YEAR(terakhir_diupdate) as tahun")
            ->groupBy("YEAR(terakhir_diupdate)")
            ->orderBy("tahun", "desc")
            ->findAll();


        $charts = [];
        foreach ($dataTipe as $row) {
            $charts[$row['jenis_perlengkapan']][] = [
                'kondisi' => $row['kondisi'],
                'total' => $row['total'],
            ];
        }

        $data = [
            'judul' => 'Dashboard',
            'page' => 'v_dashboard',
            'charts' => $charts,
            'daftarTahun' => array_column($daftarTahun, 'tahun'),
            'tahunDipilih' => $tahunDipilih,
        ];

        return view('v_template_user', $data);
    }

    public function apill_eksisting(): string
    {
        log_activity('Mengakses halaman APILL Eksisting');
        
        $data = [
            'judul' => 'APILL Eksisting',
            'page' => 'v_apill_eksisting',
        ];
        return view('v_template_admin', $data);
    }

    public function apill_perencanaan(): string
    {
        log_activity('Mengakses halaman APILL Perencanaan');
        
        $data = [
            'judul' => 'APILL Perencanaan',
            'page' => 'v_apill_perencanaan',
        ];
        return view('v_template_admin', $data);
    }

    public function apill_perbaikan(): string
    {
        log_activity('Mengakses halaman APILL Perbaikan');
        
        $data = [
            'judul' => 'APILL Perbaikan',
            'page' => 'v_apill_perbaikan',
        ];
        return view('v_template_admin', $data);
    }

    public function pju_eksisting(): string
    {
        log_activity('Mengakses halaman PJU Eksisting');
        
        $data = [
            'judul' => 'PJU Eksisting',
            'page' => 'v_pju_eksisting',
        ];
        return view('v_template_admin', $data);
    }

    public function pju_perencanaan(): string
    {
        log_activity('Mengakses halaman PJU Perencanaan');
        
        $data = [
            'judul' => 'PJU Perencanaan',
            'page' => 'v_pju_perencanaan',
        ];
        return view('v_template_admin', $data);
    }

    public function pju_perbaikan(): string
    {
        log_activity('Mengakses halaman PJU Perbaikan');
        
        $data = [
            'judul' => 'PJU Perbaikan',
            'page' => 'v_pju_perbaikan',
        ];
        return view('v_template_admin', $data);
    }

    public function marka_eksisting(): string
    {
        log_activity('Mengakses halaman Marka Eksisting');
        
        $data = [
            'judul' => 'Marka Eksisting',
            'page' => 'v_marka_eksisting',
        ];
        return view('v_template_admin', $data);
    }

    public function marka_perencanaan(): string
    {
        log_activity('Mengakses halaman Marka Perencanaan');
        
        $data = [
            'judul' => 'Marka Perencanaan',
            'page' => 'v_marka_perencanaan',
        ];
        return view('v_template_admin', $data);
    }

    public function marka_perbaikan(): string
    {
        log_activity('Mengakses halaman Marka Perbaikan');
        
        $data = [
            'judul' => 'Marka Perbaikan',
            'page' => 'v_marka_perbaikan',
        ];
        return view('v_template_admin', $data);
    }

    public function rambu_eksisting(): string
    {
        log_activity('Mengakses halaman Rambu Eksisting');
        
        $data = [
            'judul' => 'Rambu Eksisting',
            'page' => 'v_rambu_eksisting',
        ];

        return view('v_template_admin', $data);
    }

    public function rambu_perencanaan(): string
    {
        log_activity('Mengakses halaman Rambu Perencanaan');
        
        $data = [
            'judul' => 'Rambu Perencanaan',
            'page' => 'v_rambu_perencanaan',
        ];
        return view('v_template_admin', $data);
    }

    public function rambu_perbaikan(): string
    {
        log_activity('Mengakses halaman Rambu Perbaikan');
        
        $data = [
            'judul' => 'Rambu Perbaikan',
            'page' => 'v_rambu_perbaikan',
        ];
        return view('v_template_admin', $data);
    }

    public function pengaman_eksisting(): string
    {
        log_activity('Mengakses halaman Alat Pengaman Eksisting');
        
        $data = [
            'judul' => 'Alat Pengaman Eksisting',
            'page' => 'v_pengaman_eksisting',
        ];
        return view('v_template_admin', $data);
    }

    public function pengaman_perencanaan(): string
    {
        log_activity('Mengakses halaman Alat Pengaman Perencanaan');
        
        $data = [
            'judul' => 'Alat Pengaman Perencanaan',
            'page' => 'v_pengaman_perencanaan',
        ];
        return view('v_template_admin', $data);
    }

    public function pengaman_perbaikan(): string
    {
        log_activity('Mengakses halaman Alat Pengaman Perbaikan');
        
        $data = [
            'judul' => 'Alat Pengaman Perbaikan',
            'page' => 'v_pengaman_perbaikan',
        ];
        return view('v_template_admin', $data);
    }

    public function pengendali_eksisting(): string
    {
        log_activity('Mengakses halaman Alat Pengendali Eksisting');
        
        $data = [
            'judul' => 'Alat Pengendali Eksisting',
            'page' => 'v_pengendali_eksisting',
        ];
        return view('v_template_admin', $data);
    }

    public function pengendali_perencanaan(): string
    {
        log_activity('Mengakses halaman Alat Pengendali Perencanaan');
        
        $data = [
            'judul' => 'Alat Pengendali Perencanaan',
            'page' => 'v_pengendali_perencanaan',
        ];
        return view('v_template_admin', $data);
    }

    public function pengendali_perbaikan(): string
    {
        log_activity('Mengakses halaman Alat Pengendali Perbaikan');
        
        $data = [
            'judul' => 'Alat Pengendali Perbaikan',
            'page' => 'v_pengendali_perbaikan',
        ];

        return view('v_template_admin', $data);
    }

    public function apill_eksisting_user(): string
    {
        log_activity('Mengakses halaman APILL Eksisting (User)');
        
        $data = [
            'judul' => 'APILL Eksisting',
            'page' => 'v_apill_eksisting',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['apill'], $this->conditions['good']);

        return view('v_template_user', $data);
    }

    public function apill_perencanaan_user(): string
    {
        log_activity('Mengakses halaman APILL Perencanaan (User)');
        
        $data = [
            'judul' => 'APILL Perencanaan',
            'page' => 'v_apill_perencanaan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['apill'], $this->conditions['plan']);

        return view('v_template_user', $data);
    }

    public function apill_perbaikan_user(): string
    {
        log_activity('Mengakses halaman APILL Perbaikan (User)');
        
        $data = [
            'judul' => 'APILL Perbaikan',
            'page' => 'v_apill_perbaikan',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['apill'], $this->conditions['damaged']);

        return view('v_template_user', $data);
    }

    public function pju_eksisting_user(): string
    {
        log_activity('Mengakses halaman PJU Eksisting (User)');
        
        $data = [
            'judul' => 'PJU Eksisting',
            'page' => 'v_pju_eksisting',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pju'], $this->conditions['good']);

        return view('v_template_user', $data);
    }

    public function pju_perencanaan_user(): string
    {
        log_activity('Mengakses halaman PJU Perencanaan (User)');
        
        $data = [
            'judul' => 'PJU Perencanaan',
            'page' => 'v_pju_perencanaan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pju'], $this->conditions['plan']);
        return view('v_template_user', $data);
    }

    public function pju_perbaikan_user(): string
    {
        log_activity('Mengakses halaman PJU Perbaikan (User)');
        
        $data = [
            'judul' => 'PJU Perbaikan',
            'page' => 'v_pju_perbaikan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pju'], $this->conditions['damaged']);

        return view('v_template_user', $data);
    }

    public function marka_eksisting_user(): string
    {
        log_activity('Mengakses halaman Marka Eksisting (User)');
        
        $data = [
            'judul' => 'Marka Eksisting',
            'page' => 'v_marka_eksisting',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['marka'], $this->conditions['good']);

        return view('v_template_user', $data);
    }

    public function marka_perencanaan_user(): string
    {
        log_activity('Mengakses halaman Marka Perencanaan (User)');
        
        $data = [
            'judul' => 'Marka Perencanaan',
            'page' => 'v_marka_perencanaan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['marka'], $this->conditions['plan']);
        return view('v_template_user', $data);
    }

    public function marka_perbaikan_user(): string
    {
        log_activity('Mengakses halaman Marka Perbaikan (User)');
        
        $data = [
            'judul' => 'Marka Perbaikan',
            'page' => 'v_marka_perbaikan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['marka'], $this->conditions['damaged']);

        return view('v_template_user', $data);
    }

    public function rambu_eksisting_user(): string
    {
        log_activity('Mengakses halaman Rambu Eksisting (User)');
        
        $data = [
            'judul' => 'Rambu Eksisting',
            'page' => 'v_rambu_eksisting',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['rambu'], $this->conditions['good']);

        return view('v_template_user', $data);
    }

    public function rambu_perencanaan_user(): string
    {
        log_activity('Mengakses halaman Rambu Perencanaan (User)');
        
        $data = [
            'judul' => 'Rambu Perencanaan',
            'page' => 'v_rambu_perencanaan',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['rambu'], $this->conditions['plan']);
        return view('v_template_user', $data);
    }

    public function rambu_perbaikan_user(): string
    {
        log_activity('Mengakses halaman Rambu Perbaikan (User)');
        
        $data = [
            'judul' => 'Rambu Perbaikan',
            'page' => 'v_rambu_perbaikan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['rambu'], $this->conditions['damaged']);

        return view('v_template_user', $data);
    }

    public function pengaman_eksisting_user(): string
    {
        log_activity('Mengakses halaman Alat Pengaman Eksisting (User)');
        
        $data = [
            'judul' => 'Alat Pengaman Eksisting',
            'page' => 'v_pengaman_eksisting',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pengaman'], $this->conditions['good']);

        return view('v_template_user', $data);
    }

    public function pengaman_perencanaan_user(): string
    {
        log_activity('Mengakses halaman Alat Pengaman Perencanaan (User)');
        
        $data = [
            'judul' => 'Alat Pengaman Perencanaan',
            'page' => 'v_pengaman_perencanaan',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pengaman'], $this->conditions['plan']);
        return view('v_template_user', $data);
    }

    public function pengaman_perbaikan_user(): string
    {
        log_activity('Mengakses halaman Alat Pengaman Perbaikan (User)');
        
        $data = [
            'judul' => 'Alat Pengaman Perbaikan',
            'page' => 'v_pengaman_perbaikan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pengaman'], $this->conditions['damaged']);

        return view('v_template_user', $data);
    }

    public function pengendali_eksisting_user(): string
    {
        log_activity('Mengakses halaman Alat Pengendali Eksisting (User)');
        
        $data = [
            'judul' => 'Alat Pengendali Eksisting',
            'page' => 'v_pengendali_eksisting',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pengendali'], $this->conditions['good']);

        return view('v_template_user', $data);
    }

    public function pengendali_perencanaan_user(): string
    {
        log_activity('Mengakses halaman Alat Pengendali Perencanaan (User)');
        
        $data = [
            'judul' => 'Alat Pengendali Perencanaan',
            'page' => 'v_pengendali_perencanaan',
        ];

        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pengendali'], $this->conditions['plan']);
        return view('v_template_user', $data);
    }

    public function pengendali_perbaikan_user(): string
    {
        log_activity('Mengakses halaman Alat Pengendali Perbaikan (User)');
        
        $data = [
            'judul' => 'Alat Pengendali Perbaikan',
            'page' => 'v_pengendali_perbaikan',
        ];
        $data['coordinates'] = $this->perlengkapanJalan->getCoordinates($this->categories['pengendali'], $this->conditions['damaged']);

        return view('v_template_user', $data);
    }

    public function getcoordinat(): string
    {
        log_activity('Mengakses halaman Get Koordinat');
        
        $data = [
            'judul' => 'Get Coordinat',
            'page' => 'v_get_coordinat',
        ];
        return view('v_template', $data);
    }

    public function loginForm(): string
    {
        log_activity('Mengakses halaman Login');
        
        helper('form');
        $data = [
            'judul' => 'Login Form',
            'page' => 'v_login_form',
        ];
        return view('v_login', $data);
    }

    public function registerForm(): string
    {
        log_activity('Mengakses halaman Register');
        
        helper('form');
        $data = [
            'judul' => 'Register Form',
            'page' => 'v_register_form',
        ];
        return view('v_register', $data);
    }

    public function dashboard(): string
    {
        log_activity('Mengakses halaman Dashboard Admin');
        
        $data = [
            'judul' => 'Dashboard',
            'page' => 'v_dashboard',
        ];
        $data['result'] = [];
        return view('v_template_admin', $data);
    }

    public function dataTahun()
    {
        log_activity('Mengakses data tahun: ' . ($this->request->getGet('tahun') ?? 'semua tahun'));
        
        $tahun = $this->request->getGet('tahun');

        if (empty($tahun)) {
            $data = $this->perlengkapanJalan
            ->select('jenis_perlengkapan, kondisi, COUNT(*) as total')
            ->groupBy('jenis_perlengkapan, kondisi')
            ->orderBy('kondisi', 'asc')
            ->findAll();
        } else {
            $data = $this->perlengkapanJalan
            ->select('jenis_perlengkapan, kondisi, COUNT(*) as total')
            ->where('YEAR(terakhir_diupdate)', $tahun)
            ->groupBy('jenis_perlengkapan, kondisi')
            ->orderBy('kondisi', 'asc')
            ->findAll();
        }

        $formatted = [];
        foreach ($data as $item) {
            $jenis = $item['jenis_perlengkapan'];
            if (!isset($formatted[$jenis]))
                $formatted[$jenis] = [];
            $formatted[$jenis][] = [
                'kondisi' => $item['kondisi'],
                'total' => $item['total']
            ];
        }

        return $this->response->setJSON($formatted);
    }
}