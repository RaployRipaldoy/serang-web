<?php
namespace App\Models;

use CodeIgniter\Model;

class LogActivity extends Model
{
    protected $table = 'tb_log_activities';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'activity', 'url', 'method', 'user_agent', 'ip_address'
    ];
    protected $useTimestamps = true;

    public function getAllWithUser()
    {
        return $this->select('tb_log_activities.*, users.name AS username, users.email AS email, users.role AS role')
                    ->join('users', 'users.id = tb_log_activities.user_id', 'left')
                    ->orderBy('tb_log_activities.created_at', 'DESC')
                    ->findAll();
    }
}
