var CIRCULATION = CIRCULATION || {};
CIRCULATION.crm = (function () {
    /***************
    *Private Region*
    ****************/

    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            new HelpController({
                fields: '#unit,#product,#subscriber,#scheme,#agent,#response,#status,#agent,#copy_type',
                fieldBtns: '#unit_search,#product_search,#subscriber_search,#scheme_search,#agent_search,#response_search,#status_search,#agent_search,#copy_type_search'
            });
            $("[data-mask]:not([readonly])").inputmask();
            $('[data-mask]:not([readonly])').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            });
            //YEAR PICKER
            $('.yearpicker').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });
            //clone table data before datatable
            CIRCULATION.utils.exportExcel(null, null, null, null, true, false);

            //create
            if (page == 'CRM-CREATE') {
                var statsRecord = []; //global
                $("#add_status").click(function () {
                    var responseHead = $("#response_rec_sel").val(),
                        entryStatus = $("#status_rec_sel").val(),
                        entryType = $('#entry_type').val(),
                        error = 0, rowTmpl = '', record = { "type": "", "head": "", "status": "", "remark": "" };
                    if ((responseHead == undefined || responseHead.trim() == '') && (entryType != 'Action')) {
                        $("#response").addClass('haserror');
                        error++;
                    } else {
                        $("#response").removeClass('haserror');
                    }
                    if (entryStatus == undefined || entryStatus.trim() == '') {
                        $("#status").addClass('haserror');
                        error++;
                    } else {
                        $("#status").removeClass('haserror');
                    }

                    if (error == 0) {
                        record.type = entryType;
                        var resHeadRec = JSON.parse(decodeURIComponent(responseHead)),
                            statsRec = JSON.parse(decodeURIComponent(entryStatus));
                        record.head = resHeadRec["Code"];
                        record.status = statsRec["Code"];
                        record.remark = $('#remarks').val().toUpperCase();
                        statsRecord.push(record);
                        $('#status_record').val(JSON.stringify(statsRecord));
                        $('#no-record').remove();
                        rowTmpl = '<tr align="center" data-record="' + encodeURIComponent(JSON.stringify(record)) + '"><td>' + record.type + '</td><td>' + resHeadRec["Name"] + '</td>'
                        + '<td>' + record.remark + '</td>'
                        + '<td>' + statsRec["Name"] + '</td>'
                        + '<td>' + ($('#user_name').val()) + '</td>'
                        + '<td>' + moment().format("DD-MM-YYYY hh:mm A") + '</td></tr>';
                        $('#response_table tbody').append(rowTmpl);
                        statsFormReset();
                    }
                });
                function statsFormReset() {
                    $('#entry_type').val("Incoming");
                    $('#response').val("");
                    $('#response_rec_sel').remove();
                    $('#status').val("");
                    $('#status_rec_sel').remove();
                    $('#remarks').val('');
                }

                $('#customer').change(function () {
                    var selected = $(this).val().toLowerCase();
                    var type = 0;
                    if (selected == 'subscriber') {
                        type = 0;
                    } else if (selected == 'agent') {
                        type = 1;
                    } else {
                        type = 2;
                    }
                    $('.cus').addClass('hidden');
                    $('#' + selected + '_box').removeClass('hidden').addClass('animated fadeInLeft');
                    $('.cus_inp').val("");
                    $('#subscriber_rec_sel').remove();
                    $('#agent_rec_sel').remove();
                    $('#cus_type').val(type);
                });
                function toggleResponseHead() {
                    if ($("#entry_type").val() == 'Action') {
                        $("#response_head_wrapper").hide();
                        $("#response, #response_rec_sel").val('');
                    }
                    else {
                        $("#response_head_wrapper").show();
                    }
                }
                $("#dept, #customer, #entry_type").change(function () {
                    toggleResponseHead();
                    $("#status, #status_rec_sel, #response, #response_rec_sel").val('');
                });
                toggleResponseHead();
            }
            else if (page == 'CRM-VIEW') {
                $("#add_status").click(function () {
                    var responseHead = $("#response_rec_sel").val().trim(),
                        entryStatus = $("#status_rec_sel").val().trim(),
                        entryType = $('#entry_type').val(),
                        error = 0;
                    if (responseHead == '' && entryType != 'Action') {
                        $("#response").addClass('haserror');
                        error++;
                    } else {
                        $("#response").removeClass('haserror');
                    }
                    if (entryStatus == '') {
                        $("#status").addClass('haserror');
                        error++;
                    } else {
                        $("#status").removeClass('haserror');
                    }

                    if (error == 0) {
                        CIRCULATION.utils.showLoader();
                        var newLevel = parseInt($('#resTbody tr:last').attr("data-level") || 0) + 1;
                        var statusRec = JSON.parse(decodeURIComponent(entryStatus)),
                            entryType = $('#entry_type').val(),
                              remarks = $('#remarks').val(),
                         responseCode = 0,
                         responseName = null;

                        if (responseHead) {
                            responseRec = JSON.parse(decodeURIComponent(responseHead));
                            responseCode = responseRec['Code'];
                            responseName = responseRec['Name'];
                        }

                        var formData = new FormData();
                        formData.append("token_no", $('#token_no').val());
                        formData.append("entry_status", statusRec['Code']);
                        formData.append("level", newLevel);
                        formData.append("res_code", responseCode);
                        formData.append("unit_code", $('#unit_code').val());
                        formData.append("entry_type", entryType);
                        formData.append("remark", remarks);

                        CIRCULATION.utils.sendAjaxPost('CRM/saveCRMStatus', formData, 'json',
                                function successCallBack(data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 400) {
                                        sweetAlert("", data.text, "error");
                                    } else {
                                        if (remarks) remarks = remarks.toUpperCase();
                                        var nodeTr = document.createElement('tr'),
                                            nodeTd = document.createElement('td');
                                        nodeTd.innerHTML = entryType;
                                        nodeTr.appendChild(nodeTd);
                                        nodeTd = document.createElement('td');
                                        nodeTd.innerHTML = responseName;
                                        nodeTr.appendChild(nodeTd);
                                        nodeTd = document.createElement('td');
                                        nodeTd.innerHTML = remarks;
                                        nodeTr.appendChild(nodeTd);
                                        nodeTd = document.createElement('td');
                                        nodeTd.innerHTML = statusRec['Name'];
                                        nodeTr.appendChild(nodeTd);
                                        nodeTd = document.createElement('td');
                                        nodeTd.innerHTML = $('#current_user').val();
                                        nodeTr.appendChild(nodeTd);
                                        nodeTd = document.createElement('td');
                                        nodeTd.innerHTML = moment().format("DD-MMM-YYYY hh:mm A");
                                        nodeTr.appendChild(nodeTd);
                                        nodeTr.setAttribute("align", "left");
                                        nodeTr.setAttribute("data-level", newLevel);
                                        $("#no-record").remove();
                                        document.getElementById('resTbody').appendChild(nodeTr);
                                        statsFormReset();
                                    }
                                },
                                function errorStatus(textStatus, errorThrown) {
                                    CIRCULATION.utils.hideLoader();
                                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                });
                    }
                });
                function statsFormReset() {
                    $('#entry_type').val("Incoming");
                    $('#response').val("");
                    $('#response_rec_sel').remove();
                    $('#status').val("");
                    $('#status_rec_sel').remove();
                    $('#remarks').val('');
                }
                function toggleResponseHead() {
                    if ($("#entry_type").val() == 'Action') {
                        $("#response_head_wrapper").hide();
                        $("#response, #response_rec_sel").val('');
                    }
                    else {
                        $("#response_head_wrapper").show();
                    }
                }
                $("#dept, #customer, #entry_type").change(function () {
                    toggleResponseHead();
                    $("#status, #status_rec_sel, #response, #response_rec_sel").val('');
                });
                toggleResponseHead();
            }
            else if (page == 'APPROVAL') {
                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }],
                    "fixedColumns": { "leftColumns": 3 }
                });

                //tr click
                $("tr[data-id]").click(function () {
                    var id = $(this).attr("data-id");
                    if (id) {
                        $("#open-approval-form").attr("action", baseUrlPMD + "CRM/EditApproval?g_fe=" + id).submit();
                    }
                });

                $("#add_sales_comments").click(function () {
                    var salesCode = $("#sales_code").val(),
                        salesComment = $("#sales_comments").val();
                    if (salesCode && salesComment) {
                        swal({
                            title: "",
                            text: "Are you save this comment?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                //CIRCULATION.utils.showLoader();
                                var formData = new FormData(),
                                    $tbl = $("#comments-table tbody");
                                formData.append("sales_comment", salesComment);
                                formData.append("sales_code", salesCode);

                                var currentdate = new Date();
                                var datetime = currentdate.getDate() + "-" + (currentdate.getMonth() + 1) + "-" + currentdate.getFullYear() +" "+ currentdate.toLocaleTimeString().replace(/:\d+ /, ' ');

                                CIRCULATION.utils.sendAjaxPost('CRM/AddComments', formData, 'json',
                                function successCallBack(data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 200) {
                                        $tbl.find("tr.no-records").addClass("hide");
                                        var tmpl = '<tr>'
                                                    + '<td>' + datetime + '</td>'
                                                    + '<td>' + salesComment + '</td>'
                                                    + '<td>' + userName + '</td>'
                                                + '</tr>';
                                        $("#sales_comments").val('')
                                        $tbl.append(tmpl);
                                        //sweetAlert("", data.text, "success");
                                    } else {
                                        sweetAlert("Oops...", data.text, "error");
                                    }
                                },
                                function errorStatus(textStatus, errorThrown) {
                                    CIRCULATION.utils.hideLoader();
                                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                });
                            }
                        });
                    }
                });

                $("#update_approval_status").click(function () {
                    var salesCode = $("#sales_code").val(),
                        salesStatus = $("#approve_status_type").val();
                    if (salesCode) {
                        swal({
                            title: "",
                            text: "Are you save this status?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                //CIRCULATION.utils.showLoader();
                                var formData = new FormData(),
                                    $tbl = $("#comments-table tbody");
                                formData.append("sales_status", salesStatus);
                                formData.append("sales_code", salesCode);

                                var currentdate = new Date();
                                var datetime = currentdate.getDate() + "-" + (currentdate.getMonth() + 1) + "-" + currentdate.getFullYear() + " " + currentdate.toLocaleTimeString().replace(/:\d+ /, ' ');

                                CIRCULATION.utils.sendAjaxPost('CRM/UpdateApprovalStatus', formData, 'json',
                                function successCallBack(data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 200) {                             
                                        sweetAlert("", data.text, "success");
                                    } else {
                                        sweetAlert("Oops...", data.text, "error");
                                    }
                                },
                                function errorStatus(textStatus, errorThrown) {
                                    CIRCULATION.utils.hideLoader();
                                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                });
                            }
                        });
                    }
                });                
            }
        },
        validateCRM: function () {
            var errorCount = 0,
                unitRec = $('#unit_rec_sel').val(),
                productRec = $('#product_rec_sel').val(),
                subscriberRec = $('#subscriber_rec_sel').val(),
                agentRec = $('#agent_rec_sel').val(),
                cusName = $('#gen_name').val(),
                cusType = $('#customer').val(),
                responseHead = $("#response_rec_sel").val(),
                entryType = $('#entry_type').val(),
                entryStatus = $("#status_rec_sel").val(), statsRecord=[], record = { "type": "", "head": "", "status": "", "remark": "" };
            if ((responseHead == undefined || responseHead.trim() == '') && (entryType != 'Action')) {
                $("#response").addClass('haserror');
                errorCount++;
            } else {
                $("#response").removeClass('haserror');
            }
            if (entryStatus == undefined || entryStatus.trim() == '') {
                $("#status").addClass('haserror');
                errorCount++;
            } else {
                $("#status").removeClass('haserror');
            }
            if (unitRec == undefined || unitRec.trim() == '') {
                $('#unit').addClass('haserror');
                errorCount++;
            } else {
                $('#unit').removeClass('haserror');
            }
            if (productRec == undefined || productRec.trim() == '') {
                $('#product').addClass('haserror');
                errorCount++;
            } else {
                $('#product').removeClass('haserror');
            }
            if (cusType == 'Subscriber' && (subscriberRec == undefined || subscriberRec.trim() == '')) {
                $('#subscriber').addClass('haserror');
            } else {
                $('#subscriber').removeClass('haserror');
            }
            if (cusType == 'Agent' && (agentRec == undefined || agentRec.trim() == '')) {
                $('#agent').addClass('haserror');
            } else {
                $('#agent').removeClass('haserror');
            }
            if (cusType == 'General' && (cusName == undefined || cusName.trim() == '')) {
                $('#gen_name').addClass('haserror');
            } else {
                $('#gen_name').removeClass('haserror');
            }
            if (errorCount > 0) {
                return false;
            } else {
                record.type = $('#entry_type').val();
                var resHeadRec = JSON.parse(decodeURIComponent(responseHead)),
                    statsRec = JSON.parse(decodeURIComponent(entryStatus));
                record.head = resHeadRec["Code"];
                record.status = statsRec["Code"];
                record.remark = $('#remarks').val().toUpperCase();
                statsRecord.push(record);
                $('#status_record').val(JSON.stringify(statsRecord));
                return true;
            }
        }
    }
})();
