<script>


    function file_input(selector, options) {
        let defaults  = {
            theme: "fas",//gly
            showDrag: false,
            deleteExtraData: {
                '_token': '<?php echo e(csrf_token()); ?>',
            },
            // hideThumbnailContent: true,
            browseClass: "btn btn-info",
            browseLabel: "اضغط للاستعراض",
            browseIcon: "<i class='la la-file'></i>",
            removeClass: "btn btn-danger",
            removeLabel: "حذف",
            removeIcon: "<i class='la la-trash-o'></i>",
            showRemove: false,
            showCancel: false,
            showUpload: false,
            showPreview: true,
            msgPlaceholder: "اختر ملف",
            msgSelected: "تم الاختيار ",
            fileSingle: "ملف واحد",
            filePlural: "اكثر من ملف",
            dropZoneTitle: "سحب وافلات",
            msgZoomModalHeading: "معلومات الملف",
            dropZoneClickTitle: '<br> اضغط للاستعراض',
            initialPreview: [],
            initialPreviewShowDelete: options,
            initialPreviewAsData: true,
            initialPreviewConfig: [],
            initialPreviewFileType: 'image',
            overwriteInitial: true,
            browseOnZoneClick: true,
            captionClass:true,
            maxFileCount: 6,
            allowedFileExtensions: ["jpg", "png", "gif", "pdf"],
            slugCallback: function(filename) {
                return filename.replace('(', '_');
            }
        };
        let settings = $.extend( {}, defaults, options );
        $(selector).fileinput(settings);
    }

    function file_input_register(selector, options) {
        let defaults  = {
            theme: "fas",//gly
            showDrag: false,
            deleteExtraData: {
                '_token': '<?php echo e(csrf_token()); ?>',
            },
            // hideThumbnailContent: true,
            browseClass: "btn btn-info",
            browseLabel: "اضغط للاستعراض",
            browseIcon: "<i class='la la-file'></i>",
            removeClass: "btn btn-danger",
            removeLabel: "delete",
            removeIcon: "<i class='la la-trash-o'></i>",
            showRemove: false,
            showCancel: false,
            showUpload: false,
            showPreview: true,
            msgPlaceholder: "اختر ملف",
            msgSelected: "تم الاختيار ",
            fileSingle: "ملف واحد",
            filePlural: "اكثر من ملف",
            dropZoneTitle: "سحب وافلات",
            msgZoomModalHeading: "معلومات الملف",
            dropZoneClickTitle: '<br> اضغط للاستعراض',
            initialPreview: [],
            initialPreviewShowDelete: options,
            initialPreviewAsData: true,
            initialPreviewConfig: [],
            initialPreviewFileType: 'image',
            overwriteInitial: true,
            browseOnZoneClick: true,
            captionClass:true,
            maxFileCount: 6,
            allowedFileExtensions: ["pdf"],
            slugCallback: function(filename) {
                console.log(filename);
                return filename.replace('(', '_');
            }
        };
        let settings = $.extend( {}, defaults, options );
        $(selector).fileinput(settings);
    }

    function file_input_all(selector, options) {
        let defaults  = {
            theme: "fas",//gly
            showDrag: false,
            deleteExtraData: {
                '_token': '<?php echo e(csrf_token()); ?>',
            },
            // hideThumbnailContent: true,
            browseClass: "btn btn-info",
            browseLabel: "اضغط للاستعراض",
            browseIcon: "<i class='la la-file'></i>",
            removeClass: "btn btn-danger",
            removeLabel: "delete",
            removeIcon: "<i class='la la-trash-o'></i>",
            showRemove: false,
            showCancel: false,
            showUpload: false,
            showPreview: true,
            msgPlaceholder: "اختر ملف",
            msgSelected: "تم الاختيار ",
            fileSingle: "ملف واحد",
            filePlural: "اكثر من ملف",
            dropZoneTitle: "سحب وافلات",
            msgZoomModalHeading: "معلومات الملف",
            dropZoneClickTitle: '<br> اضغط للاستعراض',
            initialPreview: [],
            initialPreviewShowDelete: options,
            initialPreviewAsData: true,
            initialPreviewConfig: [],
            initialPreviewFileType: 'image',
            overwriteInitial: true,
            browseOnZoneClick: true,
            captionClass:true,
            maxFileCount: 6,
            slugCallback: function(filename) {
                console.log(filename);
                return filename.replace('(', '_');
            }
        };
        let settings = $.extend( {}, defaults, options );
        $(selector).fileinput(settings);
    }

    function change_status(id, url, status = null, callback = null) {
        $.ajax({
            url: url,
            data: {id: id, status: status, _token: '<?php echo e(csrf_token()); ?>'},
            type: "POST",
            beforeSend(){
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'الرجاء الانتظار'
                });
            },
            success: function (data) {
                if (callback && typeof callback === "function") {
                    callback(data);
                } else {
                    if (data.success) {
                        showAlertMessage('success', data.message);
                        $('#items_table').DataTable().ajax.reload(null, false);
                    } else {
                        showAlertMessage('error', data.message);
                    }
                    KTApp.unblockPage();
                }
            },
            error: function (data, textStatus, jqXHR) {
                console.log(data);
            },
        });
    }
    function showAlertMessage(type,message) {
        if(type === 'success') {
            alertify.success(message)
        } else if(type === 'warning') {
            alertify.warning(message);
        } else if(type === 'error' || type === 'danger') {
            alertify.error(message);
        } else {
            alertify.message(message);
        }
    }
    function showModal(url, callback = null,id=null){
        $.ajax({
            url : url,
            type: "GET",
            beforeSend(){
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'please wait'
                });
            },
            success:function(data) {
                if (callback && typeof callback === "function") {
                    callback(data);
                } else {
                    if (data.success) {

                        if(id==null){

                            $('#page_modal').html(data.page).modal('show', {backdrop: 'static', keyboard: false});
                        }else{

                            $(id).html(data.page).modal('show', {backdrop: 'static', keyboard: false})
                        }

                    } else {
                        showAlertMessage('error', '<?php echo app('translator')->get('constants.unknown_error'); ?>');
                    }
                    KTApp.unblockPage();
                }
            },
            error:function(data) {
                KTApp.unblockPage();
            },
        });
    }

    function postData(data, url, callback = null){
        $.ajax({
            url : url,
            data : data,
            type: "POST",
            processData: false,
            contentType: false,
            beforeSend(){
                KTApp.block('#page_modal', {
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'مكتب تصميم'
                });
            },
            success:function(data) {
                if (callback && typeof callback === "function") {
                    callback(data);
                } else {
                    if (data.success) {
                        $('#page_modal').modal('hide');
                        $('#items_table').DataTable().ajax.reload(null, false);
                        showAlertMessage('success', data.message);
                    } else {
                        if (data.message) {
                            showAlertMessage('error', data.message);
                        } else {
                            showAlertMessage('error', 'حدث خطأ في النظام');
                        }
                    }
                    KTApp.unblock('#page_modal');
                }
                KTApp.unblockPage();
            },
            error:function(data) {
                console.log(data);
                KTApp.unblock('#page_modal');
                KTApp.unblockPage();
            },
        });
    }
    function delete_items(id, url, callback = null) {
        let data = [];
        if (id) {
            data = [id];
        } else {
            if ($('input.select:checked').length > 0) {
                $.each($("input.select:checked"), function () {
                    data.push($(this).val());
                });
            }
        }
        if (data.length <= 0) {
            showAlertMessage('error', '<?php echo app('translator')->get('constants.noSelectedItems'); ?>');
        } else {
            Swal.fire({
                title: data.length === 1 ? '<?php echo app('translator')->get('constants.deleteItem'); ?>' : '<?php echo app('translator')->get('constants.delete'); ?> ' + data.length + ' <?php echo app('translator')->get('constants.items'); ?>',
                text: "<?php echo app('translator')->get('constants.sure'); ?>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#84dc61',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?php echo app('translator')->get('constants.yes'); ?>',
                cancelButtonText: '<?php echo app('translator')->get('constants.no'); ?>'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            'ids': data
                        },
                        beforeSend(){
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                type: 'v2',
                                state: 'success',
                                message: '<?php echo app('translator')->get('constants.please_wait'); ?> ...'
                            });
                        },
                        success: function (data) {
                            if (callback && typeof callback === "function") {
                                callback(data);
                            } else {
                                if (data.success) {
                                    $('#items_table').DataTable().ajax.reload(null, false);
                                    showAlertMessage('success', data.message);
                                } else {
                                    showAlertMessage('error', '<?php echo app('translator')->get('constants.unknown_error'); ?>');
                                }
                                KTApp.unblockPage();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
                }
            });
        }
    }
    <?php if(session('success')): ?>
    showAlertMessage('success', '<?php echo e(session('success')); ?>');
        <?php endif; ?>
        <?php if(session('error')): ?>
    showAlertMessage('error', '<?php echo e(session('error')); ?>');
        <?php endif; ?>
    function request_file_input_attributes(){
        return {
            theme: "explorer",
            uploadUrl: "/file-upload-batch/2",
            minFileCount: 2,
            maxFileCount: 5,
            maxFileSize: 10000,
            removeFromPreviewOnError: true,
            overwriteInitial: false,
            previewFileIcon: '<i class="fas fa-file"></i>',
            initialPreview: [

            ],
            showRemove: false,
            showCancel: false,
            showUpload: false,
            showPreview: true,
            msgPlaceholder: "اختر ملف",
            msgSelected: "تم الاختيار ",
            fileSingle: "ملف واحد",
            filePlural: "اكثر من ملف",
            dropZoneTitle: "سحب وافلات",
            msgZoomModalHeading: "معلومات الملف",
            dropZoneClickTitle: '<br> اضغط للاستعراض',
            initialPreviewAsData: true, // defaults markup,
            browseLabel: "اضغط للاستعراض",
            initialPreviewConfig: [

            ],
            uploadExtraData: {
                img_key: "1000",
                img_keywords: "happy, nature"
            },
            preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
            previewFileIconSettings: { // configure your icon file extensions
                'doc': '<i class="fas fa-file-word text-primary"></i>',
                'xls': '<i class="fas fa-file-excel text-success"></i>',
                'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                'zip': '<i class="fas fa-file-archive text-muted"></i>',
                'htm': '<i class="fas fa-file-code text-info"></i>',
                'txt': '<i class="fas fa-file-text text-info"></i>',
                'mov': '<i class="fas fa-file-video text-warning"></i>',
                'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                'jpg': '<i class="fas fa-file-image text-danger"></i>',
                'gif': '<i class="fas fa-file-image text-muted"></i>',
                'png': '<i class="fas fa-file-image text-primary"></i>'
            },
            previewFileExtSettings: { // configure the logic for determining icon file extensions
                'doc': function(ext) {
                    return ext.match(/(doc|docx)$/i);
                },
                'xls': function(ext) {
                    return ext.match(/(xls|xlsx)$/i);
                },
                'ppt': function(ext) {
                    return ext.match(/(ppt|pptx)$/i);
                },
                'zip': function(ext) {
                    return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                },
                'htm': function(ext) {
                    return ext.match(/(htm|html)$/i);
                },
                'txt': function(ext) {
                    return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                },
                'mov': function(ext) {
                    return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                },
                'mp3': function(ext) {
                    return ext.match(/(mp3|wav)$/i);
                }
            }
        }
    }
</script>

<?php /**PATH C:\wamp64\www\taslem\resources\views/CP/layout/js.blade.php ENDPATH**/ ?>