@extends('layouts.app')
@section('title', 'Profil Bilgilerim')

@section('content')
<div class="container mt-4">
    <h1 class="h3 mb-4">👤 Profil Bilgilerim</h1>

    <div class="row">
        <!-- Profil Bilgileri -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Kişisel Bilgiler</h5>
                </div>
                <div class="card-body">
                    <form id="profileForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                            <small class="text-muted">Rol bilgisi değiştirilemez</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kayıt Tarihi</label>
                            <input type="text" class="form-control" 
                                   value="{{ $user->created_at->format('d.m.Y H:i') }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Bilgileri Güncelle
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Şifre Değiştir -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">🔒 Şifre Değiştir</h5>
                </div>
                <div class="card-body">
                    <form id="passwordForm">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mevcut Şifre</label>
                            <input type="password" class="form-control" id="current_password" 
                                   name="current_password" required>
                            <small class="text-muted">Güvenlik için mevcut şifrenizi girmelisiniz</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Yeni Şifre</label>
                            <input type="password" class="form-control" id="new_password" 
                                   name="new_password" required minlength="6">
                            <small class="text-muted">En az 6 karakter olmalıdır</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Yeni Şifre (Tekrar)</label>
                            <input type="password" class="form-control" id="new_password_confirmation" 
                                   name="new_password_confirmation" required minlength="6">
                            <small class="text-muted">Yeni şifrenizi tekrar girin</small>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-key"></i> Şifreyi Değiştir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@vite(['resources/js/pages/profile.js'])
