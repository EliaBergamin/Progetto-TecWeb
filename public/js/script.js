var hamStatus = true;

var currentSlideDataPrenotazione = '';
var currentSlideIdMostra = '';

function hambToggle() {
    var e = document.getElementsByClassName("hamToggle");
    hamStatus = !hamStatus;
    for (var t = 0; t < e.length; t++) {
        e[t].setAttribute("data-hambOn", hamStatus.toString());
    }
}

let currentSlide = 1;

function prossimaSlide(n) {
    mostraSlide(currentSlide += n);
}

function aggiornaSlide(n) {
    mostraSlide(currentSlide = n);
}

function mostraSlide(n) {
    let i;
    let slides = document.querySelectorAll(".immaginiCarosello img");
    let dots = document.querySelectorAll(".puntiniCarosello button");
    console.log(slides);
    if (n > slides.length) { currentSlide = 1 }
    if (n < 1) { currentSlide = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].className = slides[i].classList.remove("onCarosello");
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].classList.remove("active");
    }
    slides[currentSlide - 1].classList.add("onCarosello");
    dots[currentSlide - 1].classList.add("active");
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
        let currentSlideId = "voto-" + i.toString();
        document.getElementById(currentSlideId).classList.replace("ahead", "behind");
    }
    for (let i = found + 1; i <= 5; i++) {
        let currentSlideId = "voto-" + i.toString();
        document.getElementById(currentSlideId).classList.replace("behind", "ahead");
    }
    let giudizi = [
        "", "Deludente", "Mediocre", "Interessante", "Soddisfacente", "Eccellente"
    ];
    document.getElementById("giudizio").innerText = giudizi[found];
}

function change_span(id) {
    let voto2giudizio = {
        '1': "Deludente",
        '2': "Mediocre",
        '3': "Interessante",
        '4': "Soddisfacente",
        '5': "Eccellente"
    };
    let voto = parseInt(id.charAt(5));
    document.getElementById("giudizio").innerText = voto2giudizio[voto];
    for (let i = 1; i <= voto; i++) {
        let currentSlideId = "voto-" + i.toString();
        document.getElementById(currentSlideId).classList.replace("ahead", "behind");
    }
    for (let i = voto + 1; i <= 5; i++) {
        let currentSlideId = "voto-" + i.toString();
        document.getElementById(currentSlideId).classList.replace("behind", "ahead");
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
                currentSlideDataPrenotazione = btn.getAttribute("id").substring(5);
                console.log(currentSlideDataPrenotazione);
            }
            else {
                currentSlideIdMostra = btn.getAttribute("id").substring(5);
                console.log(currentSlideIdMostra);
            }
        });
    });

    cancel.addEventListener("click", () => {
        dialog.close();
    });

    if (dialog.id === "dialog-pren") {
        console.log("dialog-pren");
        confirm.addEventListener("click", () => {
            console.log(currentSlideDataPrenotazione);
            fetch('../delete_prenotazione_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `data_prenotazione=${encodeURIComponent(currentSlideDataPrenotazione)}`,
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
            console.log(currentSlideIdMostra);
            fetch('../delete_mostra_admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_mostra=${encodeURIComponent(currentSlideIdMostra)}`,
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

function initAJAX() {
    document.getElementById('giorno').addEventListener('change', function () {
        document.getElementById('orario').value = "";
        document.getElementById('visitatori').value = "";

        const giornoSelezionato = this.value;

        if (!giornoSelezionato) return;
        fetch('../phplibs/controlla_disponibilita.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `giorno=${encodeURIComponent(giornoSelezionato)}`,
        })
            .then(response => response.json())
            .then(data => {
                aggiornaOrariDisponibili(data);
            })
            .catch(error => {
                console.error('Errore durante il recupero degli slot:', error);
            });
    });

    document.getElementById('orario').addEventListener('change', function () {
        document.getElementById('visitatori').value = "";

        const selectOrario = document.getElementById("orario");
        const selectedOption = selectOrario.options[selectOrario.selectedIndex];
        const postiDisponibili = selectedOption.dataset.postiDisponibili || 15;
        const maxVisitatori = postiDisponibili >= 15 ? 15 : postiDisponibili;
        document.getElementById('visitatori').max = maxVisitatori;

        caricamentoValidazioneNumeroVisitatori(maxVisitatori);
    });
}

function aggiornaOrariDisponibili(slotDisponibili) {
    const slotsId = ["09", "10_30", "12", "13_30", "15", "16_30"];
    const slotsOrari = ["09:00:00", "10:30:00", "12:00:00", "13:30:00", "15:00:00", "16:30:00"]
    for (i = 0; i < slotsId.length; i++) {
        const idSlot = slotsId[i];
        const disponibilita = slotDisponibili[slotsOrari[i]] || 0;

        const slotElement = document.getElementById(idSlot);
        slotElement.dataset.postiDisponibili = disponibilita;

        if (disponibilita < 1) {
            slotElement.disabled = true;
        } else {
            slotElement.disabled = false;
        }
    }
}