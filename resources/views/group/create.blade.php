@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            @include('group.form', [
                'action' => route('group.store'),
                'method' => 'POST',
            ])
        </div>
    </div>
@endsection
