import $ from "jquery";
import { showToast } from "../utils/toast";

$(function () {
    // 📝 Profil Bilgilerini Güncelle
    $("#profileForm").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: "/profile/update",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    showToast("success", response.message);
                    
                    // Navbar'daki ismi güncelle
                    const newName = $("#name").val();
                    $(".navbar .dropdown-toggle span").text(newName);
                }
            },
            error: function (xhr) {
                const message = xhr.responseJSON?.message || "Bir hata oluştu.";
                showToast("error", message);
                
                // Validation hatalarını göster
                if (xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        showToast("error", errors[key][0]);
                    });
                }
            }
        });
    });

    // 🔒 Şifre Değiştir
    $("#passwordForm").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        // Şifre eşleşme kontrolü
        const newPassword = $("#new_password").val();
        const confirmPassword = $("#new_password_confirmation").val();

        if (newPassword !== confirmPassword) {
            showToast("error", "Yeni şifre ve tekrarı eşleşmiyor!");
            return;
        }

        $.ajax({
            url: "/profile/update-password",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    showToast("success", response.message);
                    
                    // Formu temizle
                    $("#passwordForm")[0].reset();
                }
            },
            error: function (xhr) {
                const message = xhr.responseJSON?.message || "Şifre değiştirme başarısız!";
                showToast("error", message);
                
                // Validation hatalarını göster
                if (xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        showToast("error", errors[key][0]);
                    });
                }
            }
        });
    });
});
