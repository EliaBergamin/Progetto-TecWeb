var hamStatus = true;

var currentDataPrenotazione = '';
var currentIdMostra = '';

function hambToggle() {
    var e = document.getElementsByClassName("hamToggle");
    hamStatus = !hamStatus;
    for (var t = 0; t < e.length; t++) {
        e[t].setAttribute("data-hambOn", hamStatus.toString());
    }
}

let current = 0;

function prossimaSlide(n) {
    mostraSlide(current += n);
}

function currentSlide(n) {
    mostraSlide(current = n);
}

function mostraSlide(n) {
    let i;
    let slides = document.querySelectorAll(".immaginiCarosello img");
    let dots = document.querySelectorAll(".puntiniCarosello button");

    if (n > slides.length) { current = 1 }
    if (n < 1) { current = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].className = slides[i].className.replace("onCarosello", "");
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace("active", "");
    }
    slides[current - 1].className += "onCarosello";
    dots[current - 1].className += "active";
}

function initAccordion() {
    document.querySelectorAll(".accordion").forEach((accordion) => {
        accordion.addEventListener("click", function () {
            // per mettere il "-" quando si apre
            this.classList.toggle("active");
            // per aprire e chiudere il panel
            let panel = this.parentElement.nextElementSibling;
            panel.classList.toggle("active");
        });
    });
}

function initRecensisci() {
    document.querySelectorAll("#rating-fs label").forEach((label) => {
        label.classList.add("nascosto");
    });
    document.getElementsByName("rating").forEach(addEventListeners);
}

function reset_span() {
    inputs = document.getElementsByName("rating");
    let index = 4, found = 0;
    for (; index >= 0 && !found; index--) {
        const element = inputs[index];
        if (element.checked) {
            found = index + 1;
        }
    }
    for (let i = 1; i <= found; i++) {
        let currentId = "voto-" + i.toString();
        document.getElementById(currentId).classList.replace("ahead", "behind");
    }
    for (let i = found + 1; i <= 5; i++) {
        let currentId = "voto-" + i.toString();
        document.getElementById(currentId).classList.replace("behind", "ahead");
    }
    let giudizi = [
        "", "Terribile", "Non soddisfacente", "Nella media", "Molto soddisfacente", "Eccellente"
    ];
    document.getElementById("giudizio").innerText = giudizi[found];
}

function change_span(id) {
    let voto2giudizio = {
        '1': "Terribile",
        '2': "Non soddisfacente",
        '3': "Nella media",
        '4': "Molto soddisfacente",
        '5': "Eccellente"
    };
    let voto = parseInt(id.charAt(5));
    document.getElementById("giudizio").innerText = voto2giudizio[voto];
    for (let i = 1; i <= voto; i++) {
        let currentId = "voto-" + i.toString();
        document.getElementById(currentId).classList.replace("ahead", "behind");
    }
    for (let i = voto + 1; i <= 5; i++) {
        let currentId = "voto-" + i.toString();
        document.getElementById(currentId).classList.replace("behind", "ahead");
    }
}

function addEventListeners(item) {
    item.addEventListener("click", function () { change_span(item.id); });
    item.addEventListener("mouseover", function () { change_span(item.id); });
    item.addEventListener("mouseleave", reset_span);
}

function selectSala(id) {
    let descrizioniSale = document.querySelectorAll("#virtualTour-elenco-sale p");

    for (let i = 0; i < descrizioniSale.length; i++) {
        if (i === id) {
            descrizioniSale[i].classList.add("selected");
        } else {
            descrizioniSale[i].classList.remove("selected");
        }
    }
}

function initMap() {
    console.log('initMap');
    let links = document.querySelectorAll("#virtualTour-mappa a");
    for (let i = 0; i < links.length; i++) {
        links[i].addEventListener("click", function () {
            selectSala(i);
        });
    }
}

function initDialog() {

    const dialog = document.querySelector("dialog");
    const confirm = document.querySelector("#conf-dialog");
    const cancel = document.querySelector("#annul-dialog");

    document.querySelectorAll(".cancella").forEach((btn) => {
        btn.addEventListener("click", () => {
            dialog.showModal();
            if (dialog.id === "dialog-pren") {
                currentDataPrenotazione = btn.getAttribute("id").substring(5);
                console.log(currentDataPrenotazione);
            }
            else {
                currentIdMostra = btn.getAttribute("id").substring(5);
                console.log(currentIdMostra);
            }
        });
    });

    cancel.addEventListener("click", () => {
        dialog.close();
    });

    if (dialog.id === "dialog-pren") {
        console.log("dialog-pren");
        confirm.addEventListener("click", () => {
            console.log(currentDataPrenotazione);
            fetch('../delete_prenotazione_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `data_prenotazione=${encodeURIComponent(currentDataPrenotazione)}`,
            })
                .then(response => response.text())
                .then(result => {
                    console.log('Success:', result);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            dialog.close();
        });
    }
    else {
        console.log("dialog-mostra");
        confirm.addEventListener("click", () => {
            console.log(currentIdMostra);
            fetch('../delete_mostra_admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_mostra=${encodeURIComponent(currentIdMostra)}`,
            })
                .then(response => response.text())
                .then(result => {
                    console.log('Success:', result);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            dialog.close();
        });
    }
}