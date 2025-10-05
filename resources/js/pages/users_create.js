import $ from "jquery";
import { showToast } from "../utils/toast";

$(function () {
    const form = $("#createUserForm");

    form.on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "/users",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                name: $("#name").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                role: $("#role").val(),
            },
            success: (res) => {
                showToast("add", res.message || "Yeni kullanıcı eklendi.");
                setTimeout(() => (window.location.href = "/users"), 1000);
            },
            error: (xhr) => {
                showToast("error", xhr.responseJSON?.message || "Bir hata oluştu.");
            },
        });
    });
});
