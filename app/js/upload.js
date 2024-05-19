$(function () {
    let filesToUpload = [],
        failedUploads = [],
        activeXhrs = []


    const maxFileSize = 32000000


    $("#uploadSelInp").change(function () {
        const files = $(this)[0].files;
        filesToUpload = Array.from(files);

        createProgressItems(filesToUpload)
        filesToUpload = filesToUpload.filter(function(f){
            if(f.size > maxFileSize){
                failedUploads.push(f.name+" Exceeded File Size Limit Of 50mb !")
            }
            return f.size < maxFileSize
        })
        uploadNextFile();
    })

    function createProgressItems(files) {
        let progressCol = "<div class='row row-gap-3'>";
        files.forEach((f, i) => {
            let c = "d-none";

            if (f.size > maxFileSize) {
                c = "d-flex"
            }

            let name = f.name,
                size = (f.size / 1048576).toFixed(1)

            progressCol += `
                              <div class="col-lg-6 progress-col" data-filename='${name}'>
                                  <div class="row g-0 bg-light py-2 rounded-3 pe-2">
                                      <div class="col-1 progress-icon d-flex">
                                          <i class="ri-file-line"></i>
                                      </div>
                                      <div class="col-10 progress-file-info flex-grow-1">
                                          <div class="file-name">${name}</div>
                                          <div class="row g-2 align-items-center">
                                              <div class="col">
                                                  <div class="progress-width w-100 rounded-5 bg-info">
                                                      <div class="progress-line h-100 bg-dark rounded-5">
                                                          <div class="progress-line-inner h-100 w-100 bg-secondary rounded-5"></div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-3">
                                                  <div class="progress-info"><span class='progress-comp'>0%</span> &bullet; ${size}MB</div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="progress-status col-1 ${c}">
                                          <i class="ri-error-warning-fill text-danger"></i>
                                      </div>
                                  </div>
                              </div>`
        })
        progressCol += "</div>";
        $(".progress-outer").removeClass("d-none")
        $(".progress-center").html(progressCol);
    }

    function updateProgress(e, fname) {
        let pg = $(`.progress-center .progress-col[data-filename='${fname}']`)
        if (pg.length) {
            let { total, loaded } = e,
                comp = (loaded / total * 100).toFixed(0);

            pg.find(".progress-line").css('width', loaded + "%")
            pg.find(".progress-comp").html(`${comp}%`)
        }
    }

    function uploadNextFile(i = 0) {
        if (!filesToUpload.length) {
            if (failedUploads.length > 0) $(".alert").removeClass('d-none').html("Upload Errors:<br>" + failedUploads.join("<br>"))
            return;
        }

        let file = filesToUpload.shift(),
            formData = new FormData(),
            p = getParam("path");

        formData.append('file', file);
        if(p) formData.append("path",p);

        let xhr = $.ajax({
            url: `${baseURL}/app/php/upload.php`, // Your server-side upload script
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        updateProgress(evt, file.name);
                    }
                }, false);
                return xhr;
            },
            success: function (resp) {
                if (resp == "success") $(`.progress-center .progress-col[data-filename='${file.name}']`).find(".progress-status").removeClass("d-none").addClass('d-flex').html(`<i class='ri-shield-check-fill text-success'></i>`)
                else {
                    $(`.progress-center .progress-col[data-filename='${f.name}']`).find(".progress-status").removeClass("d-none").addClass('d-flex').html(`<i class='ri-error-warning-fill  text-danger'></i>`)
                    failedUploads.push(resp)
                }
                uploadNextFile(i + 1);
            },
            error: function () {
                $(`.progress-center .progress-col[data-filename='${file.name}']`).find(".progress-status").removeClass("d-none").addClass('d-flex').html(`<i class='ri-error-warning-fill  text-danger'></i>`)
                failedUploads.push("error uploading: " + file.name);
                uploadNextFile(i + 1);
            }
        });

        activeXhrs.push(xhr)
    }

    $(".btn-cancel-upload").click(function () {
        filesToUpload = []
        failedUploads = []
        activeXhrs.forEach(x => x.abort())
        activeXhrs = []
        $(".progress-center").empty();
        $(".progress-outer").addClass('d-none')
        $("##uploadSelInp").val('')
    })

})