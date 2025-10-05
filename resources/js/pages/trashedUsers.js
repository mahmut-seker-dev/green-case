import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import { showToast } from "../utils/toast";


$(function () {
    const $table = $("#trashed-users-table");
    if (!$table.length) return;

    // Eğer DataTable zaten başlatılmışsa, önce destroy et ve HTML'i temizle
    if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().clear().destroy();
        $table.empty(); // Tablo içeriğini temizle
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
        ajax: "/trash/users/data",
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
            { data: "updated_at", name: "updated_at", responsivePriority: 8 },
            { data: "deleted_at", name: "deleted_at", responsivePriority: 4 },
            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
                responsivePriority: 3,
                render: (data, type, row) => `
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success restoreBtn" data-id="${row.id}">Geri Yükle</button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}">Kalıcı Sil</button>
                    </div>
                `
            }
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

    // ♻️ Geri Yükleme
    $table.on("click", ".restoreBtn", function () {
        const id = $(this).data("id");
        
        if (!confirm("Bu kullanıcıyı geri yüklemek istediğinize emin misiniz?")) return;
        
        $.ajax({
            url: `/trash/users/${id}/restore`,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (res) {
                showToast("success", res.message || "Kullanıcı başarıyla geri yüklendi.");
                table.ajax.reload(null, false);
            },
            error: function (xhr) {
                showToast("error", xhr.responseJSON?.message || "Geri yükleme işlemi başarısız oldu.");
            },
        });
    });

    // ❌ Kalıcı Silme
    $table.on("click", ".deleteBtn", function () {
        const id = $(this).data("id");
        if (!confirm("Bu kullanıcıyı kalıcı olarak silmek istediğinize emin misiniz?"))
            return;

        $.ajax({
            url: `/trash/users/${id}/force-delete`,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: 'DELETE'
            },
            success: function (res) {
                showToast("delete", res.message || "Kullanıcı kalıcı olarak silindi.");
                table.ajax.reload(null, false);
            },
            error: function (xhr) {
                showToast("error", xhr.responseJSON?.message || "Kalıcı silme işlemi başarısız oldu.");
            },
        });
    });
});
