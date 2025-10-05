@extends('layouts.app')
@section('title', 'Kullanıcılar')

@section('content')
    <div class="block block-rounded shadow-sm border-0 mb-3">
        <div class="block-header d-flex justify-content-between align-items-center p-3">
            <h1> Kullanıcılar</h1>
            <a href="{{ route('users.create') }}" class="btn btn-success"> Yeni Kullanıcı Ekle</a>
        </div>

        <div class="block-content p-3">
            <div class="table-wrapper">
                <table id="users-table" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>İsim</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Oluşturma Tarihi</th>
                            <th>Güncelleme Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@vite(['resources/js/pages/users.js'])
