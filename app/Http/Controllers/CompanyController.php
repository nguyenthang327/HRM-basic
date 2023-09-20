<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Group;
use App\Services\SortOrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function create()
    {
        $companies = Company::orderBy('sort_order', 'asc')->get();
        return view('company.create', compact('companies'));
    }

    public function store(CompanyStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $sortOrderService = new SortOrderService();
            $sortOrder = $sortOrderService->setDateTime('company', $request);
            Company::create([
                'name' => $request->name,
                'sort_order' => $sortOrder ?? Carbon::now(),
            ]);
            DB::commit();
            return redirect()->route('dashboard')
                ->with(['status_successed' => 'success']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->back()
                ->with(['status_failed' => 'fail']);
        }
    }

    public function edit($id)
    {
        $company = Company::where('id', $id)->first();
        if (!$company) {
            abort(404);
        }
        $companies = Company::orderBy('sort_order', 'asc')->get();
        return view('company.edit', compact('companies', 'company'));
    }

    public function update(CompanyStoreRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $company = Company::where('id', $id)->first();
            if (!$company) {
                abort(404);
            }
            $sortOrderService = new SortOrderService();
            $sortOrder = $sortOrderService->setDateTime('company', $request);

            $company->name = $request->name;
            $company->sort_order = $sortOrder ?? Carbon::now();
            $company->save();

            DB::commit();
            return redirect()->route('dashboard')
                ->with(['status_successed' => 'success']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->back()
                ->with(['status_failed' => 'fail']);
        }
    }

    public function getDepartmentByCompany(Request $request)
    {
        $departments = Department::select('id', 'name')
            ->where('company_id', $request->id)
            ->orderBy('departments.sort_order')
            ->get();
        return response([
            'status' => 200,
            'data' => $departments,
        ], 200);
    }

    public function getGroupByDepartment(Request $request)
    {
        $groups = Group::select('id', 'name')
            ->where('department_id', $request->id)
            ->orderBy('groups.sort_order')
            ->get();
        return response([
            'status' => 200,
            'data' => $groups,
        ], 200);
    }
}
