<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Models\Company;
use App\Models\Department;
use App\Services\SortOrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{

    public function create(){
        $companies = Company::orderBy('sort_order', 'asc')->get();
        return view('department.create', compact('companies'));
    }

    public function store(DepartmentStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $sortOrderService = new SortOrderService();
            $sortOrder = $sortOrderService->setDateTime('department', $request);
            Department::create([
                'name' => $request->name,
                'sort_order' => $sortOrder ?? Carbon::now(),
                'company_id' => $request->company_id,
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

    public function edit($id){
        $department = Department::with(['company'])->where('id',$id)->first();
        if(!$department){
            abort(404);
        }

        $companies = Company::orderBy('sort_order', 'asc')->get();
        return view('department.edit', compact('companies', 'department'));
    }

    public function update(DepartmentStoreRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $department = Department::where('id',$id)->first();
            if(!$department){
                abort(404);
            }
            $sortOrderService = new SortOrderService();
            $sortOrder = $sortOrderService->setDateTime('department', $request);

            $department->name = $request->name;
            $department->sort_order =  $sortOrder ?? Carbon::now();
            $department->company_id = $request->company_id;
            $department->save();
            
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
}
