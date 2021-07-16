$('#check').change(function () {
    $('#btncheck').prop("disabled", !this.checked);
}).change()

function editform() {
    document.getElementById("editfor").setAttribute('disabled', false)
}

const textarea = document.querySelector("textarea");
textarea.addEventListener("input", event => {
    const target = event.currentTarget;
    const maxLength = target.getAttribute("maxlength");
    const currentLength = target.value.length;

    if (currentLength >= maxLength) {
        return console.log("You have reached the maximum number of characters.");
    }
    console.log(`${maxLength - currentLength} chars left`);
});