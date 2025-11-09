export default class AlertComponent {
    constructor(message, options = {}) {
        this.message = message;
        this.type = options.type;
    }

    render() {
        const container = document.createElement("div");
        container.className = `fixed right-0 bottom-0 z-50 p-3`;
        const wrap = document.createElement("div");
        wrap.className = `sticky rounded-sm shadow-sm`
        const subcontainer = document.createElement("div");
        subcontainer.className = `p-4`;

        if(this.type === 'error'){
            wrap.classList.add('bg-rose-500');
        }else if(this.type === 'success'){
            wrap.classList.add('bg-emerald-500');
        }
        const headerContent = document.createElement("div");
        headerContent.className = `text-center text-white font-semibold text-xl`;
        headerContent.innerText = this.type
        const bodyContent = document.createElement("div");
        bodyContent.className = `text-white px-2`;
        bodyContent.innerText = this.message;

        subcontainer.appendChild(headerContent);
        subcontainer.appendChild(bodyContent);
        wrap.appendChild(subcontainer);
        container.appendChild(wrap);


        //auto close alert
        setTimeout(() => {

            if (container) {
                container.classList.add("opacity-0"); // buat efek fade out
                setTimeout(() => container.remove(), 500); // hapus dari DOM setelah fade
            }
        }, 3000); // auto close setelah 3 detik
        document.body.appendChild(container);
    }
}
