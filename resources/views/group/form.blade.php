<form action="{{ $action }}" method="POST">
    @if (isset($method))
        @method($method)
    @endif
    @csrf

    {{-- handle logic when update  --}}
    @php
        $chooseCompany = old('company_id') ? old('company_id') : (isset($group->company_id) ? $group->company_id : '');
        $chooseDepartment = old('department_id') ? old('department_id') : (isset($group->department_id) ? $group->department_id : '');
        $chooseGroup = old('sort_order') ? old('sort_order') : (isset($group->id) ? $group->id : '');
        
        $departments = \App\Models\Department::orderBy('sort_order')
            ->where('company_id', $chooseCompany)
            ->get();
        $groups = \App\Models\Group::orderBy('sort_order')
            ->where('department_id', $chooseDepartment)
            ->get();
    @endphp

    <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Tên đội/nhóm</label>
        <input type="text" class="form-control" id="formGroupExampleInput" name="name" placeholder="Nhập tên đội/nhóm"
            value="{{ old('name') ? old('name') : (isset($group->name) ? $group->name : '') }}">
        @if ($errors->first('name'))
            <div class="text-danger">
                {{ $errors->first('name') }}
            </div>
        @endif
    </div>
    <div class="mb-3">
        <label for="company_id">Chọn công ty:</label>
        <select class="form-select dynamic-select-option" data-child="#select_department"
            data-url="{{ route('getDepartmentByCompany') }}" aria-label="Default select example" name="company_id">
            <option value="" selected disabled>Vui lòng chọn công ty</option>
            @foreach ($companies as $value)
                <option value="{{ $value->id }}" {{ $chooseCompany == $value->id ? 'selected' : '' }}>
                    {{ $value->name }}</option>
            @endforeach
        </select>
        @if ($errors->first('company_id'))
            <div class="text-danger">
                {{ $errors->first('company_id') }}
            </div>
        @endif
    </div>
    <div class="mb-3">
        <label for="department_id">Chọn phòng ban:</label>
        <select class="form-select dynamic-select-option" id="select_department" data-child="#select_group"
            data-placeholder="Vui lòng chọn phòng ban" data-can_choose_plh="0" data-prefix=""
            data-url="{{ route('getGroupByDepartment') }}" aria-label="Default select example" name="department_id">
            <option value="" selected disabled>Vui lòng chọn phòng ban</option>
            @if ($departments)
                @foreach ($departments as $value)
                    <option value="{{ $value->id }}" {{ $chooseDepartment == $value->id ? 'selected' : '' }}>
                        {{ $value->name }}</option>
                @endforeach
            @endif
        </select>
        @if ($errors->first('department_id'))
            <div class="text-danger">
                {{ $errors->first('department_id') }}
            </div>
        @endif
    </div>
    <div class="mb-3">
        <label for="sort_order">Chọn vị trí:</label>
        <select class="form-select" id="select_group" data-placeholder="Đầu tiên" data-can_choose_plh="1"
            data-prefix="Sau " aria-label="Default select example" name="sort_order">
            @if ($groups)
                <option value="" selected>Đầu tiên</option>
                @foreach ($groups as $value)
                    <option value="{{ $value->id }}" {{ $chooseGroup == $value->id ? 'selected' : '' }}>
                        Sau {{ $value->name }}</option>
                @endforeach
            @endif
        </select>
        @if ($errors->first('sort_order'))
            <div class="text-danger">
                {{ $errors->first('sort_order') }}
            </div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
</form>
