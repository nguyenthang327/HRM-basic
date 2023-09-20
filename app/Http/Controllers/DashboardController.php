<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $companies = Company::with(['departments' => function ($departments) {
            $departments->with(['groups' => function($groups) {
                    $groups->orderBy('groups.sort_order');
                }])
                ->orderBy('departments.sort_order');
            }])->orderBy('companies.sort_order', 'asc')->get();

        return view('dashboard', compact('companies'));
    }
}
