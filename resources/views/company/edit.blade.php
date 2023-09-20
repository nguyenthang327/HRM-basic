@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            @include('company.form', [
                'company' => $company,
                'action' => route('company.update', ['id' => $company->id]),
                'method' => 'PUT',
            ])
        </div>
    </div>
@endsection
