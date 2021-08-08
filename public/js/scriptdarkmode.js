window.addEventListener("load", function () {
    const btnToggle = document.getElementById("btnToggle");
    const img = document.getElementById("imgToggle");

    function darkmode() {
        const body = document.body;
        if (localStorage.getItem("darkmode") == "off" || localStorage.hasOwnProperty("darkmode") == false) {
            body.classList.add("light");
            body.classList.remove("dark");
            imgToggle.classList.add("jour");
            imgToggle.classList.remove("nuit");
        } else  { 
            body.classList.add("dark");
            body.classList.remove("light");
            imgToggle.classList.add("nuit");
            imgToggle.classList.remove("jour");
        }
    }

    darkmode();

    //  Listen the Event Click to Switch from Light to Dark and from Dark to Light
    btnToggle.addEventListener("click", () => {
        if (localStorage.getItem("darkmode") == "off") {
            localStorage.setItem("darkmode", "on");
            darkmode();
        } else {
            localStorage.setItem("darkmode", "off");
            darkmode();
        }
    });
});