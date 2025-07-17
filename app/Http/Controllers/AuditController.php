<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\audit;

class AuditController extends Controller
{
    public function showAuditLogs()
    {
        return view('audit');
    }

    public function getAuditLogs()
    {
        $audits = audit::orderBy('created_at', 'desc')->get();
        return response()->json($audits);
    }
}
