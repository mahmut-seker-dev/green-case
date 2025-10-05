@extends('layouts.app')
@section('title', 'Kullanıcı Düzenle')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>👤 Kullanıcıyı Düzenle</h1>
</div>

<div class="card p-4 shadow-sm">
    <form id="editUserForm" data-id="{{ $user->id }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Ad Soyad</label>
            <input type="text" class="form-control" id="name" value="{{ $user->name }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-posta</label>
            <input type="email" class="form-control" id="email" value="{{ $user->email }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Yeni Şifre (opsiyonel)</label>
            <input type="password" class="form-control" id="password">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
</div>
@endsection

@vite(['resources/js/pages/users_edit.js'])
