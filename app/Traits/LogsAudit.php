<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

trait LogsAudit
{
    public function logAudit($action, $docName,$details = null)
    {
        $user = Auth::user();

        audit::create([
            'action' => $action,
            'doc_name' => $docName,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'details' => $details,
        ]);
    }
}
