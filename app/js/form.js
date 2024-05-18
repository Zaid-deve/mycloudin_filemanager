let reqOtp,
    validateOtp;

$(function () {
    let otpSent;

    reqOtp = function (email, callback) {
        if (email) {
            $.post(`${baseURL}/app/php/generateOtp.php`, { email }, resp => {
                if (typeof callback == "function") {
                    callback(resp)
                }
            }).always(function () {
                $(".btn-submit").attr("disabled", false).removeClass('working')
            })
        }
    }

    validateOtp = function (data, callback) {
        if (data.email && data.otp) {
            $.post(`${baseURL}/app/php/verifyOtp.php`, data, resp => {
                if (typeof callback == "function") {
                    callback(resp)
                }
            }).always(function () {
                $(".btn-submit").attr("disabled", false).removeClass('working')
            })
        }
    }

    $("#_email").change(function () {
        if (!validateEmail($(this).val().trim())) {
            $(this).removeClass('is-valid').addClass('is-invalid').next().text('please enter a valid email address !');
            $(".btn-submit").addClass('d-none')
            return;
        }

        $(this).removeClass('is-invalid').addClass('is-valid').next().text('')
        $(".btn-submit").removeClass('d-none')
    })

    $("#_otp").on("input", function () {
        const otpPattern = /^\d*$/
        if (!$(this).val().match(otpPattern)) {
            $(this).val($(this).val().slice(0, $(this).val().length - 1));
        }
    })

    $("#_otp").change(function () {
        const otpPattern = /^\d{6}$/

        if (!$(this).val().trim().match(otpPattern)) {
            $(this).addClass('is-invalid').next().text('Invalid Otp Format!');
            $(".btn-submit").addClass('d-none')
            return;
        }

        $(this).removeClass('is-invalid').addClass('is-valid').next().text('')
        $(".btn-submit").removeClass('d-none')
    })

    $(".btn-submit").click(function () {

        let email = $("#_email").val().trim(),
            otp = $("#_otp").val().trim(),
            rem_me = $("#remember_me")[0].checked ? "ON" : "OFF";


        if (!otpSent) {
            $(".btn-submit").attr("disabled", true).addClass('working')
            reqOtp(email, (resp) => {
                if (resp == "success") {
                    otpSent = true
                    $("#_email").attr("readonly", true)
                    $(".pass-field").removeClass('d-none')
                    $("#_otp").focus()
                    $(this).addClass('d-none');
                    return;
                }
                $(".alert").removeClass('d-none').addClass('d-flex').find(".alert-text").text(resp);
            })
            return;
        }

        $("#_otp").removeClass("is-invalid").next().text('')

        validateOtp({ email, otp, rem_me }, resp => {
            $(".btn-submit").attr("disabled", true).addClass('working')
            if (resp == "success") {
                location.replace(`${baseURL}/app/user/account.php`);
                return
            } else if(resp == "AUTH_TOKEN_EXPIRE"){
                alert("Otp has Been Expired Please Try Again !");
                location.reload();
            }
            $(".alert").removeClass('d-none').addClass('d-flex').find(".alert-text").text(resp);
        });
    })

    $("#_email,#_otp").change(function () {
        if ($(this).val() != '') {
            $(this).addClass('valid')
            return
        }
        $(this).removeClass('valid')
    })
})