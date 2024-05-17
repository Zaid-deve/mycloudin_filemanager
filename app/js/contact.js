function validateForm() {
    var subject = $('#_sub'),
        description = $('#_des'),
        isFormValid = true;

    // Clear previous errors
    $('.form-text').text('').addClass("text-danger");

    if (subject.val().trim().length < 1 || subject.val().trim().length > 100) {
        isFormValid = false;
        subject.addClass("in-valid").next('.form-text').text("Subject must be between 1 and 100 characters.");
    } else {
        subject.removeClass("in-valid").addClass('valid');
    }

    if (description.val().trim().length < 1 || description.val().trim().length > 1000) {
        isFormValid = false;
        description.addClass("in-valid").next('.form-text').text("Description must be between 1 and 1000 characters.");
    } else {
        description.removeClass("in-valid").addClass("valid");
    }

    return isFormValid;
};

$(function () {
    $("#_email, #_sub, #_des").each((i, f) => {
        if ($(f).val()) {
            $(f).addClass("valid");
        }

        $(f).on('change input', function () {
            if ($(this).val()) {
                $(this).addClass("valid");
            } else {
                $(this).removeClass("valid");
            }

            if ($(this).attr("id") != "_email") {
                let maxLength = $(this).attr("id") == "_sub" ? 100 : 1000;
                $(this).next('.form-text').text(`Length ${$(this).val().length} of ${maxLength}`).removeClass("text-danger");
            }
        });
    });

    $('.btn-submit').on('click', function (e) {
        if (validateForm()) {
            $(this).attr("disabled", true)
            $(this).addClass('working');
            $("form").submit();
        }
    });
})