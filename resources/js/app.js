import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".js-delete-form").forEach(function (form) {
        form.addEventListener("submit", function (event) {
            if (!confirm("本当に削除しますか？")) {
                event.preventDefault();
            }
        });
    });
});

