<form action="{{ $action }}" method="POST">
    @if (isset($method))
        @method($method)
    @endif
    @csrf
    <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Tên công ty</label>
        <input type="text" class="form-control" id="formGroupExampleInput" name="name" placeholder="Nhập tên công ty"
            value="{{ old('name') ? old('name') : (isset($company->name) ? $company->name : '') }}">
        @if ($errors->first('name'))
            <div class="text-danger">
                {{ $errors->first('name') }}
            </div>
        @endif
    </div>
    <div class="mb-3">
        <label for="sort_order">Chọn vị trí:</label>
        <select class="form-select" aria-label="Default select example" name="sort_order">
            @php
                $chooseSortOrder = old('sort_order') ? old('sort_order') : (isset($company->id) ? $company->id : '');
            @endphp
            <option value="" selected>Đầu tiên</option>
            @foreach ($companies as $value)
                <option value="{{ $value->id }}" {{ $chooseSortOrder == $value->id ? 'selected' : '' }}>Sau {{ $value->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->first('sort_order'))
            <div class="text-danger">
                {{ $errors->first('sort_order') }}
            </div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
</form>
