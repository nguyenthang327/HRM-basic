<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Models\Company;
use App\Models\Group;
use App\Services\SortOrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{

    public function create()
    {
        $companies = Company::orderBy('sort_order', 'asc')->get();
        return view('group.create', compact('companies'));
    }

    public function store(GroupStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $sortOrderService = new SortOrderService();
            $sortOrder = $sortOrderService->setDateTime('group', $request);
            Group::create([
                'name' => $request->name,
                'sort_order' =>  $sortOrder ?? Carbon::now(),
                'department_id' => $request->department_id,
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
        $group = Group::select([
            'companies.id as company_id',
            'groups.*'
        ])
            ->join('departments', 'departments.id', 'groups.department_id')
            ->join('companies', 'companies.id', 'departments.company_id')
            ->where('groups.id', $id)
            ->first();

        if (!$group) {
            abort(404);
        }

        $companies = Company::orderBy('sort_order', 'asc')->get();
        return view('group.edit', compact('companies', 'group'));
    }

    public function update(GroupStoreRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $group = Group::where('groups.id', $id)->first();

            if (!$group) {
                abort(404);
            }

            $sortOrderService = new SortOrderService();
            $sortOrder = $sortOrderService->setDateTime('group', $request);

            $group->name = $request->name;
            $group->sort_order = $sortOrder ?? Carbon::now();
            $group->department_id = $request->department_id;
            $group->save();

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
