import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import { Modal } from "bootstrap";
import { showToast } from "../utils/toast";

$(function () {
    // Eğer DataTable zaten başlatılmışsa, önce destroy et ve HTML'i temizle
    const $table = $("#users-table");
    if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().clear().destroy();
        $table.empty();
    }

    const table = $table.DataTable({
        layout: {
            bottomEnd: {
                paging: {
                    numbers: true,      // Sayfa numaralarını göster
                    firstLast: true,    // « ve » butonlarını göster
                    previousNext: true, // Önceki/Sonraki butonlarını göster
                    type: 'full_numbers' // Tam sayfa kontrolü
                }
            }
        },
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            },
            breakpoints: [
                { name: 'desktop', width: Infinity },
                { name: 'tablet-l', width: 1024 },
                { name: 'tablet-p', width: 768 },
                { name: 'mobile-l', width: 480 },
                { name: 'mobile-p', width: 320 }
            ]
        },
        scrollX: false,
        processing: true,
        serverSide: true,
        ajax: "/users/data",
        pageLength: 100,
        lengthMenu: [
            [10, 20, 30, 50, 100, -1],
            [10, 20, 30, 50, 100, "Tümü"]
        ],
        columns: [
            { data: "id", name: "id", responsivePriority: 1 },
            { data: "name", name: "name", responsivePriority: 2 },
            { data: "email", name: "email", responsivePriority: 5 },
            { data: "role", name: "role", responsivePriority: 6 },
            { data: "created_at", name: "created_at", responsivePriority: 7 },
            { data: "updated_at", name: "updated_at", responsivePriority: 4 },
            { 
                data: "actions", 
                name: "actions", 
                orderable: false, 
                searchable: false,
                responsivePriority: 3
            },
        ],
        language: {
            lengthMenu: "Sayfada _MENU_ kayıt göster",
            info: "Toplam _TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
            infoEmpty: "Kayıt bulunamadı",
            infoFiltered: "(_MAX_ kayıt içinden filtrelendi)",
            search: "Ara:",
            paginate: {
                first: "İlk",
                previous: "Önceki",
                next: "Sonraki",
                last: "Son"
            },
            processing: "Yükleniyor..."
        },
        drawCallback: function() {
            // Sadece 3 sayfa numarası göster (aktif + önceki + sonraki)
            const api = this.api();
            const currentPage = api.page();
            
            $('.dt-paging-button').each(function() {
                const $btn = $(this);
                const pageIdx = $btn.find('button').attr('data-dt-idx');
                
                // İlk, Son, Önceki, Sonraki, Ellipsis ve Aktif sayfayı her zaman göster
                if ($btn.hasClass('first') || $btn.hasClass('last') || 
                    $btn.hasClass('previous') || $btn.hasClass('next') ||
                    $btn.hasClass('active') || $btn.find('.ellipsis').length > 0) {
                    return;
                }
                
                // Sayfa numarasını kontrol et
                const pageNum = parseInt(pageIdx);
                if (!isNaN(pageNum)) {
                    // Aktif sayfadan 1 önceki ve 1 sonrakini göster
                    if (pageNum < currentPage - 1 || pageNum > currentPage + 1) {
                        $btn.hide();
                    } else {
                        $btn.show();
                    }
                }
            });
        }
    });

    // 🗑️ Kullanıcı Silme
    $("#users-table").on("click", ".deleteUserBtn", function () {
        const id = $(this).data("id");

        // Modal veya alert ile onay
        if (!confirm("Bu kullanıcıyı silmek istediğinize emin misiniz?")) return;

        $.ajax({
            url: `/users/${id}`,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: 'DELETE'
            },
            success: (res) => {
                table.ajax.reload(null, false);
                showToast("delete", res.message || "Kullanıcı başarıyla silindi.");
            },
            error: (xhr) => {
                showToast(
                    "error",
                    xhr.responseJSON?.message || "Bir hata oluştu, işlem başarısız."
                );
            },
        });
    });

    // 👤 Düzenleme yönlendirmesi
    $("#users-table").on("click", ".editUserBtn", function () {
        const id = $(this).data("id");
        window.location.href = `/users/${id}/edit`;
    });
    
});
