var hamStatus = "false";

var currentDataPrenotazione = '';
var currentIdMostra = '';

function hambToggle() {
    var e = document.getElementsByClassName("hamToggle");
    hamStatus = "false" == hamStatus ? "true" : "false";
    for (var t = 0; t < e.length; t++) {
        e[t].setAttribute("data-hambOn", hamStatus);
        var n = e[t].style.display;
        e[t].style.display = "none",
            e[t].style.display = n
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