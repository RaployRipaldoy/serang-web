<?php

namespace App\Controllers;
use App\Models\perlengkapanJalan;

class Home extends BaseController
{
    protected $perlengkapanJalan;
    protected $categories;
    protected $conditions;

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

        $perbandinganDipilih = $this->request->getGet('perbandingan');

        // daftar tahun 
        $daftarTahun = $builder
            ->select("YEAR(terakhir_diupdate) as tahun")
            ->groupBy("YEAR(terakhir_diupdate)")
            ->orderBy("tahun", "asc")
            ->findAll();

        $tahunArray = array_column($daftarTahun, 'tahun');

        // perbandingan year-by-year
        $daftarPerbandingan = [];
        for ($i = 0; $i < count($tahunArray) - 1; $i++) {
            $tahunSebelum = $tahunArray[$i];
            $tahunSesudah = $tahunArray[$i + 1];
            $daftarPerbandingan[] = $tahunSebelum . '-' . $tahunSesudah;
        }

        
        if (!$perbandinganDipilih && !empty($daftarPerbandingan)) {
            $perbandinganDipilih = end($daftarPerbandingan); 
        }

        $histogramData = [];

        if ($perbandinganDipilih) {
            $tahunRange = explode('-', $perbandinganDipilih);
            $tahunSebelum = $tahunRange[0];
            $tahunSesudah = $tahunRange[1];

    
            $dataSebelum = $builder
                ->select("jenis_perlengkapan, kondisi, COUNT(*) as total")
                ->where("YEAR(terakhir_diupdate)", $tahunSebelum)
                ->groupBy('jenis_perlengkapan, kondisi')
                ->findAll();

            $dataSesudah = $builder
                ->select("jenis_perlengkapan, kondisi, COUNT(*) as total")
                ->where("YEAR(terakhir_diupdate)", $tahunSesudah)
                ->groupBy('jenis_perlengkapan, kondisi')
                ->findAll();

      
            $dataSebelumArray = [];
            foreach ($dataSebelum as $item) {
                $key = $item['jenis_perlengkapan'] . '_' . $item['kondisi'];
                $dataSebelumArray[$key] = $item['total'];
            }

            $dataSesudahArray = [];
            foreach ($dataSesudah as $item) {
                $key = $item['jenis_perlengkapan'] . '_' . $item['kondisi'];
                $dataSesudahArray[$key] = $item['total'];
            }

      
            $semuaKombinasi = array_unique(array_merge(array_keys($dataSebelumArray), array_keys($dataSesudahArray)));

            foreach ($semuaKombinasi as $kombinasi) {
                $parts = explode('_', $kombinasi);
                $jenis = $parts[0];
                $kondisi = $parts[1];
                
                $totalSebelum = isset($dataSebelumArray[$kombinasi]) ? $dataSebelumArray[$kombinasi] : 0;
                $totalSesudah = isset($dataSesudahArray[$kombinasi]) ? $dataSesudahArray[$kombinasi] : 0;
                
                $histogramData[] = [
                    'jenis' => $jenis,
                    'kondisi' => $kondisi,
                    'label' => $jenis . ' (' . $kondisi . ')',
                    'tahun_sebelum' => $tahunSebelum,
                    'tahun_sesudah' => $tahunSesudah,
                    'total_sebelum' => $totalSebelum,
                    'total_sesudah' => $totalSesudah,
                    'perubahan' => $totalSesudah - $totalSebelum
                ];
            }

          
            $totalKeseluruhanSebelum = 0;
            $totalKeseluruhanSesudah = 0;
            foreach ($histogramData as $item) {
                $totalKeseluruhanSebelum += $item['total_sebelum'];
                $totalKeseluruhanSesudah += $item['total_sesudah'];
            }
            
            $perubahanTotal = $totalKeseluruhanSesudah - $totalKeseluruhanSebelum;
            $persentasePerubahan = $totalKeseluruhanSebelum > 0 ? round(($perubahanTotal / $totalKeseluruhanSebelum) * 100, 1) : 0;
        } else {
  
            $totalKeseluruhanSebelum = 0;
            $totalKeseluruhanSesudah = 0;
            $perubahanTotal = 0;
            $persentasePerubahan = 0;
        }

        $data = [
            'judul' => 'Dashboard',
            'page' => 'v_dashboard',
            'histogramData' => $histogramData,
            'daftarPerbandingan' => $daftarPerbandingan,
            'perbandinganDipilih' => $perbandinganDipilih,
            'totalKeseluruhanSebelum' => $totalKeseluruhanSebelum,
            'totalKeseluruhanSesudah' => $totalKeseluruhanSesudah,
            'perubahanTotal' => $perubahanTotal,
            'persentasePerubahan' => $persentasePerubahan,
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
        $perbandinganDipilih = $this->request->getGet('perbandingan');
        $builder = $this->perlengkapanJalan;

        $histogramData = [];

        if ($perbandinganDipilih) {
            $tahunRange = explode('-', $perbandinganDipilih);
            $tahunSebelum = $tahunRange[0];
            $tahunSesudah = $tahunRange[1];

            // Ambil data tahun sebelum dengan kondisi
            $dataSebelum = $builder
                ->select("jenis_perlengkapan, kondisi, COUNT(*) as total")
                ->where("YEAR(terakhir_diupdate)", $tahunSebelum)
                ->groupBy('jenis_perlengkapan, kondisi')
                ->findAll();

            // Ambil data tahun sesudah dengan kondisi
            $dataSesudah = $builder
                ->select("jenis_perlengkapan, kondisi, COUNT(*) as total")
                ->where("YEAR(terakhir_diupdate)", $tahunSesudah)
                ->groupBy('jenis_perlengkapan, kondisi')
                ->findAll();

            // Konversi ke array dengan jenis dan kondisi sebagai key
            $dataSebelumArray = [];
            foreach ($dataSebelum as $item) {
                $key = $item['jenis_perlengkapan'] . '_' . $item['kondisi'];
                $dataSebelumArray[$key] = $item['total'];
            }

            $dataSesudahArray = [];
            foreach ($dataSesudah as $item) {
                $key = $item['jenis_perlengkapan'] . '_' . $item['kondisi'];
                $dataSesudahArray[$key] = $item['total'];
            }

            // Gabungkan semua kombinasi jenis dan kondisi
            $semuaKombinasi = array_unique(array_merge(array_keys($dataSebelumArray), array_keys($dataSesudahArray)));

            foreach ($semuaKombinasi as $kombinasi) {
                $parts = explode('_', $kombinasi);
                $jenis = $parts[0];
                $kondisi = $parts[1];
                
                $totalSebelum = isset($dataSebelumArray[$kombinasi]) ? $dataSebelumArray[$kombinasi] : 0;
                $totalSesudah = isset($dataSesudahArray[$kombinasi]) ? $dataSesudahArray[$kombinasi] : 0;
                
                $histogramData[] = [
                    'jenis' => $jenis,
                    'kondisi' => $kondisi,
                    'label' => $jenis . ' (' . $kondisi . ')',
                    'tahun_sebelum' => $tahunSebelum,
                    'tahun_sesudah' => $tahunSesudah,
                    'total_sebelum' => $totalSebelum,
                    'total_sesudah' => $totalSesudah,
                    'perubahan' => $totalSesudah - $totalSebelum
                ];
            }

            // Hitung total keseluruhan untuk AJAX response
            $totalKeseluruhanSebelum = 0;
            $totalKeseluruhanSesudah = 0;
            foreach ($histogramData as $item) {
                $totalKeseluruhanSebelum += $item['total_sebelum'];
                $totalKeseluruhanSesudah += $item['total_sesudah'];
            }
            
            $perubahanTotal = $totalKeseluruhanSesudah - $totalKeseluruhanSebelum;
            $persentasePerubahan = $totalKeseluruhanSebelum > 0 ? round(($perubahanTotal / $totalKeseluruhanSebelum) * 100, 1) : 0;

            $response = [
                'data' => $histogramData,
                'summary' => [
                    'totalSebelum' => $totalKeseluruhanSebelum,
                    'totalSesudah' => $totalKeseluruhanSesudah,
                    'perubahan' => $perubahanTotal,
                    'persentase' => $persentasePerubahan
                ]
            ];
        } else {
            $response = [
                'data' => [],
                'summary' => [
                    'totalSebelum' => 0,
                    'totalSesudah' => 0,
                    'perubahan' => 0,
                    'persentase' => 0
                ]
            ];
        }

        return $this->response->setJSON($response);
    }
}