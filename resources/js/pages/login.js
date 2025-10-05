import $ from "jquery";

$(function () {
    // 🔐 Password Toggle (Göster/Gizle)
    $("#togglePassword").on("click", function () {
        const passwordInput = $("#password");
        const icon = $(this).find("i");
        
        if (passwordInput.attr("type") === "password") {
            passwordInput.attr("type", "text");
            icon.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
            $(this).attr("title", "Şifreyi Gizle");
        } else {
            passwordInput.attr("type", "password");
            icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
            $(this).attr("title", "Şifreyi Göster");
        }
    });

    // 📧 Test hesaplarına tıklayınca email'i otomatik doldur (Smooth Animation)
    $(".account-badge").on("click", function () {
        const email = $(this).text().split(":")[1].trim();
        const $emailInput = $("#email");
        
        // Smooth fill animasyonu
        $emailInput.val("").focus();
        let i = 0;
        const typingInterval = setInterval(() => {
            if (i < email.length) {
                $emailInput.val(email.substring(0, i + 1));
                i++;
            } else {
                clearInterval(typingInterval);
                // Email dolduktan sonra şifre alanına geç
                setTimeout(() => {
                    $("#password").focus();
                }, 200);
            }
        }, 30);
        
        // Görsel feedback
        $(this).addClass("clicked");
        setTimeout(() => {
            $(this).removeClass("clicked");
        }, 300);
    });

    // 🚀 Form Submit - Loading Animation
    $("form").on("submit", function (e) {
        const $loginBtn = $("#loginButton");
        const $btnText = $loginBtn.find(".btn-text");
        const $btnLoader = $loginBtn.find(".btn-loader");
        
        // Loading göster
        $btnText.addClass("d-none");
        $btnLoader.removeClass("d-none");
        $loginBtn.prop("disabled", true);
        
        // Gerçek form submit için PHP backend kontrolü yapılacak
        // Bu animasyon sadece görsel feedback için
    });

    // ❌ Error Shake Animation (Eğer hata varsa)
    if ($(".alert-danger").length > 0) {
        $(".login-card").addClass("shake-error");
        setTimeout(() => {
            $(".login-card").removeClass("shake-error");
        }, 600);
    }

    // ⌨️ Enter tuşu ile form gönderimi
    $("#email, #password").on("keypress", function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $("form").submit();
        }
    });

    // 🎨 Input Focus Animations
    $("#email, #password").on("focus", function () {
        $(this).parent().addClass("focused");
    }).on("blur", function () {
        if (!$(this).val()) {
            $(this).parent().removeClass("focused");
        }
    });

    // 💡 Password alanına yazarken Caps Lock uyarısı
    $("#password").on("keyup", function (e) {
        const capsLockOn = e.originalEvent.getModifierState("CapsLock");
        
        if (capsLockOn && !$("#capsLockWarning").length) {
            $(this).after('<small id="capsLockWarning" class="text-warning d-block mt-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>Caps Lock açık!</small>');
        } else if (!capsLockOn) {
            $("#capsLockWarning").remove();
        }
    });
});
