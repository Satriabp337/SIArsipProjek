<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Audit;

class PengaturanController extends Controller
{
    public function pengaturan()
    {
        $latestAudit = Audit::orderBy('date', 'desc')->first();
        return view('pengaturan', compact('latestAudit'));
    }

    public function index()
    {
        $latestAudit = Audit::orderBy('date', 'desc')->first();

        // Get storage usage of "arsip" folder in local public disk
        $files = Storage::disk('public')->allFiles('arsip');
        $totalSize = 0;
        foreach ($files as $file) {
            $totalSize += Storage::disk('public')->size($file);
        }

        $usedGB = $totalSize / (1024 * 1024 * 1024); // size in GB
        $quotaGB = 10;
        $usagePercentage = min(100, ($usedGB / $quotaGB) * 100); // cap at 100%

        return view('pengaturan', compact('latestAudit', 'usagePercentage', 'usedGB', 'quotaGB'));
    }

    // (Optional) Remove this method entirely if no longer needed
    public function update(Request $request)
    {
        // No dynamic roles to update anymore
        return redirect()->route('pengaturan')->with('info', 'Fitur manajemen peran dinonaktifkan.');
    }
}