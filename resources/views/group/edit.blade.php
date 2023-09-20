@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            @include('group.form', [
                'group' => $group,
                'action' => route('group.update', ['id' => $group->id]),
                'method' => 'PUT',
            ])
        </div>
    </div>
@endsection
