// 📦 Gerekli bağımlılıklar
import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import { showToast } from "../utils/toast";

// DOM yüklendiğinde çalıştır
$(function () {
    const $table = $("#trashed-customers-table");
    if (!$table.length) return; // tablo yoksa çık

    // Eğer DataTable zaten başlatılmışsa, önce destroy et ve HTML'i temizle
    if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().clear().destroy();
        $table.empty(); // Tablo içeriğini temizle
    }

    // 🧾 DataTable başlat
    const table = $table.DataTable({
        ajax: "/trash/customers/data",
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
            { data: "code", name: "code", responsivePriority: 1 },
            { data: "name", name: "name", responsivePriority: 2 },
            { data: "address", name: "address", responsivePriority: 8 },
            { data: "phone", name: "phone", responsivePriority: 9 },
            { data: "email", name: "email", responsivePriority: 7 },
            { data: "creator_name", name: "creator_name", responsivePriority: 10 },
            { data: "created_at", name: "created_at", responsivePriority: 11 },
            { data: "updater_name", name: "updater_name", responsivePriority: 12 },
            { data: "updated_at", name: "updated_at", responsivePriority: 6 },
            { data: "deleter_name", name: "deleter_name", responsivePriority: 5 },
            { data: "deleted_at", name: "deleted_at", responsivePriority: 4 },
            { data: "delete_reason", name: "delete_reason", responsivePriority: 13 },
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
                previous: "Önceki",
                next: "Sonraki"
            },
            processing: "Yükleniyor..."
        }
    });

    // ♻️ Geri Yükle
    $table.on("click", ".restoreBtn", function () {
        const id = $(this).data("id");
        
        if (!confirm("Bu kaydı geri yüklemek istediğinize emin misiniz?")) return;
        
        $.ajax({
            url: `/trash/customers/${id}/restore`,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (res) {
                showToast("success", res.message || "Kayıt başarıyla geri yüklendi.");
                table.ajax.reload(null, false);
            },
            error: function (xhr) {
                showToast("error", xhr.responseJSON?.message || "Bir hata oluştu.");
            }
        });
    });

    // ❌ Kalıcı Sil
    $table.on("click", ".deleteBtn", function () {
        const id = $(this).data("id");
        if (!confirm("Bu kaydı kalıcı olarak silmek istediğinize emin misiniz?")) return;

        $.ajax({
            url: `/trash/customers/${id}/force-delete`,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: 'DELETE'
            },
            success: function (res) {
                showToast("delete", res.message || "Kayıt kalıcı olarak silindi.");
                table.ajax.reload(null, false);
            },
            error: function (xhr) {
                showToast("error", xhr.responseJSON?.message || "Silme işlemi başarısız oldu.");
            }
        });
    });
});
