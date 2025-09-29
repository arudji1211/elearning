import tinymce from 'tinymce/tinymce';

// Plugin yang mau dipakai
import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/models/dom';

// Plugin tambahan
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/table';
import 'tinymce/plugins/code';
import 'tinymce/plugins/image';

// CSS untuk editor
import 'tinymce/skins/ui/oxide/skin.css';


document.addEventListener('DOMContentLoaded', () => {
// Inisialisasi editor
    tinymce.init({
        selector: '#myeditor',
        plugins: 'lists link image table code',
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code',
        menubar: false,
        height: 300,
        license_key: 'gpl', // setuju pakai versi open-source gratis
        skin: false,        // biar tidak load dari /skins/ui/oxide
        content_css: false
    });


    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');

    if(openBtn && closeBtn){
        openBtn.addEventListener('click', function(){
            let modalname = this.dataset.modalid;
            console.log(modalname)
            const modal = document.getElementById(modalname);
            modal.classList.remove('hidden')
        });

        closeBtn.addEventListener('click', function(){
            let modalname = this.dataset.modalid;
            const modal = document.getElementById(modalname);
            modal.classList.add('hidden')});
    }


});
