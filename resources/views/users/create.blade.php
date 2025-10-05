@extends('layouts.app')
@section('title', 'Yeni Kullanıcı Ekle')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>👤 Yeni Kullanıcı Ekle</h1>
</div>

<div class="card p-4 shadow-sm">
    <form id="createUserForm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Ad Soyad</label>
            <input type="text" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-posta</label>
            <input type="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Şifre</label>
            <input type="password" class="form-control" id="password" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select id="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Kaydet</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection

@vite(['resources/js/pages/users_create.js'])
