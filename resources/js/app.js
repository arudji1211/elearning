import "flowbite";

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
    //form search;
    const searchInput = document.getElementById("search_soal");
    const searchResults = document.getElementById("search-results");
    const searchItems = document.querySelectorAll(".search-item");
    const selectedContainer = document.getElementById("selected-products");

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase().trim();
        let hasResult = false;

        searchItems.forEach((item) => {
            const description = item.dataset.description.toLowerCase();
            if (description.includes(query) && query.length > 0) {
                item.style.display = "block";
                hasResult = true;
            } else {
                item.style.display = "none";
            }
        });

        searchResults.classList.toggle("hidden", !hasResult);
    });

    searchItems.forEach((item) => {
        item.addEventListener("click", () => {
            const id = item.dataset.id;
            const description = item.dataset.description;

            // Buat elemen form baru
            const wrapper = document.createElement("div");
            wrapper.className =
                "mb-2";

            wrapper.innerHTML = `
        <div class="flex gap-1">
                <div>
                    <button class="w-6 h-6 bg-indigo-600 font-semibold text-white rounded-sm shadow-sm text-xs" type="button"> x </button>
                </div>
                <div>
                ${description}
                </div>


        </div>
        <input type="hidden" name="soal[]" value="${id}">
      `;

            selectedContainer.appendChild(wrapper);

            // Reset input dan sembunyikan dropdown
            searchInput.value = "";
            searchResults.classList.add("hidden");
        });
    });

    document.addEventListener("click", (e) => {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.classList.add("hidden");
        }
    });

    //auto close alert
    setTimeout(() => {
        const alert = document.getElementById("alert");
        if (alert) {
            alert.classList.add("opacity-0"); // buat efek fade out
            setTimeout(() => alert.remove(), 500); // hapus dari DOM setelah fade
        }
    }, 3000); // auto close setelah 3 detik

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

    // chapter handler
    document.querySelectorAll("#contentList li").forEach(li => {
        li.addEventListener('click', ()=>{
            const id = li.dataset.id;
            const title = li.dataset.title;
            const description = li.dataset.description;
            const chapter = li.dataset.chapter;
            const deleteLink = li.dataset.deletelink;

            const descriptionEl = document.getElementById('contentsDescription');
            const addTaskBtnEl = document.getElementById('contentsAddTaskBtn');
            const actionEl = document.getElementById('contentsAction');

            const deleteButton = document.createElement('a');
            deleteButton.classList.add('p-2', 'font-semibold','bg-red-600', 'text-white', 'rounded-sm', 'shadow-sm', 'hover:bg-red-500', 'hover:shadow-md');
            deleteButton.setAttribute('href', deleteLink);
            deleteButton.innerText = 'Delete'


            actionEl.innerHTML = '';
            actionEl.appendChild(deleteButton);
            descriptionEl.innerHTML = '';
            descriptionEl.innerHTML = description;
            addTaskBtnEl.dataset.modalid = `modal-add-task-` + id;

        })
    });
});
