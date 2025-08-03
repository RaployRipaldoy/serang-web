<?php

namespace App\Controllers;

use App\Models\LogActivity;

class DataLogActivity extends BaseController
{
    public function __construct()
    {
        $this->logActivity = new LogActivity();
    }

    public function index(): string
    {
        log_activity('Mengakses halaman Data Pemeliharaan');
    
        $data = [
            'judul' => 'Data Log Aktivitas',
            'page' => 'log_activity/v_data_log_activity',
            'log_activity' => $this->logActivity->getAllWithUser()
        ];
    
        return view('v_template_user', $data);
    }

}