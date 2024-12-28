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
    // cancella nel db
    dialog.close();
});