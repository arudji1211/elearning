import './bootstrap';


document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('myModal');
    if(openBtn && closeBtn && modal){
        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    }


});
