@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            @include('department.form', [
                'action' => route('department.store'),
                'method' => 'POST',
            ])
        </div>
    </div>
@endsection
