import tinymce from "tinymce/tinymce";

// Plugin yang mau dipakai
import "tinymce/icons/default";
import "tinymce/themes/silver";
import "tinymce/models/dom";

// Plugin tambahan
import "tinymce/plugins/link";
import "tinymce/plugins/lists";
import "tinymce/plugins/table";
import "tinymce/plugins/code";
import "tinymce/plugins/image";

// CSS untuk editor
import "tinymce/skins/ui/oxide/skin.css";

document.addEventListener("DOMContentLoaded", () => {
    // Inisialisasi editor
    tinymce.init({
        selector: "#myeditor",
        plugins: "lists link image table code",
        toolbar:
            "undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code",
        menubar: false,
        height: 300,
        license_key: "gpl", // setuju pakai versi open-source gratis
        skin: false, // biar tidak load dari /skins/ui/oxide
    });

    // ambil semua button open
    const openBtns = document.querySelectorAll(".openModalBtn");
    const closeBtns = document.querySelectorAll(".closeModalBtn");

    // loop untuk setiap tombol open
    openBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            const modalId = this.dataset.modalid;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove("hidden");
            }
        });
    });

    // loop untuk setiap tombol close
    closeBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            const modalId = this.dataset.modalid;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add("hidden");
            }
        });
    });
});
