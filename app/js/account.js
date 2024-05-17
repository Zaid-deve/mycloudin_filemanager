$(function () {
    if($("#_uname").val() != ''){
        $("#_uname").addClass('valid');
    }
    $("#_uname").change(function () {
        if ($(this).val()) {
            $(this).addClass("valid")
            $(".btn-submit").removeClass("d-none").focus()
            return
        }

        $(this).removeClass("valid");
    })

    $("#dis_acc").change(function () {
        if ($(this)[0].checked) {
            $(".btn-submit").removeClass("d-none").focus()
        }
    })

    $("#changeProfileInp").change(function (e) {
        const files = e.target.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.size > 2000000) {
                alert('profile picture must be of 2mb !')
                $(this).val('')
                return
            }
            $(".btn-submit").removeClass("d-none").focus()
        }
    })

    $(".btn-submit").click(function () {
        $(this).attr("disabled");
        const data = new FormData()
        if ($("#_uname").val()) {
            data.append("uname", $("#_uname").val())
        }

        if ($("#dis_acc")[0].checked) {
            const cnfm = confirm("Are you sure you want to delete your account ?\nYour All Files Will Be Deleted")
            if (!cnfm) {
                $("#dis_acc")[0].checked = false
            } else {
                data.append("deleteAccount", true)
            }
        }

        if ($("#changeProfileInp").val()) {
            data.append("profileImg", $("#changeProfileInp")[0].files[0])
        }

        if (data.length == 0) {
            $(this).addClass("d-none");
            return;
        }

        $.ajax({
            url: "http://localhost/file_manager/app/php/change.php",
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function (resp) {
                if (resp == "success") location.reload();
                else $(".alert").removeClass("d-none").addClass('d-flex').find(".alert-text").text(resp);
            }
        })
    })
})