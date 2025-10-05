@extends('layouts.app')

@section('title', 'Müşteri Listesi')

@section('content')
    <div class="block block-rounded shadow-sm border-0 mb-3">
        <div class="block-header d-flex justify-content-between align-items-center p-3">
            
                <h1 class="block-title mb-3">Müşteri Listesi</h1>
                @if (Auth::user()->role !== 'staff')
                    <button id="addCustomerBtn" class="btn btn-success">+ Yeni Müşteri Ekle</button>
                @endif
          
        </div>
        <div class="block-content p-3">
            <div class="table-wrapper">
                <table id="customers-table" class="table table-bordered table-hover js-dataTable">
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
                            @if (Auth::user()->role !== 'staff')
                                <th>İşlem</th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Silme Modalı -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Müşteri Silme</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bu müşteriyi silmek istediğinizden emin misiniz?</p>
                            <div class="mb-3">
                                <label class="form-label">Silme Nedeni:</label><br>
                                <input type="radio" name="delete_reason" value="Yanlış kayıt"> Yanlış kayıt <br>
                                <input type="radio" name="delete_reason" value="Talep üzerine silindi"> Talep üzerine
                                silindi
                                <br>
                                <input type="radio" name="delete_reason" value="Diğer"> Diğer
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Sil</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
