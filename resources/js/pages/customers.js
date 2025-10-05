import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import { Modal } from "bootstrap";
import { showToast } from "../utils/toast";

$(function () {
    // ✅ document.ready garantisi
    const modalEl = document.getElementById("deleteModal");
    let deleteModal = null;

    // Modal gerçekten varsa bootstrap.Modal başlat
    if (modalEl) {
        deleteModal = new Modal(modalEl);
    }

    // Eğer DataTable zaten başlatılmışsa, önce destroy et ve HTML'i temizle
    const $table = $("#customers-table");
    if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().clear().destroy();
        $table.empty();
    }

    const table = $table.DataTable({
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
        scrollX: false, // Masaüstünde scroll yok, responsive sadece mobilde
        processing: true,
        serverSide: true,
        ajax: "/customers/data",
        pageLength: 100,
        lengthMenu: [
            [10, 20, 30, 50, 100, -1],
            [10, 20, 30, 50, 100, "Tümü"]
        ],
        columns: [
            { data: "code", name: "code", responsivePriority: 1 },
            { data: "name", name: "name", responsivePriority: 2 },
            { data: "address", name: "address", responsivePriority: 7 },
            { data: "phone", name: "phone", responsivePriority: 6 },
            { data: "email", name: "email", responsivePriority: 5 },
            { data: "creator.name", name: "creator.name", responsivePriority: 8 },
            { data: "created_at", name: "created_at", responsivePriority: 9 },
            { data: "updater_name", name: "updater_name", responsivePriority: 10 },
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
                previous: "Önceki",
                next: "Sonraki"
            },
            processing: "Yükleniyor..."
        }
    });

    // ✅ Delete modal aç
    $("#customers-table").on("click", ".deleteBtn", function () {
        const id = $(this).data("id");
        $("#deleteModal").data("id", id);
        if (deleteModal) deleteModal.show();
    });

    // ✅ Onay butonu
    $("#confirmDelete").on("click", function () {
        const id = $("#deleteModal").data("id");
        const reason = $('input[name="delete_reason"]:checked').val();

        if (!reason) {
            showToast("error", "Lütfen silme nedenini seçiniz.");
            return;
        }

        $.ajax({
            url: `/customers/${id}`,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: 'DELETE',
                reason: reason,
            },
            success: function (response) {
                table.ajax.reload(null, false);
                if (deleteModal) deleteModal.hide();
                showToast("delete", response.message);
            },
            error: function (xhr) {
                if (deleteModal) deleteModal.hide();
                showToast(
                    "error",
                    xhr.responseJSON?.message || "Bir hata oluştu."
                );
            },
        });
    });

    $("#customers-table").on("click", ".editBtn", function () {
        window.location.href = `/customers/${$(this).data("id")}/edit`;
    });

    $("#addCustomerBtn").on("click", function () {
        window.location.href = "/customers/create";
    });
   
});
