@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a class="btn btn-primary" href="{{ route('company.create') }}" role="button">Thêm công ty</a>
                <a class="btn btn-primary" href="{{ route('department.create') }}" role="button">Thêm phòng ban</a>
                <a class="btn btn-primary" href="{{ route('group.create') }}" role="button">Thêm đội/nhóm</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <h2>Show tree</h2>
                @foreach ($companies as $companyKey => $company)
                    <ul style="list-style-type:none;">
                        <li>{{ ++$companyKey . '. ' . $company->name }} <a href="{{route('company.edit', ['id' => $company->id])}}"><i>Edit</i></a></li>

                        @foreach ($company->departments as $departmentKey => $department)
                            <ul style="list-style-type:none;">
                                <li>{{ $companyKey . '.' . ++$departmentKey . ' ' . $department->name }} <a
                                        href="{{route('department.edit', ['id' => $department->id])}}"><i>Edit</i></a></li>
                                @foreach ($department->groups as $groupKey => $group)
                                    <ul style="list-style-type:none;">
                                        <li>{{ $companyKey . '.' . $departmentKey . '.' . ++$groupKey . ' ' . $group->name }} <a href="{{route('group.edit', ['id' => $group->id])}}"><i>Edit</i></a>
                                        </li>
                                    </ul>
                                @endforeach
                            </ul>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
@endsection
