////////////////////////// INIZIALIZZATORI VARI //////////////////////////

var hamStatus = true;

var currentSlideDataPrenotazione = '';
var currentSlideIdMostra = '';

document.addEventListener("DOMContentLoaded", function () {
    hambToggle();
    validatorLoad();
    //document.documentElement.className = 'dark';
    document.getElementById("scopridipiu") && initCarLink();
    document.getElementById("accordion") && initAccordion();
    document.getElementById("giorno") && initAJAX();
    document.getElementById("rating-fs") && initRecensisci();
    document.getElementById("virtualTour-mappa") && initMap();
    document.querySelector("dialog") && initDialog();
    document.getElementById("hamb").addEventListener("click", hambToggle);
    const visitatori = document.getElementById("visitatori");
    if (visitatori && visitatori.value == "") {
        visitatori.removeAttribute("value");      
    }
});

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
    const slides = document.querySelectorAll(".immaginiCarosello img");
    //const links = document.querySelectorAll(".immaginiCarosello .more");
    const dots = document.querySelectorAll(".puntiniCarosello button");
    console.log(slides);
    if (n > slides.length) { currentSlide = 1 }
    if (n < 1) { currentSlide = slides.length }
    for (i = 0; i < slides.length; i++) {
        slides[i].classList.remove("onCarosello");
        //links[i].classList.remove("onCarosello");
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    slides[currentSlide - 1].classList.add("onCarosello");
    //links[currentSlide - 1].classList.add("onCarosello");
    dots[currentSlide - 1].classList.add("active");
    updateDiscoverMore();

}
function updateDiscoverMore(){
    document.getElementById('scopridipiu').addEventListener('click', function(e) {
        e.preventDefault();
        // Trova l'elemento attivo del carosello
        const activeItem = document.querySelector('.onCarosello');
    
        // Ottieni il link associato all'elemento attivo
        const linkId = activeItem.getAttribute('id');
        
        // Reindirizza l'utente al link
        if (linkId > 0) {
            window.location.href = "mostre.php#" + linkId;  // Fa il redirect alla pagina
        } else {
            window.location.href = "virtual_tour.php";
        }
    });
}

function initCarLink() {
    const link = document.getElementById("scopridipiu");
    if (link.getAttribute("href").search(/\-\d/) != -1) {
        link.setAttribute("href", "virtual_tour.php");
        console.log("virtual_tour.php");
        
    }
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
    //con questo evento praticamente se la pagina viene ricaricata con un riferimento ad un id, apre l'accordion
    window.addEventListener("load", function() {
        console.log(this.window.location.hash);
        if (window.location.hash) {
            
            const accordionId = window.location.hash.slice(1); // rimuove il carattere '#'
            const dtElement = document.getElementById(accordionId);

            // Verifica se esiste e se il suo genitore è un `dd` con classe "accordion"
            //questo in modo che l'accordione si apra solo se è un elemento del carosello
            if (dtElement) {
                const parentDd = dtElement.closest("dd"); 
                
                if (parentDd && parentDd.classList.contains("accordion-panel")) {
                    const accordionButton = document.getElementById("accordion");

                    if (accordionButton && accordionButton.classList.contains("accordion")) {
                        accordionButton.click();
                    }
                }
            }
        }
    });
}

function initRecensisci() {

    document.querySelectorAll("#rating-fs label").forEach((label) => {
        label.classList.add("nascosto");
    });
    document.getElementsByName("rating").forEach(addEventListeners);
}

function initMap() {
    let links = document.querySelectorAll("#virtualTour-mappa a");
    for (let i = 0; i < links.length; i++) {
        links[i].addEventListener("click", function () {
            selectSala(i);
        });
    }
}

////////////////////////// VALUTAZIONE RECENSIONI //////////////////////////

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

////////////////////////// DIALOG CONFERMA CANCELLAZIONE //////////////////////////

function initDialog() {

    const dialog = document.querySelector("dialog");
    const confirm = document.querySelector("#conf-dialog");
    const cancel = document.querySelector("#annul-dialog");

    document.querySelectorAll(".cancella").forEach((btn) => {
        btn.addEventListener("click", () => {
            dialog.showModal();
            if (dialog.id === "dialog-pren")
                currentSlideDataPrenotazione = btn.getAttribute("id").substring(5);
            else
                currentSlideIdMostra = btn.getAttribute("id").substring(5);
        });
    });

    cancel.addEventListener("click", () => {
        dialog.close();
    });

    if (dialog.id === "dialog-pren") {
        confirm.addEventListener("click", () => {
            fetch('delete_prenotazione_user.php', {
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
        confirm.addEventListener("click", () => {
            fetch('delete_mostra_admin.php', {
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

////////////////////////// VALIDAZIONE FORM //////////////////////////

const regole = {
    "DataNelPassato": function DataNelPassato(input, params = null) {
        if (!input) {
            return true;
        }
        let dataInserita = new Date(input);
        let oggi = new Date();
        oggi.setHours(0, 0, 0, 0);
        dataInserita.setHours(0, 0, 0, 0);

        return dataInserita <= oggi;
    },

    "DataNelFuturo": function DataNelFuturo(input, params = null) {
        if (!input) {
            return true;
        }
        let dataInserita = new Date(input);
        let oggi = new Date();
        oggi.setHours(0, 0, 0, 0);
        dataInserita.setHours(0, 0, 0, 0);

        return dataInserita >= oggi;
    },

    "OrarioNelFuturo": function OrarioNelFuturo(input, params = null) {
        const dateInput = document.getElementById("giorno").value;
        if (!input || !dateInput) {
            return true;
        }
        const dataInserita = new Date(document.getElementById("giorno").value);
        const dataOrario = new Date(dateInput + "T" + input);
        const oggi = new Date();
        return dataOrario > oggi || dataInserita.setHours(0, 0, 0, 0) !== oggi.setHours(0, 0, 0, 0);
    },

    "InteroNonNegativo": function InteroNonNegativo(input, params = null) {
        if (!input) {
            return true;
        }
        return input >= 0;
    },

    "MatchRegex": function MatchRegex(input, regex) {
        return input.trim().search(regex) == 0;
    },

    "RangeVisitatori": function RangeVisitatori(input, params = null) {
        if (!input) {
            return true;
        }
        return parseInt(input) <= parseInt(params) && parseInt(input) > 0;
    },

    "DataFine": function DataFine(input, params = null) {
        const dataInserita = document.getElementById("data_inizio").value;
        if (!input || !dataInserita) {
            return true;
        }
        const dataInizio = new Date(dataInserita);
        const dataFine = new Date(input);
        return dataFine >= dataInizio || document.getElementById("data_fine").setAttribute('value', dataInserita);
    },

    "DimensioneFile": function DimensioneFile(input, params = null) {
        if (!input) {
            return true;
        }
        const fileInput = document.getElementById('immagine');
        const file = fileInput.files[0];
        return file.size <= 1024 * 1024;
    }
}

const checklist = {
    /* check mostra*/
    err_nome_mostra: [
        ['MatchRegex', /^.{2,80}$/, 'Inserire il nome della mostra, minimo 2 caratteri, massimo 80'],
        ['MatchRegex', /^[\p{L}\p{P}\p{N}\s<>/=]*$/u, 'Non sono ammessi caratteri speciali']
    ],
    err_descrizione: [
        ['MatchRegex', /^.{25,5000}$/, 'Inserire la descrizione della mostra, minimo 25 caratteri, massimo 5000'],
        ['MatchRegex', /^[\p{L}\p{P}\p{N}\s\n<>/=]*$/u, 'Non sono ammessi caratteri speciali']
    ],
    err_data_inizio: [
        /* ['MatchRegex', /^\d{4}-\d{2}-\d{2}$/, 'Inserire una data valida'] */
    ],
    err_data_fine: [
        /* ['MatchRegex', /^\d{4}-\d{2}-\d{2}$/, 'Inserire una data valida'], */
        ['DataFine', '', 'La data di fine mostra non può essere precedente alla data di inizio']
    ],
    err_immagine: [
        ['MatchRegex', /^.*\.(webp|png|jpeg|jpg)$/, 'Caricare un\'immagine in formato <abbr lang="en" title="Portable Network Graphics">PNG</abbr>, <abbr lang="en" title="Joint Photographic Experts Group">JPG/JPEG</abbr> o <abbr lang="en" title="Web Picture">WebP</abbr>'],
        ['DimensioneFile', '', 'L\'immagine non può superare 1<abbr lang="en" title="Megabyte">MB</abbr>']
    ],

    /* check recensione*/
    err_data_visita: [
        /* ['MatchRegex', /^\d{4}-\d{2}-\d{2}$/, 'Inserire una data valida'], */
        ['DataNelPassato', '', 'La data della visita non può essere nel futuro']
    ],
    //err_descrizione comune a mostra

    /* check registrazione*/
    err_nome: [
        ['MatchRegex', /^.{2,50}$/, 'Inserire il proprio nome, minimo 2 caratteri, massimo 50'],
        ['MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']*$/, 'Non sono ammessi numeri o caratteri speciali']
    ],
    err_cognome: [
        ['MatchRegex', /^.{2,50}$/, 'Inserire il proprio cognome, minimo 2 caratteri, massimo 50'],
        ['MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']*$/, 'Non sono ammessi numeri o caratteri speciali']
    ],
    err_username: [
        ['MatchRegex', /^.{4,20}$/, 'Scegliere il proprio <span lang="en">username</span>, minimo 4 caratteri, massimo 20'],
        ['MatchRegex', /^[A-Za-z0-9]*$/, 'Sono ammessi solo lettere non accentate e numeri']
    ],
    err_email: [
        ['MatchRegex', /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, 'Inserire il proprio indirizzo <span lang="en">email</span> nel formato corretto']
    ],
    err_password: [
        ['MatchRegex', /.{8,}/, 'La <span lang="en">password</span> deve essere lunga almeno 8 caratteri'],
        ['MatchRegex', /^(?=.*[@$!%*?&])(?=.*[a-zA-Z])(?=.*\d).{8,}$/, 'La <span lang="en">password</span> deve contenere almeno almeno una lettera, un numero e un carattere speciale tra @ $ ! % * ? &']
    ],

    /* check prenotazione*/
    err_giorno: [
        ['DataNelFuturo', '', 'La data della prenotazione non può essere nel passato']
    ],
    err_orario: [
        ['OrarioNelFuturo', '', 'L\'orario della prenotazione non può essere nel passato']
    ],
    err_visitatori: [
        ['RangeVisitatori', '15', 'Il numero di visitatori per la data e l\'ora selezionata deve essere compreso tra 1 e 15']
    ],
};


function validate(check, rule) {

    const err = document.getElementById(check);
    const input = document.getElementById(err.getAttribute("data-ref-to"));
    const valid = regole[rule[0]](input.value, rule[1]);


    if (valid) {
        input.removeAttribute("aria-invalid");
        input.removeAttribute("aria-describedby");
        err.removeAttribute("role");
        err.classList.remove("toggleOn");
        err.classList.add("none");
        return true;
    } else {
        input.setAttribute("aria-invalid", "true");
        input.setAttribute("aria-describedby", check);
        input.getAttribute('type') !== 'date' && input.focus();
        err.classList.add("toggleOn");
        err.classList.remove("none");
        err.setAttribute("role", "alert");
        err.innerHTML = rule[2];
        return false;
    }
}

function validatorCheckAll() {
    for (const check in checklist) {
        const err = document.getElementById(check) || document.getElementById(checklist[check][3]);
        if (err) {
            for (const rule of checklist[check]) {
                if (!validate(check, rule)) {
                    document.getElementById(err.getAttribute('data-ref-to')).focus();
                    return false;
                }
            }
        }
    }
    return true;
}

function validatorLoad() {

    for (const check in checklist) {
        const err = document.getElementById(check);
        if (err) {
            err.classList.add("none");
            const input = document.getElementById(err.getAttribute("data-ref-to"));
            if (input.getAttribute('type') !== 'file' && input.tagName !== 'SELECT')
                input.addEventListener('blur', () => {
                    for (const rule of checklist[check]) {
                        if (!validate(check, rule))
                            return;
                    }
                });
            else
                input.addEventListener('change', () => {
                    for (const rule of checklist[check]) {
                        if (!validate(check, rule))
                            return;
                    }
                });
            input.addEventListener('input', () => {
                if (!err.classList.contains("none") && err.innerHTML != "")
                    for (const rule of checklist[check]) {
                        if (!validate(check, rule))
                            return;
                    }

            });
        }
    }
    const form = document.getElementById("form");
    form && (form.onsubmit = function () { return validatorCheckAll(); })
}

function initAJAX() {
    document.getElementById('giorno').addEventListener('change', function () {
        document.getElementById('orario').value = "";
        document.getElementById('visitatori').value = "";

        const giornoSelezionato = this.value;

        if (!giornoSelezionato) return;
        fetch('phplibs/controlla_disponibilita.php', {
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

        checklist["err_visitatori"][0][1] = maxVisitatori;
        checklist["err_visitatori"][0][2] = checklist["err_visitatori"][0][2].replace("15", maxVisitatori.toString());
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