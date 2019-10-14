var CIRCULATION = CIRCULATION || {};
CIRCULATION.transactions = (function () {
    /***************
    *Private Region*
    ****************/

    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            new HelpController({
                fields: '#agent,#copy_type,#subscriber,#canvassed_by,#serviced_by,#wellwisher,#amend_reason,#copy_group,#product,#sub_subscriber,#p_product,#p_agent,#p_subscriber,#p_sub_subscriber,#packet_reason,#p_packet_reason,#accounthead,#p_accounthead,#sponsor_client,#bank,#promoter,#tmp_rcpt,#receipt_no,#shakha,#event,#temporary_receipt',
                fieldBtns: '#agent_search,#copy_type_search,#subscriber_search,#canvassed_by_search,#serviced_by_search,#wellwisher_search,#amend_reason_search,#copy_group_search,#product_search,#sub_subscriber_search,#p_product_search,#p_agent_search,#p_subscriber_search,#p_sub_subscriber_search,#packet_reason_search,#p_packet_reason_search,#accounthead_search,#p_accounthead_search,#sponsor_client_search,#bank_search,#promoter_search,#tmp_rcpt_search,#receipt_no_search,#shakha_search,#event_search,#temporary_receipt_search'
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
            //user master page start here
            if (page == 'ENROLL') {

                //toggle canvassed users
                $("#canvassed_by_type").change(function () {
                    var val = parseInt($(this).val());
                    $("#canvassed_by, .canvassed_by_clr, #canvassed_by_others").val('');
                    $(".can-agent-details").addClass('hide');
                    if (val === 17) $(".can-agent-details").removeClass('hide');
                    if (val) {
                        $("#canvassed_by_users").removeClass("hide");
                        $("#canvassed_by_others").addClass("hide");
                        $("#canvassed_by").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                    } else {
                        $("#canvassed_by_users").addClass("hide");
                        $("#canvassed_by_others").removeClass("hide");
                    }
                });

                //toggle serviced by users serviced_by_type
                $("#serviced_by_type").change(function () {
                    var val = parseInt($(this).val());
                    $(".serv-agent-details").addClass('hide');
                    if (val === 17) $(".serv-agent-details").removeClass('hide');
                    $("#serviced_by, .serviced_by_clr").val('');
                    $("#serviced_by").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                });

                //toggle wellwisher users
                $("#wellwisher_type").change(function () {
                    var val = parseInt($(this).val());
                    $("#wellwisher, .wellwisher_clr").val('');
                    $("#wellwisher").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                });

                //toggle end date
                $("#sales_end_flag").click(function () {
                    $("#sales_start_date").removeAttr("data-compare", "#sales_end_date");
                    $("#sales_end_date").val('').attr("readonly", true).removeAttr("required").datepicker("destroy");
                    if ($(this).prop('checked') == true) {
                        $("#sales_end_date").attr("readonly", false).attr("required",true).datepicker({
                            format: "dd-mm-yyyy",
                            autoclose: true,
                            todayHighlight: true,
                            toggleActive: true
                        });
                        $("#sales_start_date").attr("data-compare", "#sales_end_date");                        
                    }
                });

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }],
                    "fixedColumns": {"leftColumns": 3}
                });

                //tr click
                $("tr[data-id]").click(function () {
                    var id = $(this).attr("data-id");
                    if (id) {
                        $("#open-enroll-form").attr("action", baseUrlPMD + "Transactions/EnrollEdit?g_fe=" + id).submit();
                    }
                });

                //stop copy
                $("#stop-copy").click(function () {
                    var reasonRec = ($("#amend_reason_rec_sel").val() || null),
                        code = $("#sales_code").val(),
                        subsRecords = JSON.parse(decodeURIComponent($("#subscriber_rec_sel").val())),
                        subsCode = subsRecords['Code'];
                    if (reasonRec && code && subsCode) {
                        swal({
                            title: "",
                            text: "Are you sure to stop copy?",
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
                                CIRCULATION.utils.showLoader();
                                var formData = new FormData();
                                formData.append("reason_rec", reasonRec);
                                formData.append("sales_code", code);
                                formData.append("subscriber_code", subsCode);                                
                                CIRCULATION.utils.sendAjaxPost('Transactions/StopCopy', formData, 'json',
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
                    else {
                        sweetAlert("Oops...","Please Select Reason!", "error");
                    }
                });

                //trigger-upsert
                $("#upsert-records").click(function () {
                    var dateRec = [],
                        startDate = ($("#sales_start_date").val() || null),
                        copies = parseInt($("#sales_copies").val());

                    if (copies && startDate) {
                        CIRCULATION.utils.showLoader();
                        dateRec.push(startDate);
                        var formData = new FormData();
                        formData.append("date_rec", JSON.stringify(dateRec));
                        CIRCULATION.utils.sendAjaxPost('Transactions/IsDatesFinalized', formData, 'json',
                        function successCallBack(data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                $("#trans-form").submit();
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function errorStatus(textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        sweetAlert("Oops...", startDate == null ? "Start Date Required!" : "Copies Required!", "error");
                    }
                });
            }
            else if (page == 'START-COPY') {
                //tr click
                $("tr[data-id]").click(function () {
                    var id = $(this).attr("data-id");
                    if (id) {
                        $("#open-enroll-form").attr("action", baseUrlPMD + "Transactions/EditStartCopy?g_fe=" + id).submit();
                    }
                });

                //start-copy
                $("#start-copy").click(function () {
                    var code = $("#sales_code").val(),
                        startDate = $("#sales_start_date").val(),
                        endDate = $("#sales_end_date").val(),
                        copyType = $("#sales_copy_type").val(),
                        copyGroup = $("#sales_copy_group").val(),
                        copyCode = $("#sales_copy_code").val(),
                        subscriberCode = $("#sales_sub_code").val(),
                        agentCode = $("#sales_agent_code").val(),
                        agentSlNo = $("#sales_agent_slno").val(),
                        copies = (parseInt($("#sales_copies").val()) || 0);
                  
                    if (code && startDate && copyType && copyGroup && copyCode && subscriberCode && agentCode && agentSlNo && copies > 0) {
                        swal({
                            title: "",
                            text: "Are you sure to start copy?",
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
                                CIRCULATION.utils.showLoader();
                                var formData = new FormData();
                                formData.append("sales_code", code);
                                formData.append("sales_start_date", startDate);
                                formData.append("sales_end_date", endDate);
                                formData.append("sales_copy_type", copyType);
                                formData.append("sales_copy_group", copyGroup);
                                formData.append("sales_copy_code", copyCode);
                                formData.append("sales_sub_code", subscriberCode);
                                formData.append("sales_agent_code", agentCode);
                                formData.append("sales_agent_slno", agentSlNo);
                                formData.append("sales_copies", copies);

                                CIRCULATION.utils.sendAjaxPost('Transactions/ApproveStartCopy', formData, 'json',
                                function successCallBack(data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 200) {
                                        $("#start-copy").attr("disabled", "disabled");
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
                    else {
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    }
                });

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
            }
            else if (page === 'SCHEME') {
                //toggle canvassed users
                $("#canvassed_by_type").change(function () {
                    var val = parseInt($(this).val());
                    var selectIndex = "1,2";
                    $("#can_text").text($("#canvassed_by_type option:selected").text());
                    $("#can_det_text").text($("#canvassed_by_type option:selected").text() + " Details");
                    $("#canvassed_by, .canvassed_by_clr, #canvassed_by_others").val('');
                    if (val) {
                        $(".canvassed_by_users").removeClass("hide");
                        $("#canvassed_by_others").addClass("hide");
                        $("#canvassed_by").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                        if (val == 17) {
                            selectIndex = "1,2";
                            $("#canvassed_by").removeAttr("data-criteria").attr("data-criteria", JSON.stringify([{ "column": "agent_unit", "input": "#unit_code", "select": "", "encode": "false", "required": "false" }]));
                        } else {
                            selectIndex = "3";
                            $("#canvassed_by").removeAttr("data-criteria");
                        }
                        $("#canvassed_by").removeAttr("data-target").attr("data-target", JSON.stringify([{ "selector": "#canvassed_name", "indexes": selectIndex }]));
                    } else {
                        $(".canvassed_by_users").addClass("hide");
                        $("#canvassed_by_others").removeClass("hide");
                    }
                });
                //Delete button click
                $('#scheme-table tbody').on('click', '.del-scheme', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         schCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/DeleteScheme/' + schCode, null, 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.remove();
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
                });
                //Pause button click
                $('#scheme-table tbody').on('click', '.pause-scheme', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         schCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to pause this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/PauseScheme/' + schCode, new FormData(), 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.find('.pause-scheme').append('<button data-id="' + schCode + '" class="btn btn-success restart-scheme"><i class="fa fa-retweet" aria-hidden="true" title="Restart"></i>&nbsp;Restart</button>');
                                    $currentRow.find('.pause-scheme').remove();
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
                });
                //Restart button click
                $('#scheme-table tbody').on('click', '.restart-scheme', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         schCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to restart this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/RestartScheme/' + schCode, new FormData(), 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.find('.restart-scheme').append('<button data-id="' + schCode + '" class="btn btn-danger pause-scheme"><i class="fa fa-pause" aria-hidden="true" title="Pause"></i>&nbsp;Pause</button>');
                                    $currentRow.find('.restart-scheme').remove();
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
                });
                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
            }
            else if (page === 'SCHEME-CREATE') {
                setInterval(function () {
                    $('.blink').fadeIn(500).fadeOut(800);
                }, 1000);
                $("#sch_start_date").datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                }).on('changeDate', function () {
                    showEndDate();
                });
                //toggle canvassed users
                $("#canvassed_by_type").change(function () {
                    var val = parseInt($(this).val());
                    var selectIndex = "1,2";
                    $("#can_text").text($("#canvassed_by_type option:selected").text());
                    $("#can_det_text").text($("#canvassed_by_type option:selected").text() + " Details");
                    $("#canvassed_by, .canvassed_by_clr, #canvassed_by_others").val('');
                    if (val) {
                        $(".canvassed_by_users").removeClass("hide");
                        $("#canvassed_by_others").addClass("hide");
                        $("#canvassed_by").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                        if (val == 17) {
                            selectIndex = "1,2";
                            $("#canvassed_by").removeAttr("data-criteria").attr("data-criteria", JSON.stringify([{ "column": "agent_unit", "input": "#unit_code", "select": "", "encode": "false", "required": "false" }]));
                        } else {
                            selectIndex = "3";
                            $("#canvassed_by").removeAttr("data-criteria");
                        }
                        $("#canvassed_by").removeAttr("data-target").attr("data-target", JSON.stringify([{ "selector": "#canvassed_name", "indexes": selectIndex }]));
                    } else {
                        $(".canvassed_by_users").addClass("hide");
                        $("#canvassed_by_others").removeClass("hide");
                    }
                });
                $("#scheme-save").click(function () {
                    var schemeForm = $("#scheme-create-form");
                    var isValid = CIRCULATION.utils.formValidation(schemeForm[0]);
                    var error = 0;
                    if ($("#canvassed_by_type").val() != '0' && !$("#canvassed_by_rec_sel").val()) {
                        $("#canvassed_by").addClass('haserror');
                        error++;
                    } else if ($("#canvassed_by_type").val() == '0' && !$("#canvassed_others").val()) {
                        $("#canvassed_others").addClass('haserror');
                        error++;
                    }
                    if (error == 0 && isValid) {
                        schemeForm.submit();
                    }
                });
            }
            else if (page === 'OTHER-RECEIPTS') {
                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
                //Delete button click
                $('#scheme-rcpt-table tbody').on('click', '.del-rcpt-scheme', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         schRcptCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/DeleteOtherReceipts/' + schRcptCode, null, 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.remove();
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
                });
            }
            else if (page === 'OTHER-RECEIPTS-CREATE') {
                $("#against_chqbounce").change(function () {
                    if (parseInt($(this).val()) === 1) {
                        $(".chq_rcpt").removeClass('hide');
                    } else {
                        $(".chq_rcpt").addClass('hide');
                    }
                });
                $("#pay_type").change(function () {
                    var payType = parseInt($(this).val());
                    if (payType === 1) {
                        $(".chq_det,.card_det,.bank_det").addClass('hide');
                    } else if (payType === 2) {
                        $(".card_det").addClass('hide');
                        $(".chq_det,.bank_det").removeClass('hide');
                    } else {
                        $(".chq_det").addClass('hide');
                        $(".card_det,.bank_det").removeClass('hide');
                    }
                });
                $("#payment_mode").change(function () {
                    var payMode = parseInt($(this).val());
                    if (payMode === 1) {
                        $(".prom_det").addClass('hide');
                    } else {
                        $(".prom_det").removeClass('hide');
                    }
                });
                $("#scheme-rcpt-save").click(function () {
                    var schemeRcptForm = $("#scheme-rcpt-form");
                    var isValid = CIRCULATION.utils.formValidation(schemeRcptForm[0]);
                    var error = 0,
                        payType = parseInt($("#pay_type").val()),
                        payMode = parseInt($("#payment_mode").val()),
                        amount =  parseInt($("#sch_amt").val()),
                            scubscRecord = $("#subscriber_rec_sel").val(),
                            isUpdate = $("#is_update").val()=='1'?true:false;
                    if(payType===2){
                        if(!$("#sch_chq_no").val()){
                            $("#sch_chq_no").addClass('haserror');
                            error++;
                        }
                        if(!$("#sch_chq_dte").val()){
                            $("#sch_chq_dte").addClass('haserror');
                            error++;
                        }
                        if(!$("#bank_rec_sel").val()){
                            $("#bank").addClass('haserror');
                            error++;
                        }
                    }else if(payType===3){
                        if (!$("#sch_card_no").val()) {
                            $("#sch_card_no").addClass('haserror');
                            error++;
                        }
                        if (!$("#sch_card_name").val()) {
                            $("#sch_card_name").addClass('haserror');
                            error++;
                        }
                        if(!$("#bank_rec_sel").val()){
                            $("#bank").addClass('haserror');
                            error++;
                        }
                    }
                    if(payMode === 2) {
                        if (!$("#promoter_rec_sel").val()) {
                            $("#promoter").addClass('haserror');
                            error++;
                        }
                        if (!$("#tmp_rcpt_rec_sel").val()) {
                            $("#tmp_rcpt_rec_sel").addClass('haserror');
                            error++;
                        }
                    }
                    if (amount<=0) {
                        $("#sch_amt").addClass('haserror');
                        error++;
                    }
                    if (!scubscRecord) {
                        $("#subscriber").addClass('haserror');
                        error++;
                    }
                    

                    if (error == 0 && isValid) {
                        scubscRecord = JSON.parse(decodeURIComponent(scubscRecord));
                        var schemeAmount = parseInt(scubscRecord["Pending Amount"]);
                        if (!isUpdate && amount > schemeAmount) {
                            swal({
                                title: "Are you sure?",
                                text: "You want to pay Rs." + amount + " against scheme amount of Rs." + schemeAmount,
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
                                    schemeRcptForm.submit();
                                }
                            });
                        } else {
                            schemeRcptForm.submit();
                        }
                    }
                });
            }
            else if (page === 'JOURNAL-FINALIZE') {
                var fromDate = moment('01-01-2018', "DD-MM-YYYY");
                var toDate = moment();
                var startDate = new Date(fromDate.toDate());
                var endDate = new Date(toDate.toDate());
                //date picker
                $('[data-mask]:not([readonly])').datepicker('remove');
                $("[data-mask]:not([readonly])").inputmask();
                $("#datepicker").datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    startDate: startDate,
                    endDate: endDate
                });

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
            }
            else if (page === 'JOURNAL-ENTRY') {
                //edit journal entry
                $(".pack-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("jeCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Transactions/EditJournalEntry', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //Update
                $('body').on('click', '#update-je-details', function () {
                    var jeCode = $("#p_je_code").val(),
                        jeAgentcode = $("#p_agent_rec_sel").val(),
                        jeAccntHead = $("#p_accounthead_rec_sel").val(),
                        jeAmount = $("#p_je_amount").val().trim(),
                        jeNarration = $("#p_je_Narration").val().toUpperCase(),
                        
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("jeCode", jeCode);
                    formData.append("jeAgentcode", jeAgentcode);
                    formData.append("jeAccntHead", jeAccntHead);
                    formData.append("jeAmount", jeAmount);
                    formData.append("jeNarration", jeNarration);
                    CIRCULATION.utils.sendAjaxPost('Transactions/UpdateJournalEntry', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#journal-entry-table tbody button[data-id='" + jeCode + "']").closest("tr");
                           
                            $tblRow.find("td.je-age-name").html($("#p_agent_rec_sel").val());
                            $tblRow.find("td.je-age-loc").html($("#p_agent_rec_sel").val());
                            $tblRow.find("td.je-age-phn").html($("#p_agent_rec_sel").val());
                            $tblRow.find("td.je-narration").html(jeNarration);
                            $('#common-modal').modal('toggle');
                            //sweetAlert("", data.text, "success");

                            location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
                //Delete button
                $('#journal-entry-table tbody').on('click', '.je-delete-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         journalCode = $currentRow.attr("data-id");
                    var formData = new FormData();
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete this.",
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
                            CIRCULATION.utils.showLoader();
                            //var formData = new FormData();
                            formData.append("journalCode", journalCode);
                            $.ajax({
                                type: 'POST',
                                url: baseUrlPMD + 'Transactions/DeleteJournalEntry',
                                data: formData,
                                dataType: 'json',
                                processData: false,  // tell jQuery not to process the data
                                contentType: false, // tell jQuery not to set contentType
                                success: function (data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 200) {
                                        $currentRow.remove();
                                        sweetAlert("", data.text, "success");
                                    } else {
                                        sweetAlert("Oops...", data.text, "error");
                                    }
                                },
                                error: function (textStatus, errorThrown) {
                                    CIRCULATION.utils.hideLoader();
                                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                }
                            });
                        }
                    });
                });

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
            }
            else if (page === 'SPONSOR') {
                //adding date to list
                $("#add_copies_to_list").click(function () {
                    var totalCopies = parseInt($("#spons_copies").val()),
                        copyDate = $("#spons_list_date").val(),
                        copy = parseInt($("#spons_list_copy").val()),
                        usedCopy = 0,
                        isDateInList = false;

                    if (totalCopies > 0 && copyDate && copy) {
                        $("#spons-copy-table tbody tr").each(function () {
                            var copyRec = $(this).find('.sponsor_copies_rec').val();
                            if (copyRec) {
                                rec = copyRec.split("#SEP#");
                                usedCopy += parseInt(rec[1]);
                                if (copyDate == rec[0]) isDateInList = true;
                            }
                        });

                        if ((usedCopy + copy) <= totalCopies && isDateInList === false) {
                            $("#spons-copy-table tbody tr.no-records").remove();
                            var tmpl = '<tr>'
                                            + '<td>' + copyDate + '<input class="sponsor_copies_rec" name="sponsor_copies_rec[]" type="hidden" value="' + copyDate + '#SEP#' + copy + '" /></td>'
                                            + '<td align="right">' + copy + '</td>'
                                            + '<td align="center"><button class="btn btn-danger delete-from-list" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'
                                        + '</tr>';
                            $("#spons-copy-table tbody").append(tmpl);
                            $("#spons_list_copy").val('');
                        }
                        else {
                            sweetAlert("", isDateInList === true ? "Date already in list!" : "Exceed Copy Count!", "error");
                        }
                    }
                    else {
                        var message = [];
                        if (!totalCopies) { message.push("No of Copies"); }
                        if (!copyDate) { message.push("Date"); }
                        if (!copy) { message.push("Copies"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });

                //calculate
                $(".calculate-copies").on('change keydown paste input', function () {
                    var dealAmount = (parseFloat($("#spons_deal_amt").val()) || 0),
                        ratePerCopy = (parseFloat($("#spons_rate_per_copy").val()) || 0),
                        copies = Math.floor(dealAmount / ratePerCopy);
                    $("#spons_copies").val(copies)
                    $("#spons-copy-table tbody").html('<tr class="no-records"><td colspan="3">No Records Found!</td></tr>');
                });

                //Delete copy from list
                $('body').on('click', '.delete-from-list', function () {
                    $(this).closest("tr").remove();
                    if ($("#spons-copy-table tbody tr").length === 0) {
                        $("#spons-copy-table tbody").html('<tr class="no-records"><td colspan="3">No Records Found!</td></tr>');
                    }
                });

                //trigger-upsert
                $(".upsert-sponsor").click(function () {
                    CIRCULATION.utils.showLoader();
                    if ($("#spons-copy-table tbody tr").not('.no-records').length) {
                        var dateRec = [],
                            usedCopy = 0,
                            totalCopies = parseInt($("#spons_copies").val()),
                            incAmount = (parseFloat($("#spons_inc_amt").val()) || 0),
                            incPaid = (parseFloat($("#spons_inc_paid").val()) || 0);

                        $("#spons-copy-table tbody tr").each(function () {
                            var copyRec = $(this).find('.sponsor_copies_rec').val();
                            if (copyRec) {
                                var rec = copyRec.split("#SEP#");
                                dateRec.push(rec[0]);
                                usedCopy += parseInt(rec[1]);
                            }
                        });

                        if (usedCopy == totalCopies && incAmount >= incPaid) {
                            var formData = new FormData();
                            formData.append("date_rec", JSON.stringify(dateRec));

                            CIRCULATION.utils.sendAjaxPost('Transactions/IsDatesFinalized', formData, 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $("#trans-form").submit();
                                } else {
                                    sweetAlert("Oops...", data.text, "error");
                                }
                            },
                            function errorStatus(textStatus, errorThrown) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                            });
                        }
                        else {
                            CIRCULATION.utils.hideLoader();
                            if (incAmount < incPaid) {
                                sweetAlert("Oops...", "Incentive Paid cannot be greater than Incentive Amount!", "error");
                            }
                            else {
                                sweetAlert("Oops...", "Only " + usedCopy + " copies added to list!", "error");
                            }
                        }
                    }
                    else {
                        //if no sponsor dates added to list
                        //$("#trans-form").submit();
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", "Please add copies to list!", "error");
                    }
                });

                //toggle canvassed users
                $("#canvassed_by_type").change(function () {
                    var val = parseInt($(this).val());
                    $("#canvassed_by, .canvassed_by_clr, #canvassed_by_others").val('');
                    $(".can-agent-details").addClass('hide');
                    if (val === 17) $(".can-agent-details").removeClass('hide');
                    if (val) {
                        $("#canvassed_by_users").removeClass("hide");
                        $("#canvassed_by_others").addClass("hide");
                        $("#canvassed_by").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                    } else {
                        $("#canvassed_by_users").addClass("hide");
                        $("#canvassed_by_others").removeClass("hide");
                    }
                });

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });

                //tr click
                $("tr[data-id]").click(function () {
                    var id = $(this).attr("data-id");
                    if (id) {
                        $("#open-trans-form").attr("action", baseUrlPMD + "Transactions/EditSponsor?g_fe=" + id).submit();
                    }
                });
            }
            else if (page === 'ENTE-KAUMUDI-TRANS') {
                //toggle canvassed users
                $("#canvassed_by_type").change(function () {
                    var val = parseInt($(this).val());
                    $("#canvassed_by, .canvassed_by_clr, #canvassed_by_others").val('');
                    $(".can-agent-details").addClass('hide');
                    if (val === 17) $(".can-agent-details").removeClass('hide');
                    if (val) {
                        $("#canvassed_by_users").removeClass("hide");
                        $("#canvassed_by_others").addClass("hide");
                        $("#canvassed_by").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                    } else {
                        $("#canvassed_by_users").addClass("hide");
                        $("#canvassed_by_others").removeClass("hide");
                    }
                });

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });

                //tr click
                $("tr[data-id]").click(function () {
                    var id = $(this).attr("data-id");
                    if (id) {
                        $("#open-trans-form").attr("action", baseUrlPMD + "Transactions/EditEnteKaumudi?g_fe=" + id).submit();
                    }
                });

                //calculate
                $(".calculate-copies").on('change keydown paste input', function () {
                    var dealAmount = (parseFloat($("#ek_deal_amount").val()) || 0),
                        ratePerCopy = (parseFloat($("#ek_rate").val()) || 0),
                        copies = Math.floor(dealAmount / ratePerCopy);
                    $("#ek_copies").val(copies)
                    $("#ek-copy-table tbody").html('<tr class="no-records"><td colspan="7">No Records Found!</td></tr>');
                });

                //add to list
                $("#add_to_list").click(function () {
                    var rec = ($("#subscriber_rec_sel").val() || null),
                        totalCopies = parseInt($("#ek_copies").val()),
                        copy = parseInt($("#copies").val()),
                        startDate = $("#start_date").val(),
                        $tbl = $("#ek-copy-table tbody"),
                        usedCopy = 0,
                        isSubscriberExists = false;
                    if (rec && copy && startDate && totalCopies) {

                        var subRec = JSON.parse(decodeURIComponent(rec)),
                            subCode = subRec['Code'],
                            subName = subRec['Name'],
                            subAddress = subRec['Address'],
                            agentCode = subRec['AgentCode'],
                            agentSlNo = subRec['AgentSlNo'],
                            agentName = subRec['Agent Name'],
                            agentLocation = subRec['Agent Location'];

                        $tbl.find("tr").each(function () {
                            var copyRec = $(this).find('.ek_copies_rec').val();
                            if (copyRec) {
                                trRec = JSON.parse(decodeURIComponent(copyRec));
                                usedCopy += parseInt(trRec['Copies']);
                                if (subCode == trRec['SubCode']) isSubscriberExists = true;
                            }
                        });

                        if ((usedCopy + copy) <= totalCopies && isSubscriberExists === false) {

                            if (subCode && subName && agentCode && agentSlNo) {

                                var dataRec = {
                                    "SubCode": subCode,
                                    "AgentCode": agentCode,
                                    "AgentSlNo": agentSlNo,
                                    "Copies": copy,
                                    "StartDate": startDate
                                };

                                var tmpl = '<tr>'
                                               + '<td>' + subName + ' - ' + subAddress + '<input value="' + encodeURIComponent(JSON.stringify(dataRec)) + '" type="hidden" class="ek_copies_rec" name="ek_copies_rec[]" /></td>'
                                               + '<td>' + agentCode + ' - ' + agentName + ', ' + agentLocation + '</td>'
                                               + '<td>' + startDate + '</td>'
                                               + '<td align="right">' + copy + '</td>'
                                               + '<td></td>'
                                               + '<td></td>'
                                               + '<td align="center"><button class="btn btn-danger delete-from-list" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'
                                           + '</tr>';

                                $tbl.find('tr.no-records').remove();
                                $tbl.append(tmpl);
                                $("#subscriber, .subscriber_clr, #copies").val('');
                            }
                            else {
                                var message = [];
                                if (!subCode || !subName) { message.push("Subscriber"); }
                                if (!agentCode || !agentSlNo) { message.push(" Agent"); }
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                            }
                        }
                        else {
                            $("#subscriber, .subscriber_clr, #copies").val('');
                            sweetAlert("", isSubscriberExists === true ? "Subscriber " + subName + " already in list!" : "Exceed Copy Count!", "error");
                        }
                    }
                    else {
                        var message = [];                        
                        if (!totalCopies) { message.push("No of Copies"); }
                        if (!rec) { message.push(" Subscriber"); }
                        if (!copy) { message.push(" Copies"); }
                        if (!startDate) { message.push(" Starting Date"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });

                //Delete copy from list
                $('body').on('click', '.delete-from-list', function () {
                    $(this).closest("tr").remove();
                    if ($("#ek-copy-table tbody tr").length === 0) {
                        $("#ek-copy-table tbody").html('<tr class="no-records"><td colspan="7">No Records Found!</td></tr>');
                    }
                });

                //trigger-upsert
                $(".upsert-ente-kaumudi").click(function () {
                    CIRCULATION.utils.showLoader();
                    if ($("#ek-copy-table tbody tr").not('.no-records').length) {
                        var dateRec = [],
                            usedCopy = 0,
                            totalCopies = parseInt($("#ek_copies").val()),
                            incAmount = (parseFloat($("#ek_inc_amt").val()) || 0),
                            incPaid = (parseFloat($("#ek_inc_paid").val()) || 0);

                        $("#ek-copy-table tbody tr").each(function () {
                            var copyRec = $(this).find('.ek_copies_rec').val();
                            if (copyRec) {
                                trRec = JSON.parse(decodeURIComponent(copyRec));
                                usedCopy += parseInt(trRec['Copies']);                               
                                dateRec.push(trRec['StartDate']);
                            }
                        });

                        if (usedCopy == totalCopies && incAmount >= incPaid) {
                            var formData = new FormData();
                            formData.append("date_rec", JSON.stringify(dateRec));

                            CIRCULATION.utils.sendAjaxPost('Transactions/IsDatesFinalized', formData, 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $("#trans-form").submit();
                                } else {
                                    sweetAlert("Oops...", data.text, "error");
                                }
                            },
                            function errorStatus(textStatus, errorThrown) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                            });
                        }
                        else {
                            CIRCULATION.utils.hideLoader();
                            if (incAmount < incPaid) {
                                sweetAlert("Oops...", "Incentive Paid cannot be greater than Incentive Amount!", "error");
                            }
                            else {
                                sweetAlert("Oops...", "Only " + usedCopy + " copies added to list!", "error");
                            }
                        }
                    }
                    else {
                        //if no sponsor dates added to list
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", "Please add copies to list!", "error");
                    }
                });

                //select all
                $(".select-all").click(function () {
                    $(".child-chkbx").prop('checked', $(this).prop('checked'));
                });

                //pause
                $(".manage-status").click(function () {
                    var newStatus = parseInt($(this).attr("data-initstatus")),
                        initText = $(this).attr("data-text"),
                        hasError   = false,
                        i = 0,
                        records = {};

                    $("#ek-copy-table tbody tr td").find("input:checkbox:checked").each(function () {
                        var $this = $(this),
                            currentStatus = parseInt($this.attr("data-status"));
                        if (newStatus === currentStatus) hasError = true;
                        records[i] = {
                            "agent_code": $this.attr("data-agentcode"),
                            "agent_slno": $this.attr("data-agentslno"),
                            "subscriber_code": $this.attr("data-subscribercode"),
                            "copy_type": $("#copytype").val(),
                            "scheme_code": $("#ek_slno").val(),
                            "start_date": $this.attr("data-startdate"),
                            "copies": $this.attr("data-copies"),
                            "rate_per_copy": $("#ek_rate").val(),
                            "current_status": currentStatus
                        }
                    });

                    if (hasError === true) {
                        sweetAlert("Oops...", "Some Subscribers are already " + initText + "!", "error");
                    }
                    else {
                        var rec = JSON.stringify(records);
                        if (rec.length) {
                            var formData = new FormData();
                            formData.append("records", rec);
                            formData.append("new_status", newStatus);
                            CIRCULATION.utils.sendAjaxPost('Transactions/ManageEnteKaumudiStatus', formData, 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {                                   
                                    $("#ek-copy-table tbody tr td").find("input:checkbox:checked").each(function () {
                                        var $this       = $(this),
                                            currentdate = new Date(),
                                            dateRec     = currentdate.getDate() + "-" + (currentdate.getMonth() + 1) + "-" + currentdate.getFullYear();
                                        $this.attr("data-status", newStatus);
                                        $this.closest("tr").find("td.status-text").html(initText);
                                        $this.closest("tr").find("td.status-date").html(dateRec);
                                    });
                                } else {
                                    sweetAlert("Oops...", data.text, "error");
                                }
                            },
                            function errorStatus(textStatus, errorThrown) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                            });
                        }
                        else {
                            sweetAlert("Oops...", "Please select subscribers to " + initText + "!", "error");
                        }
                    }
                });
            }
            else if (page === 'INITIATE-AMENDMENTS') {
                $("#initiate_amendments").click(function () {
                    var incEK = parseInt($("#include_ek").val()),
                        msg   = incEK == 1 ? ", Including EnteKaumudi" : ", Excluding EnteKaumudi";
                    swal({
                        title: "",
                        text: "Are you sure to initiate amendments on \n" + $("#next_finalize_date").val() + msg + "?",
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
                            CIRCULATION.utils.showLoader();
                            $("#trans-form").submit();
                        }
                    });
                });
            }
            else if (page === 'PACKERS-DIARY') {
                $("#save-btn").click(function () {
                    var packersForm = $("#packers-form");
                    var packersOptn = $("#packers_optn").val();
                    var isValid = CIRCULATION.utils.formValidation(packersForm[0]);
                    var error = 0;
                    if (packersOptn == '0') {
                        if (!$("#agent").val()) {
                            $("#agent").addClass('haserror');
                            error++;
                        }
                        if (!$("#subscriber").val()) {
                            $("#subscriber").addClass('haserror');
                            error++;
                        }
                    } else if (packersOptn == '1') {
                        if (!$("#sub_subscriber").val()) {
                            $("#sub_subscriber").addClass('haserror');
                            error++;
                        }
                    }

                    if (error == 0 && isValid) {
                        packersForm.submit();
                    }
                });


                $("#packers_optn").change(function () {
                    var select = $(this).val();
                    if (select == 1) {
                        $(".sub_sel").removeClass('hide');
                        $(".agent_sel").addClass('hide');
                    } else {
                        $(".sub_sel").addClass('hide');
                        $(".agent_sel").removeClass('hide');
                    }
                });
                $("body").on("change", "#p_packers_optn", function () {
                    var packSelect = $(this).val();
                    if (packSelect == 1) {
                        $(".p_sub_sel").removeClass('hide');
                        $(".p_agent_sel").addClass('hide');
                    } else {
                        $(".p_sub_sel").addClass('hide');
                        $(".p_agent_sel").removeClass('hide');
                    }
                });
                $(".select_plus").change(function () {
                    var copies = $(this).val();
                    if (copies) {
                        $("#copy").removeAttr("readonly");
                    }
                });
                $("body").on("change", "#p_select_plus", function () {
                    var editCopies = $(this).val();
                    if (editCopies) {
                        $("#p_copy").removeAttr("readonly");
                    }
                });
                //edit
                $(".pack-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("packCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Transactions/ViewPackersDiary', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //update
                $('body').on('click', '#update-pack-details', function () {
                    var diaryCode = $("#p_pack_code").val().trim(),
                        diaryPrdt = $("#p_product_rec_sel").val().trim(),
                        diaryAgent = $("#p_agent_rec_sel").val().trim(),
                        diarySub = $("#p_subscriber_rec_sel").val().trim(),
                        diaryOptn = $("#p_packers_optn").val().trim(),
                        diaryPlus = $("#p_select_plus").val().trim(),
                        diaryReason = $("#p_packet_reason_rec_sel").val().trim()
                    diaryRemark = $("#p_remark").val().trim().toUpperCase(),
                    diaryCopy = $("#p_copy").val().trim(),
                    diaryStatus = $("#p_pack_status").val().trim(),
                    formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("diaryCode", diaryCode);
                    formData.append("diaryPrdt", diaryPrdt);
                    formData.append("diaryAgent", diaryAgent);
                    formData.append("diarySub", diarySub);
                    formData.append("diaryOptn", diaryOptn);
                    formData.append("diaryPlus", diaryPlus);
                    formData.append("diaryRemark", diaryRemark);
                    formData.append("diaryCopy", diaryCopy);
                    formData.append("diaryReason", diaryReason);
                    formData.append("diaryStatus", diaryStatus);
                    var packersForm = $("#p-packers-form");
                    var packersOptn = $("#p_packers_optn").val();
                    var isValid = CIRCULATION.utils.formValidation(packersForm[0]);
                    var error = 0;
                    if (packersOptn == '0') {
                        if (!$("#p_agent").val()) {
                            $("#p_agent").addClass('haserror');
                            error++;
                        }
                        if (!$("#p_subscriber").val()) {
                            $("#p_subscriber").addClass('haserror');
                            error++;
                        }
                    } else if (packersOptn == '1') {
                        if (!$("#p_sub_subscriber").val()) {
                            $("#p_sub_subscriber").addClass('haserror');
                            error++;
                        }
                    }

                    if (error == 0 && isValid) {
                        packersForm.submit();
                    }

                    CIRCULATION.utils.sendAjaxPost('Transactions/UpdatePackersDiary', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            //var $tblRow = $("#packets-table tbody button[data-id='" + diaryCode + "']").closest("tr");
                            //$tblRow.find("td.diary-age-sub").html(diaryAgent);
                            //$tblRow.find("td.diary-sub-code").html(diarySub);
                            //$tblRow.find("td.diary-plus").html(diaryPlus);
                            //$tblRow.find("td.diary-remark").html(diaryRemark);
                            //$tblRow.find("td.diary-copy").html(diaryCopy);
                            //$('#common-modal').modal('toggle');
                            //sweetAlert("", data.text, "success");
                            location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
            }
            else if (page === 'FREE-COPY') {
                //Pause button click
                $('#free-copy-table tbody').on('click', '.pause-free-copy', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         freCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to pause this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/PauseFreeCopy/' + freCode, new FormData(), 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.find('.pause-free-copy').addClass("hide");
                                    $currentRow.find('.restart-free-copy').removeClass("hide");
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
                });
                //Restart button click
                $('#free-copy-table tbody').on('click', '.restart-free-copy', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         frCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to restart this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/RestartFreeCopy/' + frCode, new FormData(), 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.find('.restart-free-copy').addClass("hide");
                                    $currentRow.find('.pause-free-copy').removeClass("hide");
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
                });
                //stop button
                $('#free-copy-table tbody').on('click', '.stop-free-copy', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         frCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to stop this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/StopFreeCopy/' + frCode, new FormData(), 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.find('.pause-free-copy, .restart-free-copy,.stop-free-copy').addClass("hide");
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
                });
                //Delete button click
                $('#free-copy-table tbody').on('click', '.del-free-copy', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         fcdltCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/DeleteFreeCopy/' + fcdltCode, null, 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.remove();
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
                });
                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
            }
            else if (page === 'FREE-COPY-CREATE') {
                $(".end-flag").change(function () {
                    var endFlag = $("#endflag").val();
                    if (endFlag == 1) {
                        $("#last_date").removeClass('hide');
                    } else {
                        $("#last_date").addClass('hide');
                    }
                });
                $("#save-btn").click(function () {
                    var freeCopyForm = $("#free-copy-form");
                    var isValid = CIRCULATION.utils.formValidation(freeCopyForm[0]);
                    var error = 0;
                    var copy = parseInt($("#free_copy").val());
                    if (!copy > 0) {
                        $("#free_copy").addClass('haserror');
                        error++;
                    }
                    var formData = new FormData();
                    formData.append("date_rec", JSON.stringify([$("#start_dte").val()]));
                    CIRCULATION.utils.showLoader();
                    CIRCULATION.utils.sendAjaxPost('Transactions/IsDatesFinalized', formData, 'json',
                    function successCallBack(data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            $("#free-copy-form").submit();
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function errorStatus(textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });

            }
            else if (page === 'WEEKDAY-AMENDMENTS') {
                $("#wa_end_flag").change(function () {
                    $("#last_date").addClass("hide");
                    $("#wa_start_date").removeAttr("data-compare");
                    $("#wa_end_date").removeAttr("required");
                    if ($(this).val() == 1) {
                        $("#last_date").removeClass("hide");
                        $("#wa_start_date").attr("data-compare", "#wa_end_date");
                        $("#wa_end_date").attr("required", true);
                    }
                });

                //tr click
                $("tr[data-id]").click(function () {
                    var id = $(this).attr("data-id");
                    if (id) {
                        $("#open-trans-form").attr("action", baseUrlPMD + "Transactions/EditWeekdayAmendments?g_fe=" + id).submit();
                    }
                });

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });

                //trigger-upsert
                $("#upsert-records").click(function () {
                    var dateRec = [],
                        startDate = ($("#wa_start_date").val() || null),
                        copies = parseInt($("#wa_copies").val());

                    if (copies && startDate) {
                        CIRCULATION.utils.showLoader();
                        dateRec.push(startDate);
                        var formData = new FormData();
                        formData.append("date_rec", JSON.stringify(dateRec));
                        CIRCULATION.utils.sendAjaxPost('Transactions/IsDatesFinalized', formData, 'json',
                        function successCallBack(data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                $("#trans-form").submit();
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function errorStatus(textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        sweetAlert("Oops...", startDate == null ? "Start Date Required!" : "Copies Required!", "error");
                    }
                });

                //update-status
                $("#update_wa_status").click(function () {
                    var formData = new FormData(),
                        status = ($("#wa_status").val() || null);
                    if (status >= 0) {
                        CIRCULATION.utils.showLoader();
                        formData.append("wa_code", $("#wa_code").val());
                        formData.append("wa_status", status);
                        CIRCULATION.utils.sendAjaxPost('Transactions/ManageWeekdayAmendmentsStatus', formData, 'json',
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
                    } else {
                        sweetAlert("Oops...", "Invalid Status!", "error");
                    }
                });
            }
            else if (page === 'OTHER-RECEIPTS-PDC') {
                //Delete button click
                $('#other-rcpt-pdc tbody').on('click', '.del-rcpt-pdc', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         schRcptCode = $(this).attr("data-id");
                    swal({
                        title: "Are you sure?",
                        text: "You want to delete this.",
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
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxGet('Transactions/DeleteOtherReceiptsPDC/' + schRcptCode, null, 'json',
                            function successCallBack(data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.remove();
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
                });
            }
            else if (page === 'OTHER-RECEIPTS-PDC-CREATE') {
                $("#payment_mode").change(function () {
                    var paymentMode = parseInt($("#payment_mode").val());
                    if (paymentMode == 2) {
                        $(".prom_det").removeClass('hide');
                    } else {
                        $(".prom_det").addClass('hide');
                    }
                });
                $("#against_chqbounce").change(function () {
                    var chequeBounce = parseInt($(this).val());
                    if (chequeBounce == 1) {
                        $(".chq_rcpt").removeClass('hide');
                    } else {
                        $(".chq_rcpt").addClass('hide');
                    }
                });
            }
            else if (page === 'RECEIPTS') {
                //trigger-upsert
                $("#upsert-records").click(function () {
                    CIRCULATION.utils.showLoader();
                    $("#trans_records").val('');
                    var isOtherPdtsPending = false, //adjustments allowed to daily if all other products target is 0
                        isDailyAdjusted = false,
                        receiptAmount = (parseFloat($("#amount").val()) || 0),
                        totalPayments = 0,
                        receiptTrans = {},
                        i = 0;

                    if (receiptAmount > 0) {

                        $("#outstanding_tbl tbody tr").each(function () {
                            var $thisTr  = $(this),
                                product  = $thisTr.attr("data-product"),
                                target   = (parseFloat($thisTr.find("td.target").text()) || 0),
                                payments = (parseFloat($thisTr.find("input.payments").val()) || 0);
                                totalPayments += payments;
                            if (product != 'DLY' && (target - payments) > 0) {
                                isOtherPdtsPending = true;
                            }
                            if (product === 'DLY' && payments > 0) isDailyAdjusted = true;

                            if(payments > 0) { 
                                receiptTrans[i] = {
                                    "amount" : payments
                                }
                                i++;
                            }
                        });

                        if (totalPayments === receiptAmount) {
                            if (isOtherPdtsPending === true && isDailyAdjusted === true) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("", "Please clear other produts target before adjusting Daily!", "error");
                            }
                            else {
                                var transRec = JSON.stringify(receiptTrans);
                                if (transRec.length) {
                                    $("#trans_records").val(JSON.stringify(receiptTrans));
                                    //$("#trans-form").submit();
                                }
                                else {
                                    CIRCULATION.utils.hideLoader();
                                    sweetAlert("", "Generating transaction entries failed!", "error");
                                }
                            }
                        }
                        else {
                            CIRCULATION.utils.hideLoader();
                            var balance = (receiptAmount - totalPayments).toFixed(2);
                            sweetAlert("", balance > 0 ? "Rs " + balance + " remaning to adjust!" : "Rs " + Math.abs(balance) + " exceeds the receipt amount!", "error");
                        }
                    }
                    else {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("", "Receipt amount cannot be empty!", "error");
                    }
                });

                //calculate-balance
                $(".payments").on('change keydown paste input', function () {
                    var $thisTr = $(this).closest("tr"),
                        outstanding = (parseFloat($thisTr.find("td.outstanding").text()) || 0), //outstanding or security deposit
                        payment = (parseFloat($thisTr.find("input.payments").val()) || 0);
                    $thisTr.find("td.balance").html((outstanding - payment).toFixed(2));
                });

                //toggle pay type
                $("#pay_type").change(function () {
                    var val = parseInt($(this).val());
                    $("#cheque_number,#cheque_date,#bank,.bank_clr").val('');
                    $("#cheque_type").val('0');
                    $("#cheque_number,#cheque_date,#bank,#cheque_type").attr("readonly", true);
                    $("#bank,#bank_search,#cheque_type").addClass("disable-input");
                    $("#cheque_date").datepicker("destroy");
                    if (val == 2 || val == 4) { //cheque and DD
                        $("#cheque_number,#cheque_date,#bank,#cheque_type").attr("readonly", false);
                        $("#bank,#bank_search,#cheque_type").removeClass("disable-input");
                        $("#cheque_date").datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,toggleActive: true});
                    }
                });

                //toggle pay type
                $("#paid_by").change(function () {
                    var val = parseInt($(this).val());
                    $("#promoter,.promoter_clr,#temporary_receipt,.temporary_receipt_clr").val('');
                    $("#promoter,#temporary_receipt").attr("readonly", true).addClass("disable-input");
                    $("#promoter_search,#temporary_receipt_search").addClass("disable-input");
                    if (val == 2) { //promoter
                        $("#promoter,#temporary_receipt").attr("readonly", false).removeClass("disable-input");
                        $("#promoter_search,#temporary_receipt_search").removeClass("disable-input");
                    }
                });               

                $('.table-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });

                $('.bills-results').not('.no-data-tbl').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }],
                    "bFilter": false,
                    "ordering": false
                });

                //tr click
                $("tr[data-id]").click(function () {
                    var id = $(this).attr("data-id");
                    if (id) {
                        $("#open-trans-form").attr("action", baseUrlPMD + "Transactions/EditSponsor?g_fe=" + id).submit();
                    }
                });                
            }

        }
    }
})();
