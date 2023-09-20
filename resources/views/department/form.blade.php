<form action="{{ $action }}" method="POST">
    @if (isset($method))
        @method($method)
    @endif
    @csrf

    {{-- handle logic when update --}}
    @php
        $chooseCompany = old('company_id') ? old('company_id') : (isset($department->company->id) ? $department->company->id : '');
        $departments = \App\Models\Department::orderBy('sort_order')
            ->where('company_id', $chooseCompany)
            ->get();
        $chooseDepartment = old('sort_order') ? old('sort_order') : (isset($department->id) ? $department->id : '');
    @endphp

    <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Tên phòng ban</label>
        <input type="text" class="form-control" id="formGroupExampleInput" name="name" placeholder="Nhập tên phòng ban"
            value="{{ old('name') ? old('name') : (isset($department->name) ? $department->name : '') }}">
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
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ $chooseCompany == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}</option>
            @endforeach
        </select>
        @if ($errors->first('company_id'))
            <div class="text-danger">
                {{ $errors->first('company_id') }}
            </div>
        @endif
    </div>
    <div class="mb-3">
        <label for="sort_order">Chọn vị trí:</label>
        <select class="form-select" id="select_department" data-placeholder="Đầu tiên" data-can_choose_plh="1"
            data-prefix="Sau " aria-label="Default select example" name="sort_order">
            @if ($departments)
                <option value="" selected>Đầu tiên</option>
                @foreach ($departments as $value)
                    <option value="{{ $company->id }}" {{ $chooseDepartment == $value->id ? 'selected' : '' }}>
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
