@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            @include('company.form', [
                'action' => route('company.store'),
                'method' => 'POST',
            ])
        </div>
    </div>
@endsection
