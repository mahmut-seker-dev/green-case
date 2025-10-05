@extends('layouts.app')

@section('content')
<div class="content">
    <div class="block block-rounded shadow-sm border-0 mb-3" >
        <div class="block-header d-flex justify-content-between align-items-center p-3">
            <h3 class="block-title mb-0">Silinen Kullanıcılar</h3>
        </div>

        <div class="block-content p-3">
            <div class="table-wrapper">
                <table id="trashed-users-table" class="table table-bordered table-hover w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Oluşturma Tarihi</th>
                            <th>Güncelleme Tarihi</th>
                            <th>Silinme Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module" src="{{ Vite::asset('resources/js/pages/trashedUsers.js') }}"></script>
@endpush
