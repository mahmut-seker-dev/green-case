import $ from "jquery";
import { showToast } from "../utils/toast";

$(function () {
    const form = $("#editUserForm");
    const userId = form.data("id");

    form.on("submit", function (e) {
        e.preventDefault();

        const payload = {
            name: $("#name").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            _method: "PUT",
            _token: $('meta[name="csrf-token"]').attr("content"),
        };

        $.ajax({
            url: `/users/${userId}`,
            type: "POST",
            data: payload,
            success: (res) => {
                showToast("success", res.message || "✅ Kullanıcı bilgileri güncellendi.");
                setTimeout(() => (window.location.href = "/users"), 1000);
            },
            error: (xhr) => {
                const msg = xhr.responseJSON?.message || "Bir hata oluştu.";
                showToast("error", msg);
            },
        });
    });
});
