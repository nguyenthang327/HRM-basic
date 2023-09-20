<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Department;
use App\Models\Group;

class SortOrderService
{
    public function setDateTime($model, $request)
    {
        switch ($model) {
            case 'company':
                $model = Company::select('sort_order');
                break;
            case 'department':
                $model = Department::select('sort_order')->where('company_id', $request->company_id);
                break;

            case 'group':
                $model = Group::select('sort_order')->where('department_id', $request->department_id);
                break;
            default:
                return null;
        }

        $cloneQuery1 = clone $model;
        $cloneQuery2 = clone $model;
        $cloneQuery3 = clone $model;

        if (!isset($request->sort_order)) {
            $firstOrder = $cloneQuery1->orderBy('sort_order', 'asc')->first();
            $maxTime = isset($firstOrder) ? strtotime($firstOrder->sort_order) : time();
            return date('Y-m-d H:i:s', $maxTime - 7200);
        } else {
            $prev = $cloneQuery2->where('id', $request->sort_order)->first();
            $next = $cloneQuery3->where('sort_order', '>', $prev->sort_order)->orderBy('sort_order', 'asc')->first();

            $minTime = isset($prev) ? strtotime($prev->sort_order) : time();
            $maxTime = isset($next) ? strtotime($next->sort_order) : time();
            $randTime = rand($minTime, $maxTime);

            return date('Y-m-d H:i:s', $randTime);
        }
    }
}
