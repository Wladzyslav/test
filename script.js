function checkFields() {
    let date_from = document.getElementById("date-from");
    let date_to = document.getElementById("date-to");
    let status_id = document.getElementById("status_id");
    let importance_id = document.getElementById("importance_id");
    let message = document.getElementById("message");
    if (date_from.value === "" && date_to.value === "" && status_id.value === "" && importance_id.value === "") {
        message.innerHTML = "Заполните, пожалуйста, хотя бы одно поле для поиска";
        return false;
    }
}