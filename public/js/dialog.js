const dialog = document.querySelector("#dialog-pren");
const confirm = document.querySelector("#conf-dialog");
const cancel = document.querySelector("#annul-dialog");

document.querySelectorAll(".canc-pren").forEach((btn) => {
    btn.addEventListener("click", () => {
        dialog.showModal();
    });
});

cancel.addEventListener("click", () => {
    dialog.close();
});

confirm.addEventListener("click", () => {
    var dataPrenotazioneTemp = document.getElementById("data_prenotazione");
    var dataPrenotazione =  dataPrenotazioneTemp.getAttribute("datetime");
    console.log(dataPrenotazione);
    fetch('../delete_prenotazione_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `data_prenotazione=${encodeURIComponent(dataPrenotazione)}`,
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