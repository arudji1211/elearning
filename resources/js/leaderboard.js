export default function initLeaderboard(courseid) {
    const ulist = document.getElementById("leaderboard_container");
    window.Echo.private(`course.${courseid}.leaderboard`).listen(
        ".leaderboard.updated",
        (e) => {
            ulist.innerHTML = "";
            e.leaderboard.forEach(function (element, rank) {
                const liEl = document.createElement("li");
                liEl.classList.add(
                    "shadow-sm",
                    "rounded",
                    "p-2",
                    "mb-1",
                    "flex",
                    "justify-between",
                );

                if (Number(rank) === 0) {
                    liEl.classList.add("border-b-indigo-600");
                } else if (Number(rank) === 1) {
                    liEl.classList.add("border-b-indigo-400");
                } else if (rank === 2) {
                    liEl.classList.add("border-b-green-800");
                } else if (rank === 3) {
                    liEl.classList.add("border-b-indigo-300");
                } else if (rank === 4) {
                    liEl.classList.add("border-b-indigo-200");
                }

                liEl.classList.add("border", "border-1", "border-transparent");

                const userInformation = document.createElement("div");
                userInformation.classList.add(
                    "flex",
                    "gap-2",
                    "justify-center",
                );

                const imageContainer = document.createElement("div");
                const profile = document.createElement("img");
                //profile.setAttribute('src', element.user.image.path);
                profile.setAttribute(
                    "src",
                    "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
                );
                profile.classList.add(
                    "size-10",
                    "rounded-full",
                    "outline",
                    "-outline-offset-1",
                    "outline-white/10",
                    "mx-auto",
                    "text-baseline",
                );
                imageContainer.appendChild(profile);
                const nameContainer = document.createElement("div");
                nameContainer.classList.add(
                    "content-center",
                    "text-lg",
                    "h-full",
                    "pb-1"
                );

                nameContainer.innerText = element.user.first_name;

                userInformation.appendChild(imageContainer);
                userInformation.appendChild(nameContainer);

                const points = document.createElement("div");
                points.classList.add(
                    "text-end",
                    "font-semibold",
                    "px-2",
                    "content-center"
                );

                if (Number(rank) === 0) {
                    points.classList.add("text-indigo-600");
                } else if (Number(rank) === 1) {
                    points.classList.add("text-indigo-400");
                } else if (rank === 2) {
                    liEl.classList.add("border-b-green-800");
                } else if (rank === 3) {
                    liEl.classList.add("border-b-indigo-300");
                } else if (rank === 4) {
                    liEl.classList.add("border-b-indigo-200");
                }


                points.innerText = element.total;
                liEl.appendChild(userInformation);
                liEl.appendChild(points);

                ulist.appendChild(liEl);
            });
        },
    );
}
