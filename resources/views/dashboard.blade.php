@extends('layouts.app')

@section('content')
<div class="content text-center">
    <h2 class="fw-bold mb-4 mt-4">Dashboard</h2>

    @php
        $role = Auth::user()->role;
        // Col yapısını role göre belirle
        if ($role === 'admin') {
            $colClass = 'col-md-4'; // 3 kart için
        } elseif ($role === 'manager') {
            $colClass = 'col-md-6'; // 2 kart için
        } else {
            $colClass = 'col-md-8 offset-md-2'; // 1 kart için (ortalanmış)
        }
    @endphp

    <div class="row justify-content-center g-4">
        {{-- Aktif Müşteriler - Herkes Görebilir --}}
        <div class="{{ $colClass }}">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fa fa-users fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-primary">Aktif Müşteriler</h5>
                    <p class="text-muted mb-1">Tüm aktif müşterileri görüntüleyin ve yönetin.</p>
                    <h3 class="fw-bold text-dark mb-3">{{ $activeCustomers }}</h3>
                    <a href="{{ route('customers.index') }}" class="btn btn-primary w-100">Git</a>
                </div>
            </div>
        </div>

        {{-- Silinen Kayıtlar - Sadece Admin --}}
        @if($role === 'admin' && $deletedCustomers !== null)
            <div class="{{ $colClass }}">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fa fa-trash fa-3x text-danger"></i>
                        </div>
                        <h5 class="fw-bold text-danger">Silinen Kayıtlar</h5>
                        <p class="text-muted mb-1">Silinmiş müşterileri görüntüleyin ve geri yükleyin.</p>
                        <h3 class="fw-bold text-dark mb-3">{{ $deletedCustomers }}</h3>
                        <a href="{{ route('trash.customers') }}" class="btn btn-danger w-100">Gör</a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Kullanıcılar - Admin ve Manager --}}
        @if(in_array($role, ['admin', 'manager']) && $users !== null)
            <div class="{{ $colClass }}">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fa fa-user fa-3x text-secondary"></i>
                        </div>
                        <h5 class="fw-bold text-secondary">Kullanıcılar</h5>
                        <p class="text-muted mb-1">Sistemdeki kullanıcıları görüntüleyin.</p>
                        <h3 class="fw-bold text-dark mb-3">{{ $users }}</h3>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">Git</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
