document.querySelectorAll(".accordion").forEach((accordion) => {
    accordion.addEventListener("click", function() {
        // giusto per mettere il "-" quando si apre
        this.classList.toggle("active");
        // prende l'elemento successivo al padre dell'elemento cliccato
        let panel = this.parentElement.nextElementSibling;
        panel.style.display === "block" ? panel.style.display = "none" : panel.style.display = "block";
    });
});