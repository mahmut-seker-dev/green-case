import * as bootstrap from "bootstrap";
import $ from "jquery";

export function showToast(action, message) {
    const config = {
        add: { bg: "bg-success", icon: "➕", title: "Müşteri Eklendi" },
        edit: { bg: "bg-primary", icon: "✏️", title: "Müşteri Güncellendi" },
        delete: { bg: "bg-danger", icon: "🗑️", title: "Müşteri Silindi" },
        restore: { bg: "bg-warning text-dark", icon: "♻️", title: "Müşteri Geri Yüklendi" },
        force: { bg: "bg-dark", icon: "⚠️", title: "Kalıcı Silindi" },
        error: { bg: "bg-danger", icon: "❌", title: "Hata" },
        success: { bg: "bg-success", icon: "✅", title: "Başarılı" }, // ✅ eklendi
    };

    const cfg = config[action] || config.error;
    const toastId = `toast-${Date.now()}`;

    const toastHtml = `
        <div id="${toastId}" 
             class="toast align-items-center text-white ${cfg.bg} border-0" 
             role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
              <strong>${cfg.icon} ${cfg.title}:</strong> ${message}
            </div>
            <button type="button" 
                    class="btn-close btn-close-white me-2 m-auto" 
                    data-bs-dismiss="toast" 
                    aria-label="Close"></button>
          </div>
        </div>`;

    $("#toastContainer").append(toastHtml);

    const toastEl = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();

    setTimeout(() => $(`#${toastId}`).remove(), 3500);
}

