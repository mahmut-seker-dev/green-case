@extends('layouts.app')
@section('title', 'Yeni Müşteri Ekle')

@section('content')
<div class="container mt-4">
    <h1 class="h3 mb-4">➕ Yeni Müşteri Ekle</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('customers.partials.form', [
                'action' => route('customers.store'),
                'method' => 'POST'
            ])
        </div>
    </div>
</div>
@endsection
