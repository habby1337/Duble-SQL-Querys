function addAlert(message, color) {
    // $(".alert").addClass("in");
    $('#alert').append(
        '<div class="alert alert-' + color + ' alert-dismissible in fade show" role="alert">' +
        '<h4 class="alert-heading">Errore!</h4>' +
        '<p>Aww, ' + message + '.</p>' +
        '<hr>' +
        '<p class="mb-0">Se l\'errore persiste contatta lo sviluppatore.</p>' +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
        '</div>'
    )
}



function checkInputs(id) {
    // Check if input is empty
    if (!$(id).val()) {
        //If empty add class invalid and remove invalid
        $(id).addClass('is-invalid').removeClass('is-valid');
        no_empty_fields = false;

    } else {
        //if not empty add class valid and remove invalid
        $(id).addClass('is-valid').removeClass('is-invalid');
        no_empty_fields = true;
    }
}



function addZeroes(num) {
    const dec = num.split('.')[1]
    const len = dec && dec.length > 2 ? dec.length : 2
    return Number(num).toFixed(len)
}


$(document).ready(function () {
    $('#navbar').load('components/navbar.html');
})