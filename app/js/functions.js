const checkedFiles = new Set()

let baseURL;
baseURL = location.origin;
if(location.host == "localhost"){
    baseURL += "/file_manager"
}


function getParam(param) {
    if (!param) return;
    const ids = new URLSearchParams(location.search);
    return ids.get(param);
}

function displayEmptyDir() {
    return `<div class="row files-empty-row pt-5">
                <div class="col-md-5">
                    <img src="${baseURL}/images/e0cb5ba254f613287ab2a023e65159de.png" alt="#" class="d-block mx-auto ms-md-auto me-md-0">
                </div>
                <div class="col-md-7 text-center pt-md-5 pt-4">
                    <h1 class="text-secondary">No Files Yet !</h1>
                    <p class="form-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. <br> Nisi eaque voluptatem amet?</p>
                    <a href="${baseURL}/app/user/upload.php${getParam("path") ? '?path=' + getParam("path") : ''}" class="btn btn-primary px-4 rounded-5"><b>Upload Now</b></a>
                </div>
            </div>`
}

function toggleMenu(e) {
    e.preventDefault()
    const target = $(e.target).closest(".file-outer"),
        menu = $(".menu");

    if (target.data('filepath')) {
        menu.data("filepath", target.data('filepath'))
    }

    if (target.data('sharepath')) {
        menu.data("sharepath", target.data('sharepath'))
    }

    showMenu(e);
}

function showMenu(e) {
    let menu = $(".menu").addClass("show"),
        x = e.pageX,
        y = e.pageY;


    var maxTop = $(window).height() - menu.outerHeight(),
        maxLeft = $(window).width() - menu.outerWidth(),
        topPosition = Math.min(Math.max(y, 0), maxTop),
        leftPosition = Math.min(Math.max(x, 0), maxLeft);

    menu.css({
        top: topPosition + 'px',
        left: leftPosition + 'px'
    })
}

function hideMenu() {
    $(".menu").removeClass("show").data("filepath", '')
}

function deleteFile() {
    let fileNames = checkedFiles.size > 0 ? Array.from(checkedFiles).join(";") : $(".menu").data('filepath');
    if (fileNames) {
        let files = fileNames.split(";");
        files.forEach(f => {
            $.post(`${baseURL}/app/php/deleteFile.php`, { path: f }, function (resp) {
                if (resp.trim() == "success") {
                    hideMenu();
                    $(`.files-grid .file-outer[data-filepath='${f}']`).remove();
                    if (!$(".files-grid").children().length) {
                        $(".files-grid").html(displayEmptyDir())
                    }
                    return
                }
                alert(resp);
            })
        })
        $(".menu").data("filepath", '');
    }
}

function renameFile() {
    let fileName = $(".menu").data('filepath');
    if (fileName) {
        let file = fileName.split(';').pop(),
            target = $(`.files-grid .file-outer[data-filepath='${file}']`);

        target = target.find(".file-title").attr("contenteditable", true).focus()
        hideMenu();
        target.blur(function () {
            target.attr("contenteditable", false)
            if (target.text() && target.text() != file) {
                $.post(`${baseURL}/app/php/renameFile.php`, { oldPath: file, newName: target.text() }, function (resp) {
                    if (resp.trim() != "success") {
                        target.text(file);
                    }
                })
            }
        })
    }
}

function checkFile(e) {
    const filepath = $(e.target).closest(".file-outer").data("filepath")
    if (filepath) {
        if (e.target.checked) {
            checkedFiles.add(filepath)
        } else {
            checkedFiles.delete(filepath)
            $(e.target).parent().parent().addClass('d-none')
        }
    }
}

function copyLink() {
    let menu = $('.menu');
    if (menu.data("sharepath")) {
        const path = menu.data("sharepath");
        if (path) {
            navigator.clipboard.writeText(`${baseURL}/app/view/share.php?link=${path}`);
            menu.removeClass("show")
        }
    }
}

function validateEmail(val) {
    const p = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    return p.test(val);
}