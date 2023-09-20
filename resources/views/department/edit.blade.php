@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            @include('department.form', [
                'department' => $department,
                'action' => route('department.update', ['id' => $department->id]),
                'method' => 'PUT',
            ])
        </div>
    </div>
@endsection
