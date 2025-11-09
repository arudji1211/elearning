import AlertComponent from "./alert.js";

export default class StudentEvent {


    async render() {
        console.log("render");
        const container = document.getElementById("event_container");
        const events = await this.getEvent();
        container.innerHTML = "";
        console.log(events.data);
        events.data.forEach((el) => {
            const eventcontainer = document.createElement("div");
            eventcontainer.classList.add(
                "flex",
                "flex-col",
                "border",
                "border-transparent",
                "hover:border-b-violet-500",
                "p-2",
                "shadow-sm",
                "hover:shadow-md",
            );

            const header = document.createElement("div");
            header.classList.add("font-semibold", "text-indigo-600");

            header.innerText = el.title;

            const body = document.createElement("div");
            body.classList.add("flex", "gap-2");

            const description = document.createElement("div");
            description.classList.add("text-slate-900", "flex-1");
            description.innerText = el.description;
            body.appendChild(description);

            const action = document.createElement("div");

            if (el.can_claim) {
                const claimbtn = document.createElement("button");
                claimbtn.classList.add(
                    "font-semibold",
                    "p-2",
                    "aspect-ratio",
                    "text-wrap",
                    "text-indigo-500",
                    "rounded-full",
                    "cursor-pointer",
                    "shadow-sm",
                    "hover:shadow-md",
                    "hover:text-indigo-600",
                    "hover:bg-indigo-600",
                    "hover:text-white",
                );
                claimbtn.addEventListener("click", () => {
                    this.claimEvent(el.id);
                    this.render();
                });

                const icon = document.createElement("i");
                icon.classList.add("fa-solid", "fa-gift", "text-lg");
                claimbtn.appendChild(icon);
                const claimtext = document.createElement("span");
                claimtext.innerText = " Claim";
                claimbtn.appendChild(claimtext);

                action.appendChild(claimbtn);

            }else if(el.progres_requirement != el.current_progres){
                const progressEl = document.createElement('div');
                progressEl.classList.add(
                    'text-indigo-600','p-2','font-semibold'
                );
                progressEl.innerText = el.current_progres + '/' + el.progres_requirement;
                action.appendChild(progressEl);
            }else if(el.progres_requirement == el.current_progres && el.claim.status){
                const progressEl = document.createElement('div');
                progressEl.classList.add(
                    'bg-violet-500','p-2','font-semibold', 'text-white', 'rounded-full'
                );
                progressEl.innerText = 'Claimed';
                action.appendChild(progressEl);

            }
            body.appendChild(action);
            eventcontainer.appendChild(header);
            eventcontainer.appendChild(body);
            container.appendChild(eventcontainer);
        });
    }

    async getEvent() {
        try {
            const response = await axios.get("/api/event");
            return response.data;
        } catch (error) {
            throw error;
        }
    }

    async claimEvent(id) {
        try {
            const payload = {
                action: "claim",
            };

            const response = await axios.post(`/api/event/${id}`, payload, {
                withCredentials: true,
            });
            if (response.status == 200) {

                if (response.data.success) {
                    new AlertComponent(response.data.message, {
                        type: "success",
                    }).render();
                } else {
                    new AlertComponent(response.data.message, {
                        type: "error",
                    }).render();
                }
            }
        } catch (error) {
            new AlertComponent(error.message, { type: "error" }).render();
        }
    }
}
