import "flowbite";

import axios from 'axios';
window.axios = axios;

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

import Echo from "laravel-echo";
import Pusher from "pusher-js";
import AlertComponent from "./components/alert.js";
import initLeaderboard from "./leaderboard.js";
import CardComponent from "./components/card.js";
import StudentCard from "./components/student/card.js";

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: false,
    enabledTransports: ["ws"],
    authEndpoint: "/broadcasting/auth",
});

document.addEventListener("DOMContentLoaded", () => {
    ///web socket

    //element pakai banyak banyak
    //

    //form search;
    const pageid = document.getElementById("pageid");


    if (pageid.dataset.id == "dashboard_student"){
        initLeaderboard();
    }else if (pageid.dataset.id == "course_student") {
        initLeaderboard();
        // chapter
        const chpb = document.querySelectorAll("#contentList li");
        for (let i = 0; i < chpb.length; i++) {
            chpb[i].classList.add("bg-indigo-600");
            chpb[i].addEventListener("click", () => {
                chpb.forEach((element) => {
                    element.classList.remove("bg-indigo-700");
                    element.classList.remove("bg-indigo-600");

                    element.classList.add("bg-indigo-600");
                });

                chpb[i].classList.remove("bg-indigo-600");
                chpb[i].classList.add("bg-indigo-700");
                const id = chpb[i].dataset.id;
                const title = chpb[i].dataset.title;
                const description = chpb[i].dataset.description;
                const chapter = chpb[i].dataset.chapter;
                const berkas_pendukung = JSON.parse(
                    chpb[i].dataset.berkaspendukung,
                );

                const actionEl = document.getElementById("contentsAction");
                actionEl.innerHTML = "";
                const descriptionEl = document.getElementById(
                    "contentsDescription",
                );

                descriptionEl.innerHTML = "";
                descriptionEl.innerHTML = description;

                const berkas_pendukungContainer = document.getElementById(
                    "contentsBacaanWajib",
                );
                berkas_pendukungContainer.innerHTML = "";
                const berkas_pendukungTitle = document.createElement("div");
                berkas_pendukungTitle.classList.add(
                    "text-center",
                    "font-semibold",
                    "text-indigo-600",
                    "text-2xl",
                );
                berkas_pendukungTitle.innerText = "Bahan Bacaan";

                const berkas_card_container = document.createElement("div");
                berkas_card_container.classList.add(
                    "flex",
                    "flex-wrap",
                    "sm:justify-normal",
                );

                berkas_pendukungContainer.appendChild(berkas_pendukungTitle);

                if (berkas_pendukung !== null) {
                    berkas_pendukung.forEach((element) => {
                        const berkasCard = new StudentCard(
                            element.filename,
                            element.file_endpoint,
                        ).render();
                        berkas_card_container.appendChild(berkasCard);
                    });
                }
                berkas_pendukungContainer.appendChild(berkas_card_container);

                const nextBtn = document.createElement("button");
                nextBtn.innerText = "next";
                nextBtn.classList.add(
                    "bg-indigo-600",
                    "font-semibold",
                    "text-white",
                    "py-2",
                    "px-4",
                    "rounded-sm",
                    "shadow-sm",
                    "hover:shadow-md",
                    "hover:bg-indigo-500",

                    "text-center",
                    "cursor-pointer",
                    "text-lg",
                );

                nextBtn.addEventListener("click", () => {
                    chpb[i + 1].click();
                });

                const prevBtn = document.createElement("button");
                prevBtn.innerText = "prev";
                prevBtn.classList.add(
                    "bg-indigo-600",
                    "font-semibold",
                    "text-white",
                    "py-2",
                    "px-4",
                    "rounded-sm",
                    "shadow-sm",
                    "hover:shadow-md",
                    "hover:bg-indigo-500",
                    "text-center",
                    "cursor-pointer",
                    "text-lg",
                );

                prevBtn.addEventListener("click", () => {
                    chpb[i - 1].click();
                });

                actionEl.appendChild(prevBtn);
                actionEl.appendChild(nextBtn);
            });
        }
    } else if (pageid.dataset.id === "course_admin") {
        //leaderboard ( websocket )
        initLeaderboard();

        const adjust_user_point = document.querySelectorAll(
            ".user_point_adjustment_form",
        );

        adjust_user_point.forEach((element) => {
            const actions = element.querySelectorAll(".action_btn");
            const amount = element.querySelector("#adjust_user_point");
            const csrf = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            actions.forEach((act) => {
                act.addEventListener("click", async () => {
                    const payload = {
                        user_id: element.dataset.id,
                        tipe: act.dataset.tipe,
                        amount: amount.value,
                    };

                    const body = JSON.stringify(payload);

                    try {
                        const response = await fetch(element.dataset.endpoint, {
                            method: "POST",
                            credentials: "include",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]',
                                ).content,
                            },
                            body: JSON.stringify(payload),
                        });

                        const result = await response.json();
                        if (result.success) {
                            new AlertComponent(result.message, {
                                type: "success",
                            }).render();
                        } else {
                            new AlertComponent(result.message, {
                                type: "error",
                            }).render();
                        }
                        console.log(result);
                    } catch (error) {
                        new AlertComponent(error, { type: "error" }).render();
                    }
                    //end of trycatch
                });
            });
        });

        const searchInput = document.getElementById("search_soal");
        const searchResults = document.getElementById("search-results");
        const searchItems = document.querySelectorAll(".search-item");
        const selectedContainer = document.getElementById("selected-products");

        if (searchInput != null) {
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
                    wrapper.className = "mb-2";

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
        }

        document.addEventListener("click", (e) => {
            if (!searchResults.contains(e.target) && e.target !== searchInput) {
                searchResults.classList.add("hidden");
            }
        });

        document.querySelectorAll("#contentList li").forEach((li) => {
            li.addEventListener("click", () => {
                const id = li.dataset.id;
                const title = li.dataset.title;
                const description = li.dataset.description;
                const chapter = li.dataset.chapter;
                const deleteLink = li.dataset.deletelink;
                const task = JSON.parse(li.dataset.task);
                const berkas_pendukung = JSON.parse(li.dataset.berkaspendukung);

                const descriptionEl = document.getElementById(
                    "contentsDescription",
                );
                const actionEl = document.getElementById("contentsAction");
                const taskcontainerEl = document.getElementById(
                    "contentsTaskContainer",
                );
                taskcontainerEl.innerHTML = "";
                const deleteButton = document.createElement("a");
                deleteButton.classList.add(
                    "font-semibold",
                    "bg-red-600",
                    "text-white",
                    "rounded-sm",
                    "shadow-sm",
                    "hover:bg-red-500",
                    "hover:shadow-md",
                    "cursor-pointer",
                    "p-2",
                );
                deleteButton.setAttribute("href", deleteLink);
                deleteButton.innerText = "Delete";

                /// task list container builder
                const taskHeader = document.createElement("div");
                taskHeader.classList.add(
                    "text-center",
                    "font-semibold",
                    "text-indigo-600",
                    "text-2xl",
                );
                taskHeader.innerText = "Tugas";
                // render
                taskcontainerEl.appendChild(taskHeader);

                const taskBody = document.createElement("div");
                taskBody.classList.add("flex", "flex-col", "gap-2");

                const addTaskBtnEl = document.createElement("button");
                addTaskBtnEl.setAttribute("type", "button");
                addTaskBtnEl.innerText = "+";
                addTaskBtnEl.classList.add(
                    "openModalBtn",
                    "w-8",
                    "font-semibold",
                    "bg-indigo-600",
                    "hover:bg-indigo-500",
                    "text-white",
                    "shadow-sm",
                    "hover:shadow-md",
                    "rounded-sm",
                    "cursor-pointer",
                    "aspect-square",
                    "ms-auto",
                );
                addTaskBtnEl.dataset.modalid = `modal-add-task-` + id;

                addTaskBtnEl.addEventListener("click", function () {
                    const modalId = this.dataset.modalid;
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove("hidden");
                    }
                });

                // render
                taskBody.appendChild(addTaskBtnEl);

                const tasklistEl = document.createElement("ul");
                task.forEach((element) => {
                    const litask = document.createElement("li");
                    const lia = document.createElement("a");
                    lia.innerText = element.title;
                    litask.appendChild(lia);
                    tasklistEl.appendChild(litask);
                });
                // render
                taskBody.appendChild(tasklistEl);
                taskcontainerEl.appendChild(taskBody);

                actionEl.innerHTML = "";
                actionEl.appendChild(deleteButton);
                descriptionEl.innerHTML = "";
                descriptionEl.innerHTML = description;

                /// berkas pendukung
                const berkas_pendukungContainer = document.getElementById(
                    "contentsBacaanWajib",
                );

                const addBerkasBtnEl = document.createElement("button");
                addBerkasBtnEl.setAttribute("type", "button");
                addBerkasBtnEl.innerText = "+";
                addBerkasBtnEl.classList.add(
                    "openModalBtn",
                    "w-8",
                    "font-semibold",
                    "bg-indigo-600",
                    "hover:bg-indigo-500",
                    "text-white",
                    "shadow-sm",
                    "hover:shadow-md",
                    "rounded-sm",
                    "cursor-pointer",
                    "aspect-square",
                    "ms-auto",
                );

                addBerkasBtnEl.dataset.modalid = `modal-add-berkas-pendukung-${id}`;

                addBerkasBtnEl.addEventListener("click", function () {
                    const modalId = this.dataset.modalid;
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove("hidden");
                    }
                });

                berkas_pendukungContainer.innerHTML = "";
                const berkas_pendukungTitle = document.createElement("div");
                berkas_pendukungTitle.classList.add(
                    "text-center",
                    "font-semibold",
                    "text-indigo-600",
                    "text-2xl",
                );
                berkas_pendukungTitle.innerText = "Bacaan Wajib";

                const berkas_card_container = document.createElement("div");
                berkas_card_container.classList.add(
                    "flex",
                    "flex-wrap",
                    "sm:justify-normal",
                );

                berkas_pendukungContainer.appendChild(berkas_pendukungTitle);
                berkas_pendukungContainer.appendChild(addBerkasBtnEl);

                berkas_pendukung.forEach((element) => {
                    const berkasCard = new CardComponent(
                        element.filename,
                        element.file_endpoint,
                        element.delete_endpoint,
                    ).render();
                    berkas_card_container.appendChild(berkasCard);
                });
                berkas_pendukungContainer.appendChild(berkas_card_container);
            });
        });
    }

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
});
