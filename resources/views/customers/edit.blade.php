@extends('layouts.app')
@section('title', 'Müşteri Güncelle')

@section('content')
<div class="container mt-4">
    <h1 class="h3 mb-4">✏️ Müşteri Güncelle</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('customers.partials.form', [
                'action' => route('customers.update', $customer->id),
                'method' => 'PUT',
                'customer' => $customer
            ])
        </div>
    </div>
</div>
@endsection
