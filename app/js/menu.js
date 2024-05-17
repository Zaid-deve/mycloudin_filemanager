$(document).ready(function () {

    $(".files-grid .file-outer").click(function (e) {
        if (e.ctrlKey) {
            e.preventDefault()
            let filepath = $(this).data('filepath')
            if (filepath) {
                const c = $(this).find('.file-check-outer')
                if (c.find("#fileCheck")[0].checked) return;

                c.removeClass('d-none')
                c.find("#fileCheck")[0].checked = true
                c.find("#fileCheck").change()
            }
        }
    })

    $(document).on('keyup', function (e) {
        if (e.ctrlKey && e.keyCode == 65) {
            $(".files-grid .file-outer").each(function (i, f) {
                const c = $(f).find('.file-check-outer')
                c.removeClass('d-none')
                c.find("#fileCheck")[0].checked = true
                c.find("#fileCheck").change()
            })
        }
    })

    $(document).on("click", function (event) {
        if (!$(event.target).closest(".menu").length && !$(event.target).closest(".file-outer").length) {
            hideMenu();
        }
    });
});
