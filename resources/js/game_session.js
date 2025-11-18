import AlertComponent from "./components/alert.js";

export default class GameSession {
    constructor(endpoints, user) {
        this.options = {
            current: 1,
            round: 5,
        };

        this.timer;

        this.user = user;

        this.endpoints = {
            match_data: endpoints.match_data,
            submit_answer: endpoints.submit_answer,
            new_question: endpoints.new_question,
        };

        this.action = {};

        this.active_session = {};

        this.match = [
            {
                person: {},
                bot: {},
            },
        ];
        this.state = "";
        this.fetchSoal();
        this.fetchMatchData();
        console.log(this.action)
    }

    simpanData(el) {
        let match = [];
        this.active_session = el.data.active_session;
        this.state = el.data.status;
        this.action.claim = el.data.action.claim;
        this.action.retry = el.data.action.retry;
        this.action.home = el.data.action.home;
        el.data.history.forEach((element) => {
            const person = {
                id: element.person.id,
                status: element.person.status,
                question_id: element.person.question_id,
                answer_id: element.person.answer_id,
                is_benar: element.person.is_benar,
            };

            const bot = {
                status: element.bot.status,
                question_id: element.bot.question_id,
                answer_id: element.bot.answer_id,
                is_benar: element.bot.is_benar,
            };
            const temp = {
                person: person,
                bot: bot,
            };

            match.push(temp);
        });
        this.match = match;

        if (this.state != "none") {
            if (this.state !== "win") {
                const modal = document.createElement("div");
                modal.className =
                    "fixed inset-0 top-0 flex items-center justify-center bg-white/80 z-10 p-5";
                const container = document.createElement("div");

                container.className =
                    "rounded shadow-lg p-5 w-full md:w-2xl flex flex-col gap-5 overflow-y-auto max-h-[90vh] bg-white border border-gray-100";
                const header = document.createElement("div");
                header.className =
                    "text-rose-500 font-semibold text-xl text-center mt-3";
                header.innerText = "KAMU KALAH !";
                const body = document.createElement("div");
                body.className = "flex flex-col gap-5";
                const description = document.createElement("div");
                description.className = "px-2";
                description.innerText =
                    "Yah ! kamu gagal menaklukkan administrator, silahkan mengulas kembali materi lalu menantangnya kembali, kamu pasti bisa !";
                body.appendChild(description);
                const action = document.createElement("div");
                action.className = "flex gap-2 justify-center";
                const close = document.createElement("a");
                close.className =
                    "rounded-sm shadow-sm hover:shadow-md hover:bg-rose-600 bg-rose-500 p-2 text-white cursor-pointer";
                close.innerText = "Kembali ke Dashboard";
                container.appendChild(header);
                action.appendChild(close);
                body.appendChild(action);
                container.appendChild(body);
                modal.appendChild(container);
                document.body.appendChild(modal);
            } else {
                const modal = document.createElement("div");
                modal.className =
                    "fixed inset-0 top-0 flex items-center justify-center bg-white/80 z-10 p-5";
                const container = document.createElement("div");

                container.className =
                    "rounded shadow-lg p-5 w-full md:w-2xl flex flex-col gap-5 overflow-y-auto max-h-[90vh] bg-white border border-gray-100";
                const header = document.createElement("div");
                header.className =
                    "text-emerald-500 font-semibold text-xl text-center mt-3";
                header.innerText = "KAMU MENANG !!!";
                const body = document.createElement("div");
                body.className = "flex flex-col gap-5";
                const description = document.createElement("div");
                description.className = "px-2";
                description.innerText =
                    "Selamat Kamu Berhasil Mengalahkan ADMINISTRATOR !!!";
                body.appendChild(description);
                const action = document.createElement("div");
                action.className = "flex gap-2 justify-center";

                const claim = document.createElement("a");
                claim.setAttribute('href', this.action.claim)
                claim.className =
                    "text-center flex rounded-sm shadow-sm hover:shadow-md hover:bg-emerald-600 bg-emerald-500 p-2 text-white cursor-pointer w-full justify-center text-sm";
                const icc = document.createElement('i')
                icc.className = "fa-solid fa-gift text-lg"
                claim.appendChild(icc)
                const textin = document.createElement('div');
                textin.className = "font-semibold"
                textin.innerText = " Claim"
                claim.appendChild(textin)

                const close = document.createElement("a");

                close.className =
                    "text-center flex rounded-sm shadow-sm hover:shadow-md hover:bg-rose-600 bg-rose-500 p-2 text-white hover:text-white cursor-pointer w-full justify-center text-sm";
                const textinclose = document.createElement('div');
                textinclose.innerText = " Kembali"
                textinclose.className = "font-semibold"
                const icclose = document.createElement('i');
                icclose.className = "fa-solid fa-home text-lg";
                close.appendChild(icclose);
                close.appendChild(textinclose);

                container.appendChild(header);
                action.appendChild(close);
                action.appendChild(claim);
                body.appendChild(action);
                container.appendChild(body);
                modal.appendChild(container);
                document.body.appendChild(modal);
            }
        }
    }

    fetchMatchData() {
        axios.get(this.endpoints.match_data).then((response) => {
            this.simpanData(response.data);
            this.renderPoints();
            this.fetchSoal();
            console.log(response);
        });
    }

    fetchSoal() {
        axios.post(this.endpoints.new_question).then((response) => {
            if (response.data.success) {
                this.match.active_session = response.data.data;
                this.renderSoal();
            } else {
                new AlertComponent(response.data.message, {
                    type: "error",
                }).render();
            }
        });
    }

    fetchSubmitJawaban(answer_id, activity_id) {
        axios
            .post(this.endpoints.submit_answer, {
                answer_id: answer_id,
                id: activity_id,
            })
            .then((response) => {
                console.log(response.data);
                if (response.data.success) {
                    this.fetchSoal();
                }
                this.fetchMatchData();
            });
    }

    renderSoal() {
        const textsoal = document.getElementById("soal");
        textsoal.innerText = this.active_session[0].question.description;
        const answer = document.getElementById("jawaban");
        answer.innerHTML = "";
        const letter = ["A. ", "B. ", "C. ", "D. "];
        this.active_session[0].question.answers.forEach((element, index) => {
            const opsi = document.createElement("div");
            opsi.classList.add(
                "cursor-pointer",
                "font-semibold",
                "border",
                "border-gray-200",
                "shadow-sm",
                "text-lg",
                "text-violet-500",
                "bg-white",
                "hover:shadow-md",
                "hover:bg-violet-500",
                "hover:text-white",
                "p-2",
                "rounded-md",
            );
            opsi.innerText = letter[index] + element.description;
            opsi.addEventListener("click", () => {
                this.fetchSubmitJawaban(element.id, this.active_session[0].id);
            });
            answer.appendChild(opsi);
        });

        //render timer
        const now = new Date();

        const diffMs = now - new Date(this.active_session[0].created_at); // hasil dalam milidetik
        const diffSeconds = Math.floor(diffMs / 1000);
        const timerEl = document.getElementById("timercountdown");

        let waktuSecond = diffSeconds;
        let waktuMenit = 0;
        if (this.timer) {
            clearInterval(this.timer);
        }
        this.timer = setInterval(() => {
            waktuSecond++;
            if (waktuSecond > 59) {
                waktuMenit += Math.floor(waktuSecond / 60);
                waktuSecond = waktuSecond % 60;
            }

            timerEl.innerText =
                waktuMenit.toString().padStart(2, "0") +
                ":" +
                waktuSecond.toString().padStart(2, "0");
        }, 1000);
    }

    renderRecentResult(result) {}

    renderPoints() {
        const userPoints = document.getElementById("points");
        const botPoints = document.getElementById("points_bot");
        botPoints.innerHTML = "";
        userPoints.innerHTML = "";
        const jumlah_match = this.match.length;
        for (let i = 0; i < jumlah_match; i++) {
            const points = document.createElement("div");
            points.classList.add(
                "border",
                "border-gray-200",
                "aspect-square",
                "w-8",
                "rounded-full",
            );

            const pointsbot = document.createElement("div");
            pointsbot.classList.add(
                "border",
                "border-gray-200",
                "aspect-square",
                "w-8",
                "rounded-full",
            );
            if (this.match[i].person.status == "win") {
                points.classList.add("bg-emerald-500");
                pointsbot.classList.add("bg-rose-500");
            } else if (this.match[i].person.status == "lose") {
                points.classList.add("bg-rose-500");
                pointsbot.classList.add("bg-emerald-500");
            }
            botPoints.appendChild(pointsbot);
            userPoints.appendChild(points);
        }

        if (jumlah_match < 5) {
            for (let i = 0; i < 5 - jumlah_match; i++) {
                const points = document.createElement("div");
                points.classList.add(
                    "animate-pulse",
                    "border",
                    "border-gray-200",
                    "aspect-square",
                    "w-8",
                    "rounded-full",
                    "bg-white",
                );
                const pointsbot = document.createElement("div");
                pointsbot.classList.add(
                    "animate-pulse",
                    "border",
                    "border-gray-200",
                    "aspect-square",
                    "w-8",
                    "rounded-full",
                    "bg-white",
                );

                userPoints.appendChild(points);
                botPoints.appendChild(pointsbot);
            }
        }
    }

    render() {
        const userContainer = document.getElementById("userName");
        userContainer.innerText =
            this.user.first_name + " " + this.user.last_name;
    }
}
