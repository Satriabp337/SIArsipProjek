<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\Department;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalDocuments' => Documents::count(),
            'totalCategories' => Category::count(),
            'totalDepartments' => Department::count(),
            'totalUsers' => User::count(),
            'recentDocuments' => Documents::latest()->take(5)->get(),
        ]);
    }
}
