@extends('layouts.app')

@section('content')
<div class="content">
    <div class="block block-rounded shadow-sm border-0 mb-3">
        <div class="block-header d-flex justify-content-between align-items-center p-3">
            <h3 class="block-title">Silinen Müşteriler</h3>
        </div>
        <div class="block-content p-3">
            <div class="table-wrapper">
                <table id="trashed-customers-table" class="table table-bordered table-hover w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Müşteri Kodu</th>
                            <th>Müşteri Adı</th>
                            <th>Adres</th>
                            <th>Telefon</th>
                            <th>Email</th>
                            <th>Oluşturan Kullanıcı</th>
                            <th>Oluşturma Tarihi</th>
                            <th>Güncelleyen Kullanıcı</th>
                            <th>Güncelleme Tarihi</th>
                            <th>Silen Kullanıcı</th>
                            <th>Silinme Tarihi</th>
                            <th>Silme Nedeni</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module" src="{{ Vite::asset('resources/js/pages/trashedCustomers.js') }}"></script>
@endpush
