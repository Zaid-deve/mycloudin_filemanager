$(function () {
    try {
        let curr = $(".output").html();
        let debounceTimer;
        const debounceDelay = 200;

        $("#_search").on("input", function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const qry = $(this).val(),
                    dir = getParam("path"),
                    data = {}

                if (dir) {
                    data.dir = dir;
                }

                if (!qry) {
                    $(".output").html(curr);
                    return;
                }

                data.qry = qry;
                $.post(`${baseURL}/app/includes/search.php`, data, function (resp) {
                    $(".output").html(resp);
                });
            }, debounceDelay);
        });
    } catch (e) {
        alert(e);
    }
});
