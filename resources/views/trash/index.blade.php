@extends('layouts.app')
@section('title', 'Silinen Kayıtlar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>🗑️ Silinen Kayıtlar</h1>
</div>

<ul class="nav nav-tabs mb-3" id="trashTabs">
    <li class="nav-item">
        <button class="nav-link active" data-type="customers">Silinmiş Müşteriler</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-type="users">Silinmiş Kullanıcılar</button>
    </li>
</ul>

<div class="table-responsive-md">
    <table id="trash-table" class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr id="trash-head"></tr>
        </thead>
    </table>
</div>
@endsection

@vite(['resources/js/pages/trashed.js'])
