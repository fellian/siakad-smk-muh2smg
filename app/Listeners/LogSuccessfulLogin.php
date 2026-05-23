<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\ActivityLog;

class LogSuccessfulLogin
{
    
    public function __construct()
    {
        //
    }

    public function handle(Login $event): void
    {
        $user = $event->user;

        ActivityLog::create([
            'user_id'  => $user->id,
            'activity' => 'Berhasil masuk ke dalam sistem',
            'status'   => 'Sukses',
        ]);
    }
}