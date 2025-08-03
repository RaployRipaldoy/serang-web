<?php

use App\Models\LogActivity;

if (!function_exists('log_activity')) {
    function log_activity(string $activity)
    {
        $model = new LogActivity();

        $session = session();
        $user_id = $session->get('id') ?? null;

        $model->insert([
            'user_id'     => $user_id,
            'activity'    => $activity,
            'url'         => current_url(),
            'method'      => service('request')->getMethod(),
            'user_agent'  => service('request')->getUserAgent(),
            'ip_address'  => service('request')->getIPAddress(),
        ]);
    }
}
