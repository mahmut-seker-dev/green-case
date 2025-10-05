import $ from "jquery";
import { showToast } from "../../utils/toast";

$(function () {
    $("#customerForm").on("submit", function (e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr("action");
        const formData = form.serialize();

        $.ajax({
            url,
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    showToast("add", response.message);
                    setTimeout(() => {
                        window.location.href = "/customers";
                    }, 1200);
                }
            },
            error: function (xhr) {
                const msg =
                    xhr.responseJSON?.message || "Beklenmeyen hata oluştu.";
                showToast("error", msg);
            },
        });
    });
});
