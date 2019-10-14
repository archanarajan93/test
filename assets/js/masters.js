var CIRCULATION = CIRCULATION || {};
CIRCULATION.masters = (function () {
    /***************
    *Private Region*
    ****************/

    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            new HelpController({
                fields: '#promoter_acm_code,#ct_group,#shakha_union,#dr_route_code,#region,#p_ct_group,#p_shakha_union,#region,#edt_region,#agent_product,#agent_region,#agent_acm,#agent_promoter,#agent_edition,#agent_route,#agent_dropping_point,#agent_union,#agent_shakha,#agent_bureau,.agent,#p_drop_route_code,#sub_edition,#sub_agent,#p_sub_edition,#p_sub_agent',
                fieldBtns: '#promoter_acm_code_search,#ct_group_search,#shakha_union_search,#dr_route_code_search,#region_search,#p_ct_group_search,#p_shakha_union_search,#region_search,#edt_region_search,#agent_product_search,#agent_region_search,#agent_acm_search,#agent_promoter_search,#agent_edition_search,#agent_route_search,#agent_dropping_point_search,#agent_union_search,#agent_shakha_search,#agent_bureau_search,.agent_search,#p_drop_route_code_search,#sub_edition_search,#sub_agent_search,#p_sub_edition_search,#p_sub_agent_search'
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
            $('.table-results').not('.no-data-tbl').DataTable({
                "paging": false,
                "info": false,
                "aaSorting": [],
                "scrollY": "50vh",
                "scrollX": true,
                "scrollCollapse": true,
                "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
            });
        
            //user master page start here
            if (page == 'USER-MASTER') {
                //check username availability
                $('body').on("click", "#check-availability", function () {
                    CIRCULATION.utils.showLoader();
                    var login_name = $("#user_login_name").val();
                    formData = new FormData();
                    formData.append("login_name", login_name);                                 
                    CIRCULATION.utils.sendAjaxPost('Masters/LoginNameAvailable', formData, 'json',
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
                });

                //select-all
                $('body').on('click', '#select-all-product', function() {
                    $("#product-access-tbl tbody").find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
                });

                $('body').on('click', '#select-all-unit', function () {
                    $("#unit-access-tbl tbody").find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
                });

                //clear on input change
                $('body').on('change paste keyup cut', '#employee_name', function () {
                    $("#employee_id, #employee_department, #employee_designation, .employee_name_clr").val('');
                });

                //for clicking 'user-search' page parent table row
                $('.show-user-details td').click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();                    
                    var $currentRow = $(this).closest('tr'),
                        formData = new FormData();
                        formData.append("user_id", $currentRow.attr("data-user"));

                    CIRCULATION.utils.sendAjaxPost('Masters/ShowUserDetails', formData, 'html',
                    function successCallBack(data) {
                        $('#common-modal-body').html(data);
                    },
                    function errorStatus(textStatus, errorThrown) {
                        $("#common-modal").modal('toggle');
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });

                //update user details
                $('body').on('click', '#update-user-details', function () {
                    var uId            = $("#user_id").val().trim(),
                        uLoginName     = $("#user_login_name").val().trim(),
                        uLoginPass     = $("#user_login_password").val().trim(),
                        uUnitCode      = $("#user_unit_code").val().trim(),
                        uEmployeeData  = $("#employee_name_rec_sel").val().trim(),
                        unitPermission = $("#unit-access-tbl tbody").find('input[type="checkbox"]:checked').length,
                        prodPermission = $("#product-access-tbl tbody").find('input[type="checkbox"]:checked').length,
                        formData       = new FormData();;
                    if (uId && uLoginName && uLoginPass && uUnitCode && uEmployeeData && unitPermission && prodPermission) {
                        CIRCULATION.utils.showLoader();
                        formData.append("user_id", uId);
                        formData.append("user_login_name", uLoginName);
                        formData.append("user_login_password", uLoginPass);
                        formData.append("user_unit_code", uUnitCode);
                        formData.append("employee_name_rec_sel", uEmployeeData);
                        
                        var uAccess = {}, pAccess = {}, i = 0;
                        $("#unit-access-tbl tbody").find('input[type="checkbox"]:checked').each(function () {                      
                            uAccess[i] = { "user_id": uId, "unit_code": $(this).val() };
                            i++;
                        });

                        var i = 0;
                        $("#product-access-tbl tbody").find('input[type="checkbox"]:checked').each(function () {
                            pAccess[i] = { "user_id": uId, "product_code": $(this).val() };
                            i++;
                        });
                        
                        formData.append("unit_access", JSON.stringify(uAccess));
                        formData.append("product_access", JSON.stringify(pAccess));

                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateUser', formData, 'json',
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
                    else {
                        var message = [];
                        if (!uLoginName) { message.push("Login Name"); }
                        if (!uLoginPass) { message.push("Password"); }
                        if (!uUnitCode) { message.push("Unit"); }
                        if (!uEmployeeData) { message.push("Employee Details"); }
                        if (unitPermission <= 0) { message.push("Unit Permission"); }
                        if (prodPermission <= 0) { message.push("Product Permission"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });  
            }            
           //Product groupmaster page start here
            else if (page == 'PRODUCT-GROUP') {
                $(".select2").select2();
                //edit button click
                $('#group-table tbody').on('click', '.edit-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $('#group-table tbody tr[data-save="true"]').attr('data-save', 'false').find('.form-control').prop('disabled', true);
                    $currentRow.attr('data-save', true);
                    $currentRow.find('.form-control').prop('disabled', false);
                });
                //save button click
                $('#group-table tbody').on('click', '.save-btn', function (e) {

                    var errCount =0, $currentRow = $(this).closest('tr'),
                        group_name = $.trim($currentRow.find('.group_name').val()),
                        group_prdts = $.trim($currentRow.find('.group_pdt').val()),
                        group_code = $.trim($currentRow.attr("data-grpid"));

                    if (!group_name) {
                        $currentRow.find('.group_name').addClass('haserror');
                        errCount++;
                    }
                    if (!group_prdts) {
                        $currentRow.find('.select2').addClass('haserror');
                        errCount++;
                    }
                    if (errCount > 0) return false;
                    var formData = new FormData();
                    formData.append("group_code", group_code);
                    formData.append("group_name", group_name);
                    formData.append("group_prdts", group_prdts);
                    if ($.trim(group_code) != '') {
                        CIRCULATION.utils.showLoader();
                        $.ajax({
                            type: 'POST',
                            url: baseUrlPMD + 'Masters/UpdateProductGroups',
                            data: formData,
                            dataType: 'json',
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,   // tell jQuery not to set contentType
                            success: function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    sweetAlert("", data.text, "success");
                                    $currentRow.find('.demo-text').text(group_prdts);
                                    $currentRow.attr('data-save', false);
                                    $currentRow.find('.form-control').prop('disabled', true);
                                } else {
                                    sweetAlert("Oops...", data.text, "error");
                                }
                            },
                            error: function (textStatus, errorThrown) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                            }
                        });
                    } else {
                        sweetAlert("Oops...", "Group is mandatory!", "error");
                    }
                });
                //cancel button click 
                $('#group-table tbody').on('click', '.cancel-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $currentRow.attr('data-save', false);
                    $currentRow.find('.form-control').prop('disabled', true);
                });
                //Delete button click
                $('#group-table tbody').on('click', '.del-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         group_code = $currentRow.attr("data-grpid");

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
                            var formData = new FormData();
                            formData.append("group_code", group_code);
                            $.ajax({
                                type: 'POST',
                                url: baseUrlPMD + 'Masters/DeleteProductGroup',
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
            }
            //product master page start here
            else if (page == 'PRODUCT-MASTER') {
                //edit button click
                $('#product-table tbody').on('click', '.edit-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $('#product-table tbody tr[data-save="true"]').attr('data-save', 'false').find('.form-control').prop('disabled', true);
                    $currentRow.attr('data-save', true);
                    $currentRow.find('.form-control').prop('disabled', false);
                    $currentRow.find('.text-success,.text-danger').addClass("hidden");
                });
                //save button click
                $('#product-table tbody').on('click', '.save-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                        product_name = $currentRow.find('.product_name').val().toUpperCase(),
                        product_code = $currentRow.attr("data-prdid");
                    var formData = new FormData();
                    formData.append("product_code", product_code);
                    formData.append("product_name", product_name);
                    formData.append("product_disable", 0);
                    if ($.trim(product_name) != '') {
                        CIRCULATION.utils.showLoader();
                        $.ajax({
                            type: 'POST',
                            url: baseUrlPMD + 'Masters/UpdateProducts',
                            data: formData,
                            dataType: 'json',
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,   // tell jQuery not to set contentType
                            success: function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    sweetAlert("", data.text, "success");
                                    $currentRow.find('.product_name').val(product_name);
                                    $currentRow.find('.product_name').attr("data-val", product_name);
                                    $currentRow.attr('data-save', false);
                                    $currentRow.find('.form-control').prop('disabled', true);

                                } else {
                                    sweetAlert("Oops...", data.text, "error");
                                }
                            },
                            error: function (textStatus, errorThrown) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", "Something went wrong.", "error");
                            }
                        });
                    } else {
                        sweetAlert("Oops...", "Product Name is mandatory!", "error");
                    }
                });
                //cancel button click 
                $('#product-table tbody').on('click', '.cancel-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $currentRow.find('.product_name').val($currentRow.find('.product_name').attr("data-val"));
                    $currentRow.attr('data-save', false);
                    $currentRow.find('.form-control').prop('disabled', true);
                });
                //Delete button click
                $('#product-table tbody').on('click', '.status-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         product_code = $currentRow.attr("data-prdid"),
                        product_status = $(this).attr("data-disabled");

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
                            var formData = new FormData();
                            formData.append("product_code", product_code);
                            formData.append("product_status", product_status);
                            $.ajax({
                                type: 'POST',
                                url: baseUrlPMD + 'Masters/DeleteProducts',
                                data: formData,
                                dataType: 'json',
                                processData: false,  // tell jQuery not to process the data
                                contentType: false,   // tell jQuery not to set contentType
                                success: function (data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 200) {
                                        if (product_status == '1') {
                                            $currentRow.find('.status-btn').removeClass('btn-danger').addClass('btn-success');
                                            $currentRow.find('.status-btn').attr("data-disabled", "0");
                                            $currentRow.find('.status-btn').html('<i class="fa fa-check" aria-hidden="true"></i>');
                                            $currentRow.find('.btn-box').append('<button class="btn btn-success status-btn btn-xs" data-disabled="0" style="margin-left: 18%;"><i class="fa fa-check" aria-hidden="true"></i></button>');
                                        } else {
                                            $currentRow.find('.status-btn').removeClass('btn-danger').addClass('btn-success');
                                            $currentRow.find('.status-btn').attr("data-disabled", "0");
                                            $currentRow.find('.status-btn').html('<i class="fa fa-ban" aria-hidden="true"></i>');
                                        }
                                        $currentRow.remove();
                                        sweetAlert("", data.text, "success");
                                    } else {
                                        setTimeout(function () { sweetAlert("Oops...", data.text, "error") }, 3000);
                                    }
                                },
                                error: function (textStatus, errorThrown) {
                                    CIRCULATION.utils.hideLoader();
                                    sweetAlert("Oops...", "Something went wrong.", "error");
                                }
                            });
                        }
                    });
                });
            }
            //issue master
            else if (page == 'ISSUE-MASTER') {
                //SEARCH ISSUES
                $("#search-issue").click(function () {
                    var product = $("#issue-product").val();
                    if (product) {
                        window.location = baseUrlPMD + 'Masters/Issue?p=' + product;
                    }
                });

                //DELETE ISSUE MASTER
                $(".issue-delete-btn").click(function () {
                    var id = $(this).attr("data-id"),
                        pid = $(this).attr("data-product"),
                        $tr = $(this).closest("tr");
                    if (id && pid) {
                        CIRCULATION.utils.showLoader();
                        var formData = new FormData();
                        formData.append("issue_code", id);
                        formData.append("issue_product_code", pid);
                        CIRCULATION.utils.sendAjaxPost('Masters/DeleteIssue', formData, 'json',
                        function successCallBack(data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                $tr.remove();
                                sweetAlert("", data.text, "success");
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function errorStatus(textStatus, errorThrown) {                            
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                });

                //EDIT ISSUE MASTER
                $(".issue-edit-btn").click(function () {
                    var id = $(this).attr("data-id"), pid = $(this).attr("data-product");
                    if (id && pid) {
                        $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                        $("#common-modal").modal();
                        var formData = new FormData();
                        formData.append("issue_code", id);
                        formData.append("issue_product_code", pid);
                        CIRCULATION.utils.sendAjaxPost('Masters/ViewIssue', formData, 'html',
                        function successCallBack(data) {
                            $('#common-modal-body').html(data);
                            //bind-date-attributes
                            $("[data-mask]:not([readonly])").inputmask();
                            $('[data-mask]:not([readonly])').datepicker({
                                format: "dd-mm-yyyy",
                                autoclose: true,
                                todayHighlight: true,
                                toggleActive: true
                            });
                        },
                        function errorStatus(textStatus, errorThrown) {
                            $("#common-modal").modal('toggle');
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                });

                //UPDATE ISSUE MASTER
                $('body').on('click', '#update-issue-details', function () {                    
                    var issue_code = $("#p_issue_code").val().trim(),
                        issue_name = $("#p_issue_name").val().trim(),
                        issue_product_code = $("#p_issue_product_code").val().trim(),
                        issue_date = $("#p_issue_date").val().trim(),
                        issue_img_flag = $("#p_issue_img_flag").val().trim(),
                        issue_image = $('#p_issue_img')[0].files[0];

                    if (issue_code && issue_name && issue_product_code && issue_date) {
                        CIRCULATION.utils.showLoader();
                        var formData = new FormData();
                        formData.append("issue_code", issue_code);
                        formData.append("issue_name", issue_name);
                        formData.append("issue_product_code", issue_product_code);
                        formData.append("issue_date", issue_date);
                        formData.append("issue_img_flag", issue_img_flag);
                        formData.append("issue_image", issue_image);

                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateIssue', formData, 'json',
                        function successCallBack(data) {                            
                            if (data.status === 200) {
                                window.location.reload();
                                //sweetAlert("", data.text, "success");
                            } else {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function errorStatus(textStatus, errorThrown) {
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        sweetAlert("Oops...", "Mandatory Parameters Missing", "error");
                    }
                });
            }
            //BUREAU MASTER
            else if (page == 'BUREAU-MASTER') {
                //edit button click 
                $('#bureau-table tbody').on('click', '.edit-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $('#bureau-table tbody tr[data-save="true"]').attr('data-save', 'false').find('input[type="text"]').prop('disabled', true);
                    $currentRow.attr('data-save', true);
                    $currentRow.find('.burname').prop('disabled', false);
                    $currentRow.find('.burcontact').prop('disabled', false);
                    $currentRow.find('.burmobile').prop('disabled', false);
                });
                //cancel button click 
                $('#bureau-table tbody').on('click', '.cancel-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $currentRow.attr('data-save', false);
                    $currentRow.find('.form-control').prop('disabled', true);
                });
                //save button click
                $('#bureau-table tbody').on('click', '.save-btn', function (e) {
                    var error = 0;
                    var $currentRow = $(this).closest('tr'),
                    bureauCode = $.trim($currentRow.find(".burcode").val()),
                    bureauName = $.trim($currentRow.find(".burname").val().toUpperCase()),
                    bureauContact = $.trim($currentRow.find(".burcontact").val().toUpperCase()),
                    bureauMobile = $.trim($currentRow.find(".burmobile").val()),
                    formData = new FormData();
                    formData.append("bureau_code", bureauCode);
                    formData.append("bureau_name", bureauName);
                    formData.append("bureau_contact", bureauContact);
                    formData.append("bureau_mobile", bureauMobile);
                    if (bureauName != '' && bureauContact != '') {
                        CIRCULATION.utils.showLoader();
                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateBureau', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                sweetAlert("", data.text, "success");
                                $currentRow.find(".burname").val(bureauName.toUpperCase());
                                $currentRow.find(".burcontact").val(bureauContact.toUpperCase());
                                $currentRow.attr('data-save', false);
                                $currentRow.find('input[type="text"]').prop('disabled', true);
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function (textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        sweetAlert("Oops...", "Bureau Name is mandatory!", "error");
                    }
                });
                //Delete button click
                $('#bureau-table tbody').on('click', '.del-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                        bureauCode = $currentRow.find(".burcode").val();
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
                            var formData = new FormData();
                            formData.append("bureau_code", bureauCode);
                            CIRCULATION.utils.sendAjaxPost('Masters/DeleteBureau', formData, 'json',
                            function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    $currentRow.remove();
                                    sweetAlert("", data.text, "success");
                                } else {
                                    sweetAlert("", data.text, "error");
                                }
                            },
                            function (textStatus, errorThrown) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                            });
                        }
                    });
                });
            }
            //ACM
            else if (page == 'ACM-MASTER') {
                //DELETE ACM
                $(".acm-delete-btn").click(function () {
                    var id = $(this).attr("data-id");
                        //$tr = $(this).closest("tr");
                    if (id) {
                        swal({
                            title: "",
                            text: "Are you sure delete?",
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
                                    formData.append("acm_code", id);
                                    CIRCULATION.utils.sendAjaxPost('Masters/DeleteACM', formData, 'json',
                                    function (data) {
                                        CIRCULATION.utils.hideLoader();
                                        if (data.status === 200) {
                                            //$tr.remove();
                                            sweetAlert("", data.text, "success");
                                        } else {
                                            sweetAlert("Oops...", data.text, "error");
                                        }
                                    },
                                    function (textStatus, errorThrown) {
                                        CIRCULATION.utils.hideLoader();
                                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                    });
                                }
                            });
                    }
                });

                //EDIT ACM
                $('.acm-edit-btn').click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                        formData.append("acm_code", $(this).attr("data-id"));
                        CIRCULATION.utils.sendAjaxPost('Masters/ViewACM', formData, 'html',
                    function successCallBack(data) {
                        $('#common-modal-body').html(data);
                    },
                    function errorStatus(textStatus, errorThrown) {
                        $("#common-modal").modal('toggle');
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });

                //UPDATE ACM
                $('body').on('click', '#update-acm-details', function () {
                    var acmCode = $("#p_acm_code").val().trim(),
                        acmName = $("#p_acm_name").val().trim(),
                        acmPhone = $("#p_acm_phone").val().trim(),
                        acmRegion = $("#edt_region_rec_sel").val().trim(),
                        acmRegionName = $("#edt_region").val().trim(),
                        acmStatus = $("#p_acm_status").val().trim(),
                        formData = new FormData();
                    if (acmCode && acmName && acmPhone) {
                        CIRCULATION.utils.showLoader();
                        formData.append("acm_code", acmCode);
                        formData.append("acm_name", acmName);
                        formData.append("acm_phone", acmPhone);
                        formData.append("acm_region", acmRegion);
                        formData.append("acm_status", acmStatus);
                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateACM', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                var $tblRow = $("#records-table tbody button[data-id='" + acmCode + "']").closest("tr");
                                $tblRow.find("td.acm-name").html(acmName);
                                $tblRow.find("td.acm-phone").html(acmPhone);
                                $tblRow.find("td.acm-area").html(acmRegionName);
                                $tblRow.find("td.acm-status").html($("#p_acm_status option:selected").text());
                                $('#common-modal').modal('toggle');                               
                                sweetAlert("", data.text, "success");
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function (textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        var message = [];
                        if (!acmCode)  { message.push("ACM Code"); }
                        if (!acmName)  { message.push("Name");     }
                        if (!acmPhone) { message.push("Phone"); }
                        if (!acmArea) { message.push("Area"); }
                        if (!acmStatus) { message.push("Status"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });
            }
            //promoter master
            else if (page == 'PROMOTER-MASTER') {
                //DELETE PROMOTER
                $(".promoter-delete-btn").click(function () {
                    var id = $(this).attr("data-id"),
                        $tr = $(this).closest("tr");
                    if (id) {
                        swal({
                            title: "",
                            text: "Are you sure delete?",
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
                                    formData.append("promoter_code", id);
                                    CIRCULATION.utils.sendAjaxPost('Masters/DeletePromoter', formData, 'json',
                                    function (data) {
                                        CIRCULATION.utils.hideLoader();
                                        if (data.status === 200) {
                                            $tr.remove();
                                            sweetAlert("", data.text, "success");
                                        } else {
                                            sweetAlert("Oops...", data.text, "error");
                                        }
                                    },
                                    function (textStatus, errorThrown) {
                                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                    });
                                }
                            });
                    }
                });

                //EDIT PROMOTER
                $('.promoter-edit-btn').click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var $currentRow = $(this).closest('tr'),
                        formData = new FormData();
                    formData.append("promoter_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewPromoter', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });

                //UPDATE PROMOTER
                $('body').on('click', '#update-promoter-details', function () {
                    var proCode = $("#p_promoter_code").val().trim(),
                        proName = $("#p_promoter_name").val().trim(),
                        proArea = $("#p_promoter_area").val().trim(),
                        proPhone = $("#p_promoter_phone").val().trim(),
                        proACM = $("#p_promoter_acm_code").val().trim(),
                        formData = new FormData();
                    if (proCode && proName && proArea && proPhone && proACM) {
                        CIRCULATION.utils.showLoader();
                        formData.append("promoter_code", proCode);
                        formData.append("promoter_name", proName);
                        formData.append("promoter_area", proArea);
                        formData.append("promoter_phone", proPhone);
                        formData.append("p_promoter_acm_code", proACM);
                        CIRCULATION.utils.sendAjaxPost('Masters/UpdatePromoter', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                var $tblRow = $("#records-table tbody button[data-id='" + proCode + "']").closest("tr");
                                $tblRow.find("td.pro-name").html(proName);
                                $tblRow.find("td.pro-area").html(proArea);
                                $tblRow.find("td.pro-phone").html(proPhone);
                                $tblRow.find("td.pro-acm").html($("#p_promoter_acm_code option:selected").text());
                                $('#common-modal').modal('toggle');
                                sweetAlert("", data.text, "success");
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function (textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        var message = [];
                        if (!proCode) { message.push("Code"); }
                        if (!proName) { message.push("Name"); }
                        if (!proArea) { message.push("Area"); }
                        if (!proPhone) { message.push("Phone"); }
                        if (!proACM) { message.push("ACM"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });
            }
	        //Residence Association
            else if (page == 'RESIDENCE-MASTER') {
                //edit residence master
                $(".res-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("res_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewResidenceAssociation', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
           
            //update residence association
                $('body').on('click', '#update-res-details', function () {
                var rescode = $("#res_code").val().trim(),
                    resname = $("#residence_name").val().trim(),
                    resphn = $("#res_phone").val().trim(),
                    reslocation = $("#residence_location").val().trim();
                resremark = $("#residence_remarks").val().trim();
                rescontact = $("#residence_cont_person").val().trim();
                resstatus = $("#residence_status").val().trim();

                var formData = new FormData();
                if (rescode && resname && resphn && reslocation) {
                    CIRCULATION.utils.showLoader();
                    formData.append("res_code", rescode);
                    formData.append("residence_name", resname);
                    formData.append("res_phone", resphn);
                    formData.append("residence_location", reslocation);
                    formData.append("residence_remarks", resremark);
                    formData.append("residence_cont_person", rescontact);
                    formData.append("residence_status", resstatus);
                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateResidenceAssociation', formData, 'json',
                       function (data) {
                           CIRCULATION.utils.hideLoader();
                           if (data.status === 200) {
                               var table = $("#res_table tbody button[data-id='" + res_code + "']").closest("tr");
                               table.find("td.resi_name").html(resname);
                               table.find("td.resi_location").html(reslocation);
                               table.find("td.resi_phn").html(resphn);
                               location.reload(true)
                               sweetAlert("", data.text, "success");
                           } else {
                               sweetAlert("Oops...", data.text, "error");
                           }

                       },function (textStatus, errorThrown) {
                           CIRCULATION.utils.hideLoader();
                           sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                       });
                }
                });

                // DELETE Residence Association
                $(".res-delete-btn").click(function () {
                    var id = $(this).attr("data-id");
                        //$tr = $(this).closest("tr");
                    if (id) {
                        swal({
                            title: "",
                            text: "Are you sure delete?",
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
                                    formData.append("residence_code", id);
                                    CIRCULATION.utils.sendAjaxPost('Masters/DeleteResidenceAssociation', formData, 'json',
                                    function (data) {
                                        CIRCULATION.utils.hideLoader();
                                        if (data.status === 200) {
                                            //$tr.remove();
                                            location.reload(true);
                                            sweetAlert("", data.text, "success");
                                        } else {
                                            sweetAlert("Oops...", data.text, "error");
                                        }
                                    },
                                    function (textStatus, errorThrown) {
                                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                    });
                                }
                            });
                    }
                });
            }
            //Copy Type master
            else if (page == 'COPY-TYPE-MASTER') {
                $("#copy_code").change(function () {
                    $("#ct_group_rec_sel,#ct_group").val('');
                });
                // edit button
                $(".ct-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("ct_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewCopyTypeMaster', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                    //YEAR PICKER
                    $('.yearpicker').datepicker({
                        format: "yyyy",
                        viewMode: "years",
                        minViewMode: "years"
                    });
                    $("#p_copy_code").change(function () {
                        $("#p_ct_group_rec_sel,#p_ct_group").val('');
                    });
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //update copy type 
                $('body').on('click', '#update-ct-details', function () {
                    var ctCode = $("#p_ct_code").val().trim(),
                        ctName = $("#p_ct_name").val().trim(),
                        ctypeCode = $("#p_copy_code").val().trim(),
                        //ctypeYear = $("#p_ct_year").val(),
                        //ctypeShowYear= $("p_type_show_year").val().trim(),
                        ctypeGroup = $("#p_ct_group_rec_sel").val().trim(),
                        ctypeStatus = $("#p_ct_status").val().trim(),
                        formData = new FormData();
                        CIRCULATION.utils.showLoader();
                        formData.append("ctCode", ctCode);
                        formData.append("ctName", ctName);
                        formData.append("ctypeCode", ctypeCode);
                        //formData.append("ctypeYear", ctypeYear);
                        //formData.append("ctypeShowYear", ctypeShowYear);
                        formData.append("ctypeGroup", ctypeGroup);
                        formData.append("ctypeStatus", ctypeStatus);
                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateCopyTypeMaster', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                sweetAlert("", data.text, "success");
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
            }
            else if (page == 'UNION-MASTER') {
                // edit button
                $(".union-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("um_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewUnionMaster', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //update union master
                $('body').on('click', '#update-un-details', function () {
                    var unCode = $("#p_un_code").val().trim(),
                        unName = $("#p_un_name").val().trim(),
                        unAddress1 = $("#p_un_address1").val().trim(),
                        unAddress2 = $("#p_un_address2").val().trim(),
                        unTown = $("#p_un_town").val().trim(),
                        unPincode = $("#p_un_pin").val().trim(),
                        unPresident = $("#p_un_pres").val().trim(),
                        unPresMobile = $("#p_un_pres_mobile").val().trim(),
                        unSecretary = $("#p_un_sec").val().trim(),
                        unSecMobile = $("#p_un_sec_mobile").val().trim(),
                        unStatus = $("#p_un_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("unCode", unCode);
                    formData.append("unName", unName);
                    formData.append("unAddress1", unAddress1);
                    formData.append("unAddress2", unAddress2);
                    formData.append("unTown", unTown);
                    formData.append("unPincode", unPincode);
                    formData.append("unPresident", unPresident);
                    formData.append("unPresMobile", unPresMobile);
                    formData.append("unSecretary", unSecretary);
                    formData.append("unSecMobile", unSecMobile);
                    formData.append("unStatus", unStatus);
                    CIRCULATION.utils.sendAjaxPost('Masters/updateUnionMaster', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#union-table tbody button[data-id='" + unCode + "']").closest("tr");
                            $tblRow.find("td.union-name").html(unName);
                            $tblRow.find("td.union-add1").html(unAddress1);
                            $tblRow.find("td.union-add2").html(unAddress2);
                            $tblRow.find("td.union-town").html(unTown);
                            $tblRow.find("td.union-pres").html(unPresident);
                            $tblRow.find("td.union-pres-phn").html(unPresMobile);
                            $tblRow.find("td.union-sec").html(unSecretary);
                            $tblRow.find("td.union-sec-phn").html(unSecMobile);
                            $tblRow.find("td.union-status").html($("#p_un_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            else if (page == 'SHAKHA-MASTER') {
                // edit button
                $(".shakha-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("s_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewShakhaMaster', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
            // update shakha master
                $('body').on('click', '#update-sh-details', function () {
                    var shCode = $("#p_sh_code").val().trim(),
                        shNumber = $("#p_sh_number").val().trim(),
                        shName = $("#p_sh_name").val().trim(),
                        shAddress1 = $("#p_sh_address1").val().trim(),
                        shAddress2 = $("#p_sh_address2").val().trim(),
                        shTown = $("#p_sh_town").val().trim(),
                        shPincode = $("#p_sh_pin").val().trim(),
                        shUnion = $("#p_shakha_union_rec_sel").val().trim(),
                        shPresident = $("#p_sh_pres").val().trim(),
                        shPresMobile = $("#p_sh_pres_mobile").val().trim(),
                        shSecretary = $("#p_sh_sec").val().trim(),
                       shSecMobile = $("#p_sh_sec_mobile").val().trim(),
                        shStatus = $("#p_sh_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("shCode", shCode);
                    formData.append("shNumber", shNumber);
                    formData.append("shName", shName);
                    formData.append("shAddress1", shAddress1);
                    formData.append("shAddress2", shAddress2);
                    formData.append("shTown", shTown);
                    formData.append("shPincode", shPincode);
                    formData.append("shUnion", shUnion);
                    formData.append("shPresident", shPresident);
                    formData.append("shPresMobile", shPresMobile);
                    formData.append("shSecretary", shSecretary);
                    formData.append("shSecMobile", shSecMobile);
                    formData.append("shStatus", shStatus);
                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateShakhaMaster', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#shakha-table tbody button[data-id='" + shCode + "']").closest("tr");
                            $tblRow.find("td.sh-number").html(shNumber);
                            $tblRow.find("td.sh-name").html(shName);
                            $tblRow.find("td.sh-add1").html(shAddress1);
                            $tblRow.find("td.sh-add2").html(shAddress2);
                            $tblRow.find("td.sh-town").html(shTown);
                            $tblRow.find("td.sh-pin").html(shPincode);
                            $tblRow.find("td.sh-union").html($("#p_shakha_union").val());
                            $tblRow.find("td.sh-pres").html(shPresident);
                            $tblRow.find("td.sh-pres-phn").html(shPresMobile);
                            $tblRow.find("td.sh-sec").html(shSecretary);
                            $tblRow.find("td.sh-sec-phn").html(shSecMobile);
                            $tblRow.find("td.sh-status").html($("#p_sh_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            /*Edition master*/
            else if (page == 'EDITION-MASTER') {
                // edit button
                $(".edition-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("ed_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewEditionMaster', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //update edition master
                $('body').on('click', '#update-ed-details', function () {
                    var edCode = $("#p_ed_code").val().trim(),
                        edName = $("#p_ed_name").val().trim().toUpperCase(),
                        edstatus = $("#p_ed_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("edCode", edCode);
                    formData.append("edName", edName);
                    formData.append("edstatus", edstatus);
                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateEditionMaster', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#edition-table tbody button[data-id='" + edCode + "']").closest("tr");
                            $tblRow.find("td.edt-name").html(edName);
                            $tblRow.find("td.edt-status").html($("#p_ed_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });

            }
            else if (page == 'ROUTE-MASTER') {
                // edit button
                $(".route-edit-btn").click(function () {
                        $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                        $("#common-modal").modal();
                        var formData = new FormData();
                        formData.append("rt_code", $(this).attr("data-id"));
                        CIRCULATION.utils.sendAjaxPost('Masters/ViewRouteMaster', formData, 'html',
                        function successCallBack(data) {
                            $('#common-modal-body').html(data);
                            //bind-date-attributes
                            $('.timepicker').timepicker({
                                showInputs: false
                            });
                        },
                        function errorStatus(textStatus, errorThrown) {
                            $("#common-modal").modal('toggle');
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    
                });
                //update route master
                $('body').on('click', '#update-route-details', function () {
                    var rtCode = $("#p_rt_code").val().trim(),
                        rtName = $("#p_rt_name").val().trim(),
                        rtType = $("#p_rt_type").val().trim(),
                        rtNumber = $("#p_rt_number").val().trim(),
                        rtDate = $("#p_rt_date").val().trim(),
                        rtstatus = $("#p_rt_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("rtCode", rtCode);
                    formData.append("rtName", rtName);
                    formData.append("rtType", rtType);
                    formData.append("rtNumber", rtNumber);
                    formData.append("rtDate", rtDate);
                    formData.append("rtstatus", rtstatus);
                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateRouteMaster', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#route-table tbody button[data-id='" + rtCode + "']").closest("tr");
                            $tblRow.find("td.rt-name").html(rtName);
                            $tblRow.find("td.rt-type").html(rtType);
                            $tblRow.find("td.rt-numb").html(rtNumber);
                            $tblRow.find("td.rt-date").html(rtDate);
                            $tblRow.find("td.rt-status").html($("#p_rt_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            //location.reload(true)
                            sweetAlert("", data.text, "success");
                            
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            else if (page == 'DROPPING-POINT-MASTER') {
                CIRCULATION.utils.enableMalayalamTyping();
                // edit button
                $(".drop-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("drp_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewDroppingMaster', formData, 'html',
                    function successCallBack(data) {
                        $('#common-modal-body').html(data);
                        //gooogle-translileration
                        var options = {
                            sourceLanguage:
                                google.elements.transliteration.LanguageCode.ENGLISH,
                            destinationLanguage:
                                [google.elements.transliteration.LanguageCode.MALAYALAM],
                            shortcutKey: 'ctrl+g',
                            transliterationEnabled: true
                        };
                        // Create an instance on TransliterationControl with the required
                        // options.
                        var control =
                            new google.elements.transliteration.TransliterationControl(options);
                        // Enable transliteration in the textbox with id
                        // &#39;transliterateTextarea&#39;.
                        control.makeTransliteratable(['p_dr_mal']);
                    },
                    function errorStatus(textStatus, errorThrown) {
                        $("#common-modal").modal('toggle');
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
                //Update
                $('body').on('click', '#update-drop-details', function () {
                    var drCode = $("#p_dr_code").val().trim(),
                        drName = $("#p_dr_name").val().trim(),
                        drMal = $("#p_dr_mal").val().trim(),
                        drRoute = $("#p_drop_route_code_rec_sel").val().trim(),
                        drStatus = $("#p_dr_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("drCode", drCode);
                    formData.append("drName", drName);
                    formData.append("drMal", drMal);
                    formData.append("drRoute", drRoute);
                    formData.append("drStatus", drStatus);
                   
                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateDroppingMaster', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#drop-table tbody button[data-id='" + drCode + "']").closest("tr");
                            $tblRow.find("td.dr-name").html(drName);
                            $tblRow.find("td.dr-mal-name").html(drMal);
                            $tblRow.find("td.dr-route-name").html($("#p_drop_route_code").val());
                            $tblRow.find("td.dr-status").html($("#p_dr_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
                //select box
                $("#drop_route").change(function () {
                    window.location = baseUrlPMD + "Masters/DroppingMaster/"+$(this).val();
                });     
            }
            //Account Heads
            else if (page == 'ACCOUNT-HEADS') {
                //EDIT AHM
                $('.ah-edit-btn').click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("ac_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewAccountHeads', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //UPDATE AHM
                $('body').on('click', '#update-ah-details', function () {
                    var acCode = $("#p_ac_code").val().trim(),
                        acName = $("#p_ac_name").val().trim(),
                        acDebitCredit = $("#p_ac_debit_credit").val().trim(),
                        acStatus = $("#p_ac_status").val().trim(), //cancel-flag
                        formData = new FormData();
                    if (acCode && acName) {
                        CIRCULATION.utils.showLoader();
                        formData.append("ac_code", acCode);
                        formData.append("ac_name", acName);
                        formData.append("ac_debit_credit", acDebitCredit);
                        formData.append("cancel_flag", acStatus);
                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateAccountHeads', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                var $tblRow = $("#records-table tbody button[data-id='" + acCode + "']").closest("tr");
                                $tblRow.find("td.ac-name").html(acName);
                                $tblRow.find("td.ac-credit-debit").html($("#p_ac_debit_credit option:selected").text());
                                $tblRow.find("td.ac-status").html($("#p_ac_status option:selected").text());
                                $('#common-modal').modal('toggle');
                                sweetAlert("", data.text, "success");
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function (textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        var message = [];
                        if (!acCode) { message.push("Account Head Code"); }
                        if (!acName) { message.push("Account Head Name"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });
            }    
            //Event Master
            else if (page == 'EVENT-MASTER') {
                // edit button
                $(".event-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("evnt_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewEvent', formData, 'html',
                    function successCallBack(data) {
                        $('#common-modal-body').html(data);
                        //bind-date-attributes
                        $("[data-mask]:not([readonly])").inputmask();
                        $('[data-mask]:not([readonly])').datepicker({
                            format: "dd-mm-yyyy",
                            autoclose: true,
                            todayHighlight: true,
                            toggleActive: true
                        });
                    },
                    function errorStatus(textStatus, errorThrown) {
                        $("#common-modal").modal('toggle');
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });

                });
                // update
                $('body').on('click', '#update-event-details', function () {
                    var evnCode = $("#p_even_code").val().trim(),
                        evnName = $("#p_even_name").val().trim(),
                       evnStartdate = $("#p_even_start_date").val().trim(),
                        evnEnddate = $("#p_event_end_date").val().trim(),
                        evenStatus = $("#p_even_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("evnCode", evnCode);
                    formData.append("evnName", evnName);
                    formData.append("evnStartdate", evnStartdate);
                    formData.append("evnEnddate", evnEnddate);
                    formData.append("evenStatus", evenStatus);

                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateEvent', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#event_table tbody button[data-id='" + evnCode + "']").closest("tr");
                            $tblRow.find("td.even-name").html(evnName);
                            $tblRow.find("td.even-sdate").html(evnStartdate);
                            $tblRow.find("td.even-edate").html(evnEnddate);
                            $tblRow.find("td.even-status").html($("#p_even_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });

            }
            //Agent Master
            else if (page == 'AGENT-MASTER') {                
                if (mode === 'dmlldy1vbmx5') {
                    //view-only
                    $("#agents-inputs").find('.form-control, .input-group-addon').addClass("disable-input");
                    $("#products-table tbody").find('.delete-from-list').remove();
                    $("#add-to-list, #save-agency, #search-agency").attr("disabled", true);
                }
                else if (mode === 'ZWRpdC1tb2Rl') {
                    $("#agent_code").addClass("disable-input");
                }

                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });

                //add-to-list
                var $noRec = '<tr class="no-records">'
                                + '<td colspan="4">No Records Added!</td>'
                             + '</tr>';

                $("#add-to-list").click(function () {
                    var $productTblBody = $("#products-table tbody");
                    $productTblBody.find('tr.no-records').remove();

                    var prodRec = ($("#agent_product_rec_sel").val() || null),
                        agentProductRec = prodRec ? JSON.parse(decodeURIComponent(prodRec)) : null,
                        agentProduct = prodRec ? agentProductRec['Code'] : null,
                        agentProductName = prodRec ? agentProductRec['Name'] : null;

                    var isProductInList = false;
                    if (agentProduct && $productTblBody.find('tr[data-product=' + agentProduct + ']').length > 0) {
                        isProductInList = true;
                    }

                    var acmRec = ($("#agent_acm_rec_sel").val() || null),
                            promoterRec = ($("#agent_promoter_rec_sel").val() || null),
                            editionRec = ($("#agent_edition_rec_sel").val() || null),
                            routeRec = ($("#agent_route_rec_sel").val() || null),
                            dPointRec = ($("#agent_dropping_point_rec_sel").val() || null),
                            bureauRec = ($("#agent_bureau_rec_sel").val() || null),
                            unionRec = ($("#agent_union_rec_sel").val() || null),
                            shakhaRec = ($("#agent_shakha_rec_sel").val() || null),

                            agentACMRec = acmRec ? JSON.parse(decodeURIComponent(acmRec)) : null,
                            agentACM = acmRec ? agentACMRec['Code'] : null,
                            agentACMRegion = acmRec ? agentACMRec['RegionCode'] : null,

                            agentPromoterRec = promoterRec ? JSON.parse(decodeURIComponent(promoterRec)) : null,
                            agentPromoter = promoterRec ? agentPromoterRec['Code'] : null,

                            agentEditionRec = editionRec ? JSON.parse(decodeURIComponent(editionRec)) : null,
                            agentEdition = editionRec ? agentEditionRec['Code'] : null,

                            agentRouteRec = routeRec ? JSON.parse(decodeURIComponent(routeRec)) : null,
                            agentRoute = routeRec ? agentRouteRec['Code'] : null,

                            agentDropPointRec = dPointRec ? JSON.parse(decodeURIComponent(dPointRec)) : null,
                            agentDropPoint = dPointRec ? agentDropPointRec['Code'] : null,

                            agentBureauRec = bureauRec ? JSON.parse(decodeURIComponent(bureauRec)) : null,
                            agentBureau = bureauRec ? agentBureauRec['Code'] : null,

                            agentUnionRec = unionRec ? JSON.parse(decodeURIComponent(unionRec)) : null,
                            agentUnion = unionRec ? agentUnionRec['Code'] : null,

                            agentShakhaRec = shakhaRec ? JSON.parse(decodeURIComponent(shakhaRec)) : null,
                            agentShakha = shakhaRec ? agentShakhaRec['Code'] : null,

                            agentSec = parseFloat($("#agent_sec_contr").val().trim()),
                            agentSecFlag = parseInt($("#agent_sec_flag").val().trim()),
                            agentComm = parseFloat($("#agent_comm").val().trim()),
                            agentCommFlag = parseInt($("#agent_comm_flag").val().trim()),
                            agentDoj = $("#agent_doj").val().trim(),
                            agentStatus = parseInt($("#agent_status").val().trim()),
                            agentBillPrint = parseInt($("#agent_bill_print").val().trim()),
                            agentSlipPrint = parseInt($("#agent_slip_print").val().trim()),
                            agentBonusPrint = parseInt($("#agent_bill_bonus").val().trim());

                    if (agentProduct &&
                        agentACM &&
                        agentACMRegion &&
                        agentPromoter &&
                        agentEdition &&
                        agentRoute &&
                        agentDropPoint &&
                        agentBureau &&
                        agentUnion &&
                        agentShakha) {

                        swal({
                            title: isProductInList ? "Product [" + agentProductName + "] already in list!" : "",
                            text: isProductInList ? "Are you sure to update the list?" : "Are you sure to add product [" + agentProductName + "] to list?",
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
                                var obj = {
                                    "agent_product": agentProduct,
                                    "agent_product_name": $("#agent_product").val(),

                                    "agent_acm": agentACM,
                                    "agent_acm_name": $("#agent_acm").val(),

                                    "agent_acm_region": agentACMRegion,
                                    "agent_acm_region_name": $("#agent_region").val(),

                                    "agent_promoter": agentPromoter,
                                    "agent_promoter_name": $("#agent_promoter").val(),

                                    "agent_edition": agentEdition,
                                    "agent_edition_name": $("#agent_edition").val(),

                                    "agent_route": agentRoute,
                                    "agent_route_name": $("#agent_route").val(),

                                    "agent_drop_point": agentDropPoint,
                                    "agent_drop_point_name": $("#agent_dropping_point").val(),

                                    "agent_sec": agentSec,
                                    "agent_sec_flag": agentSecFlag,
                                    "agent_comm": agentComm,
                                    "agent_comm_flag": agentCommFlag,
                                    "agent_doj": agentDoj,
                                    "agent_status": agentStatus,

                                    "agent_bureau": agentBureau,
                                    "agent_bureau_name": $("#agent_bureau").val(),

                                    "agent_union": agentUnion,
                                    "agent_union_name": $("#agent_union").val(),

                                    "agent_shakha": agentShakha,
                                    "agent_shakha_name": $("#agent_shakha").val(),

                                    "agent_bill_print": agentBillPrint,
                                    "agent_slip_print": agentSlipPrint,
                                    "agent_bill_bonus": agentBonusPrint
                                };

                                //template
                                var $tmpl = '<tr data-product="' + agentProduct + '">'
                                            + '<td class="product-code">' + agentProduct + '<textarea class="hide" name="product_records[]">' + encodeURIComponent(JSON.stringify(obj)) + '</textarea></td>'
                                            + '<td class="product-name">' + agentProductName + '</td>'
                                            + '<td class="product-copy" align="right">0</td>'
                                            + '<td align="center"><button class="btn btn-primary btn-xs view-from-list" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button> <button class="btn btn-danger delete-from-list" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'
                                        + '</tr>';

                                //for update row, remove the existing row and add new row
                                if (isProductInList === true) {
                                    $productTblBody.find('tr[data-product=' + agentProduct + ']').remove();
                                }

                                $productTblBody.append($tmpl);

                                //reset inputs
                                $("#product-opt-wrap").find('input').not('.avoid-clr').val('');
                                $("#agent_sec_contr, #agent_comm, #agent_status").val('0');
                                $("#agent_comm_flag, #agent_sec_flag").val('1');                                
                            }
                        });


                    }
                    else {
                        var message = [];
                        if (!agentProduct) { message.push("Product"); }
                        if (!agentACM) { message.push("ACM"); }
                        if (!agentACMRegion) { message.push("ACM Region"); }
                        if (!agentPromoter) { message.push("Promoter"); }
                        if (!agentEdition) { message.push("Edition"); }
                        if (!agentRoute) { message.push("Route"); }
                        if (!agentDropPoint) { message.push("Drop Point"); }
                        if (!agentBureau) { message.push("Bureau"); }
                        if (!agentUnion) { message.push("Union"); }
                        if (!agentShakha) { message.push("Shakha"); }
                        sweetAlert("", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });

                //save-agency
                $("#save-agency").click(function () {
                    //check-agency-code-already-used
                    var agentCode = $("#agent_code").val(),
                        agentSlNo = $("#agent_slno").val(),
                        isUpdate = $("#is_update").val(),
                        productLists = ($("#products-table tbody tr").not(".no-records").length || 0),
                        formData  = new FormData();                    
                        formData.append("agent_code", agentCode);
                        formData.append("agent_slno", agentSlNo);
                        formData.append("is_update", isUpdate);
                        if (agentCode && productLists) {
                            CIRCULATION.utils.showLoader();
                            CIRCULATION.utils.sendAjaxPost('Masters/ValidateAgentCode', formData, 'json',
                            function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (parseInt(data) === 0) {
                                    $("#ag_form").submit();
                                } else {
                                    sweetAlert("Oops...", "AgentCode already taken!", "error");
                                }
                            },
                            function (textStatus, errorThrown) {
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                            });
                        }
                        else {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", productLists == 0 ? "Please add atleast one product!" : "Invalid AgentCode!", "error");                            
                        }
                });

                //delete the appended row
                $('#products-table').on('click', '.delete-from-list', function () {
                    var $this = $(this);
                    swal({
                        title: "",
                        text: "Are you sure to delete?",
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
                            $this.closest("tr").remove();
                            if ($("#products-table tbody tr").length === 0) {
                                $("#products-table tbody").html($noRec);
                            }
                        }
                    });
                });

                //view product details
                $('#products-table').on('click', '.view-from-list', function () {
                    var rec = $(this).closest("tr").find('textarea').val();
                    if (rec) {                        
                        var r = JSON.parse(decodeURIComponent(rec));
                        
                        $("#agent_product").val(r['agent_product_name']);
                        $("#agent_product_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_product'], "Name": r['agent_product_name'] })));

                        $("#agent_acm").val(r['agent_acm_name']);
                        $("#agent_acm_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_acm'], "RegionCode": r['agent_acm_region'], "Name": r['agent_acm_name'], "Region": r['agent_acm_region_name'] })));
                        $("#agent_region").val(r['agent_acm_region_name']);
                        
                        $("#agent_promoter").val(r['agent_promoter_name']);
                        $("#agent_promoter_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_promoter'], "Name": r['agent_promoter_name'] })));

                        $("#agent_bureau").val(r['agent_bureau_name']);
                        $("#agent_bureau_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_bureau'], "Name": r['agent_bureau_name'] })));
                                                
                        $("#agent_edition").val(r['agent_edition_name']);
                        $("#agent_edition_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_edition'], "Name": r['agent_edition_name'] })));
                        
                        $("#agent_route").val(r['agent_route_name']);
                        $("#agent_route_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_route'], "Name": r['agent_route_name'] })));

                        $("#agent_dropping_point").val(r['agent_drop_point_name']);
                        $("#agent_dropping_point_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_drop_point'], "Name": r['agent_drop_point_name'] })));
                        
                        $("#agent_union").val(r['agent_union_name']);
                        $("#agent_union_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_union'], "Name": r['agent_union_name'] })));
                        
                        $("#agent_shakha").val(r['agent_shakha_name']);
                        $("#agent_shakha_rec_sel").val(encodeURIComponent(JSON.stringify({ "Code": r['agent_shakha'], "Name": r['agent_shakha_name'] })));

                        $("#agent_sec_contr").val(r['agent_sec']);
                        $("#agent_sec_flag").val(r['agent_sec_flag']);
                        $("#agent_comm").val(r['agent_comm']);
                        $("#agent_comm_flag").val(r['agent_comm_flag']);
                        $("#agent_doj").val(r['agent_doj']);
                        $("#agent_status").val(r['agent_status']);
                        $("#agent_status_date").val(r['agent_status_date']);
                        $("#agent_bill_print").val(r['agent_bill_print']);
                        $("#agent_bill_bonus").val(r['agent_bill_bonus']);
                        $("#agent_slip_print").val(r['agent_slip_print']);
                    }
                });

                //status date
                $("#agent_status").change(function () {
                    $("#agent_status_date").val('');
                    if ($(this).val() == '1') {
                        $("#agent_status_date").val($("#agent_status_date").attr("data-value"));
                    }
                });
            }
	    //Agent Groups Master
            else if (page == 'AGENT-GROUPS-MASTER') {
                var $trRow = '';
                var agentTmpl = '<tr><td style="width:25%;"><div class="input-group search-module margtop-3" data-selected="true">' +
                                 '<input autocomplete="off" value="" required type="text" class="form-control agent" id="agent_{0}" name="agent_{0}" data-request=\'{"id":"17","search":"Name"}\' data-select="{}" data-multiselect="false" placeholder="" data-selectIndex="0" />' +
                                 '<div class="input-group-addon btn agent_search" id="agent__{0}_search" data-search="agent_{0}"><i class="fa fa-search"></i></div>' +
                                 '</div></td>' +
                                 '<td style="width:38%;"><input type="text" class="form-control ag_nme margtop-3 agent__{0}_clr" value="" readonly /></td>' +
                                 '<td style="width:32%;"><input type="text" class="form-control ag_loc margtop-3 agent__{0}_clr" value="" readonly /></td>' +
                                 '<td style="width:5%;" class="action-btns"><span style="margin-left: 9px;margin-top: 9px;float: left;"  class="add-btn"><i class="fa fa-plus-square" style="color:dodgerblue; font-size:17px;" aria-hidden="true"></i></span></td></tr>';
                var agentEdtTmpl = '<tr><td style="width:25%;"><div class="input-group search-module margtop-3" data-selected="true">' +
                                 '<input autocomplete="off" value="" required type="text" class="form-control agent" id="edt_agent_{0}" name="edt_agent_{0}" data-request=\'{"id":"17","search":"Name"}\' data-select="{}" data-multiselect="false"  placeholder="" data-selectIndex="0" />' +
                                 '<div class="input-group-addon btn agent_search" id="edt_agent_{0}_search" data-search="edt_agent_{0}"><i class="fa fa-search"></i></div>' +
                                 '</div></td>'+
                                 '<td style="width:38%;"><input type="text" class="form-control ag_nme margtop-3 edt_agent_{0}_clr" value="" readonly /></td>' +
                                 '<td style="width:32%;"><input type="text" class="form-control ag_loc margtop-3 edt_agent_{0}_clr" value="" readonly /></td>' +
                                 '<td style="width:5%;" class="action-btns"><span style="margin-left: 9px;margin-top: 9px;float: left;"  class="add-btn"><i class="fa fa-plus-square" style="color:dodgerblue; font-size:17px;" aria-hidden="true"></i></span></td></tr>';
                var delBtnTmpl = '<span style="margin-left: 9px;" class="del-btn"><i class="fa fa-trash" style="color:red; font-size:17px;" aria-hidden="true"></i></span>';
                $("#agents-tbl").on('click', '.add-btn', function () {
                    $("#agents-tbl tr:last").find('.action-btns').html(delBtnTmpl);
                    $("#agents-tbl").append(agentTmpl.fmt($("#agents-tbl tr").length+1));
                });
                $("#agents-tbl").on('click', '.del-btn', function () {
                    $(this).closest('tr').remove();
                    if ($("#agents-tbl tr").length == 1) {
                        $("#agents-tbl tr").find('.margtop-3').css({ "margin-top": "0px" });
                    }
                });
                $("body").on('click', '#updt-agents-tbl .add-btn', function () {
                    $("#updt-agents-tbl tr:last").find('.action-btns').html(delBtnTmpl);
                    $("#updt-agents-tbl").append(agentEdtTmpl.fmt($("#updt-agents-tbl tr").length + 1));
                });
                $("body").on('click', '#updt-agents-tbl .del-btn', function () {
                    $(this).closest('tr').remove();
                    if ($("#updt-agents-tbl tr").length == 1) {
                        $("#updt-agents-tbl tr").find('.search-module').css({ "margin-top": "0px" });
                    }
                });
                $("#agent_lists").change(function () {
                    var norecTmpl = '<tr><td colspan="4" class="no-records"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No Records Found!</td></tr>',
                        loadTmpl = '<tr class="loading"><td colspan="4" align="center"><img src="' + baseUrlPMD + 'assets/imgs/blue-loader.gif" width="200" /></td></tr>';
                    var formData = new FormData(),
                        agListFile = $("#agent_lists")[0].files[0],
                        agFilename = $("#agent_lists").val(),
                        parts = agFilename?agFilename.split('.'):'';
                    if ((parts&&parts[parts.length - 1].toLowerCase() != 'txt') || !agListFile) {
                        $("#agent_lists").addClass('haserror');
                        return false;
                    }
                    $("#upld_agents_tbl").find('#upload_ag_selall').css({"display":"none"});
                    $("#upld_agents_tbl tbody").html(loadTmpl);
                    $("#upld_agents_box").removeClass('hide');
                    formData.append("agents_file", agListFile);
                    CIRCULATION.utils.sendAjaxPost('Masters/GetUploadedAgents', formData, 'html',
                    function (html) {
                        if (html) {
                            $("#upld_agents_tbl tbody").html(html);
                            $("#upld_agents_tbl").find('#upload_ag_selall').css({ "display": "block" });
                        } else {
                            $("#upld_agents_tbl tbody").html(norecTmpl);
                        }
                        $("#agent_lists").val('');
                    },
                    function (textStatus, errorThrown) {
                        $("#upld_agents_tbl tbody").html(norecTmpl);
                        $("#agent_lists").val('');
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
                $("body").on('change', '#edt_agent_lists', function () {
                    var norecTmpl = '<tr><td colspan="4" class="no-records"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No Records Found!</td></tr>',
                        loadTmpl = '<tr class="loading"><td colspan="4" align="center"><img src="' + baseUrlPMD + 'assets/imgs/blue-loader.gif" width="200" /></td></tr>';
                    var formData = new FormData(),
                        agListFile = $("#edt_agent_lists")[0].files[0],
                        agFilename = $("#edt_agent_lists").val(),
                        parts = agFilename ? agFilename.split('.') : '';
                    if ((parts && parts[parts.length-1].toLowerCase() != 'txt') || !agListFile) {
                        $("#edt_agent_lists").addClass('haserror');
                        return false;
                    }
                    $("#edt_upld_agents_tbl").find('#upload_ag_selall').css({ "display": "none" });
                    $("#edt_upld_agents_tbl tbody").html(loadTmpl);
                    $("#edt_upld_agents_box").removeClass('hide');
                    formData.append("agents_file", agListFile);
                    CIRCULATION.utils.sendAjaxPost('Masters/GetUploadedAgents', formData, 'html',
                    function (html) {
                        if (html) {
                            $("#edt_upld_agents_tbl tbody").html(html);
                            $("#edt_upld_agents_tbl").find('#edt_upload_ag_selall').css({ "display": "block" });
                        } else {
                            $("#edt_upld_agents_tbl tbody").html(norecTmpl);
                        }
                        $("#edt_agent_lists").val('');
                    },
                    function (textStatus, errorThrown) {
                        $("#edt_upld_agents_tbl tbody").html(norecTmpl);
                        $("#edt_agent_lists").val('');
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
                $('body').on('click', '#edt_upload_ag_selall', function () {
                    $("#edt_upld_agents_tbl").find(".up_agents").prop("checked", $(this).prop("checked"));
                });
                $("#upload_ag_selall").click(function () {
                    $("#upld_agents_tbl").find(".up_agents").prop("checked", $(this).prop("checked"));
                });
                //Create Agent Groups
                $('body').on('click', '#add-agent-groups', function () {
                    var error=0, agents = [],
                        agentRec = {}, agentSelVal='',
                        agGroupName = $("#aggroup_name").val().trim();
                        formData = new FormData();
                        $("#agents-tbl").find('tr').each(function () {
                            var inputId = $(this).find(".agent").attr("id");
                            agentSelVal = $(this).find("#" + inputId + "_rec_sel").val();
                            agentRec = agentSelVal?JSON.parse(decodeURIComponent(agentSelVal)):'';
                            if (agentRec) agents.push(agentRec);
                        });
                        $("#upld_agents_tbl").find('.up_agents:checked').each(function () {
                            agentSelVal = $(this).val();
                            agentRec = agentSelVal ? JSON.parse(decodeURIComponent(agentSelVal)) : '';
                            if (agentRec) agents.push(agentRec);
                        });
                    if (!agGroupName) {
                        $("#aggroup_name").addClass('haserror');
                        error++;
                    }
                    if (agents.length==0) {
                        $("#agent_1").addClass('haserror');
                        error++;
                    }
                    if (error > 0) return false;
                    if (agGroupName && agents) {
                        CIRCULATION.utils.showLoader();
                        formData.append("group_name", agGroupName);
                        formData.append("agents_lists", JSON.stringify(agents));
                        CIRCULATION.utils.sendAjaxPost('Masters/CreateAgentGroups', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                location.reload();
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function (textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        var message = [];
                        if (!agGroupName) { message.push("Group Name"); }
                        if (!agents) { message.push("Agents"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });
                //DELETE Agent Groups
                $('#aggroup-tbl').on('click', '.del-agent-groups', function () {
                    var aggroupCode = $(this).attr("data-id");
                    var $tr = $(this).closest('tr');
                    if (aggroupCode) {
                        swal({
                            title: "",
                            text: "Are you sure delete?",
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
                                    formData.append("agent_group_code", aggroupCode);
                                    CIRCULATION.utils.sendAjaxPost('Masters/DeleteAgentGroups', formData, 'json',
                                    function (data) {
                                        CIRCULATION.utils.hideLoader();
                                        if (data.status === 200) {
                                            $tr.remove();
                                            if ($('#aggroup-tbl tbody tr').length == 0) {
                                                $('#aggroup-tbl tbody').html("<tr><td colspan='3' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>");
                                            }
                                            sweetAlert("", data.text, "success");
                                        } else {
                                            sweetAlert("Oops...", data.text, "error");
                                        }
                                    },
                                    function (textStatus, errorThrown) {
                                        CIRCULATION.utils.hideLoader();
                                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                    });
                                }
                            });
                    }
                });

                //View Agent Groups
                $('#aggroup-tbl').on('click', '.view-agent-groups', function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("agent_group_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewAgentGroups', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });

                //EDIT Agent Groups
                $('#aggroup-tbl').on('click', '.edit-agent-groups', function () {
                    $trRow = $(this).closest('tr');
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("agent_group_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/EditAgentGroups', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });

                //UPDATE Agent Groups
                $('body').on('click', '#updt-agent-groups', function () {
                    var error = 0, agents = [],
                        agentRec = {}, agentSelVal = '',
                        agGroupCode = $("#edt_aggroup_code").val().trim(),
                        agGroupName = $("#edt_aggroup_name").val().trim();
                    formData = new FormData();
                    $("#updt-agents-tbl").find('tr').each(function () {
                        var inputId = $(this).find(".agent").attr("id");
                        agentSelVal = $(this).find("#" + inputId + "_rec_sel").val();
                        agentRec = agentSelVal ? JSON.parse(decodeURIComponent(agentSelVal)) : '';
                        if (agentRec) agents.push(agentRec);
                    });
                    $("#edt_upld_agents_tbl").find('.up_agents:checked').each(function () {
                        agentSelVal = $(this).val();
                        agentRec = agentSelVal ? JSON.parse(decodeURIComponent(agentSelVal)) : '';
                        if (agentRec) agents.push(agentRec);
                    });
                    if (!agGroupName) {
                        $("#aggroup_name").addClass('haserror');
                        error++;
                    }
                    if (agents.length == 0) {
                        $("#edt_agent_1").addClass('haserror');
                        error++;
                    }
                    if (error > 0) return false;
                    if (agGroupCode && agGroupName && (agents || agListFile)) {
                        CIRCULATION.utils.showLoader();
                        formData.append("group_code", agGroupCode);
                        formData.append("group_name", agGroupName);
                        formData.append("agents_lists", JSON.stringify(agents));
                        CIRCULATION.utils.sendAjaxPost('Masters/CreateAgentGroups', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                $trRow.find('.aggroup-name').text(agGroupName.toUpperCase());
                                $('#common-modal').modal('toggle');
                                sweetAlert("", data.text, "success");
                            } else {
                                sweetAlert("Oops...", data.text, "error");
                            }
                        },
                        function (textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                        });
                    }
                    else {
                        var message = [];
                        if (!agGroupName) { message.push("Group Name"); }
                        if (!agents) { message.push("Agents"); }
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.REQUIREDFIELDS.fmt(message.join(",")), "error");
                    }
                });
            }
	        //Agent Search
            else if (page == 'AGENT-SEARCH') {
                
            } 
	        //Region-Master   
            else if (page == 'REGION-MASTER') {
                //edit Region Master
                $(".region-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("region_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewRegion', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //update region master
                $('body').on('click', '#update-region-details', function () {
                    var regCode = $("#p_reg_code").val().trim(),
                       regName = $("#p_reg_name").val().trim().toUpperCase(),
                        regStatus = $("#p_reg_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("regCode", regCode);
                    formData.append("regName", regName);
                    formData.append("regStatus", regStatus);

                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateRegion', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#region-table tbody button[data-id='" + regCode + "']").closest("tr");
                            $tblRow.find("td.reg-name").html(regName);
                            $tblRow.find("td.reg-status").html($("#p_reg_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            //holiday master
            else if (page == 'HOLIDAY-MASTER') {
                //edit button
                $(".holiday-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("holiCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewHoliday', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                    //bind-date-attributes
                    $("[data-mask]:not([readonly])").inputmask();
                    $('[data-mask]:not([readonly])').datepicker({
                        format: "dd-mm-yyyy",
                        autoclose: true,
                        todayHighlight: true,
                        toggleActive: true
                    });
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                // update
                $('body').on('click', '#update-holiday-details', function () {
                    var hldCode = $("#p_holiday_code").val().trim(),
                        hldDate = $("#p_holiday_date").val().trim(),
                       hldDesc = $("#p_holiday_desc").val().trim(),
                       hldoffice = $("#p_holiday_Office").val().trim(),
                        hldStatus = $("#p_holiday_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("hldCode", hldCode);
                    formData.append("hldDate", hldDate);
                    formData.append("hldDesc", hldDesc);
                    formData.append("hldoffice", hldoffice);
                    formData.append("hldStatus", hldStatus);
                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateHoliday', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#holiday-table tbody button[data-id='" + hldCode + "']").closest("tr");
                            $tblRow.find("td.hld-date").html(hldDate);
                            $tblRow.find("td.hld-desc").html(hldDesc);
                            $tblRow.find("td.hld-status").html($("#p_holiday_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            //subscriber master
            else if (page == 'SUBSCRIBER-MASTER') {
                $(".sub-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("subsCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewSubscriber', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //Update
                $('body').on('click', '#update-sub-details', function () {
                    var subCode = $("#p_sub_code").val().trim(),
                        subName = $("#p_sub_name").val().trim().toUpperCase(),
                        subAddress = $("#p_sub_address").val().trim(),
                        subPhn = $("#p_sub_mobile").val().trim(),
                        subEditon = $("#p_sub_edition_rec_sel").val().trim(),
                        subAgent = $("#p_sub_agent_rec_sel").val().trim(),
                        subStatus = $("#p_sub_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("subCode", subCode);
                    formData.append("subName", subName);
                    formData.append("subAddress", subAddress);
                    formData.append("subPhn", subPhn);
                    formData.append("subEditon", subEditon);
                    formData.append("subAgent", subAgent);
                    formData.append("subStatus", subStatus);

                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateSubscriber', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#subscribe-table tbody button[data-id='" + subCode + "']").closest("tr");
                            $tblRow.find("td.sub-name").html(subName);
                            $tblRow.find("td.sub-address").html(subAddress);
                            $tblRow.find("td.sub-phn").html(subPhn);
                            $tblRow.find("td.sub-edition").html($("#p_sub_edition_rec_sel").val());
                            $tblRow.find("td.sub-agent").html($("#p_sub_agent_rec_sel").val());
                            $tblRow.find("td.reg-status").html($("#p_sub_status option:selected").text());
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
            }
            //amendment reason master
            else if (page == 'AMENDMENT-REASON') {
                $("#submit_form").click(function () {
                    $("#amendment_form").submit();
                });

                $(".reason-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("resonCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewAmendmentReason', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                // update Amendment Reason
                $('body').on('click', '#update-reason-details', function () {
                    var reasonCode = $("#p_amnd_code").val().trim(),
                        reasonName = $("#p_amnd_name").val().trim().toUpperCase(),
                        reasonStatus = $("#p_amnd_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("reasonCode", reasonCode);
                    formData.append("reasonName", reasonName);
                    formData.append("reasonStatus", reasonStatus);

                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateAmendmentReason', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#amendment-table tbody button[data-id='" + reasonCode + "']").closest("tr");
                            $tblRow.find("td.resn-name").html(reasonName);
                            $tblRow.find("td.resn-status").html($("#p_amnd_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            //amendment type master
            else if (page == 'AMENDMENT-TYPE') {
                $(".type-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("typeCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewAmendmentType', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //Update Amendment type
                $('body').on('click', '#update-type-details', function () {
                    var typeCode = $("#p_amnd_type_code").val().trim(),
                        typeName = $("#p_amnd_type_name").val().trim().toUpperCase(),
                        typeStatus = $("#p_amnd_type_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("typeCode", typeCode);
                    formData.append("typeName", typeName);
                    formData.append("typeStatus", typeStatus);

                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateAmendmentType', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#amendment-type-table tbody button[data-id='" + typeCode + "']").closest("tr");
                            $tblRow.find("td.type-name").html(typeName);
                            $tblRow.find("td.type-status").html($("#p_amnd_type_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            //Wellwisher master
            else if (page == 'WELLWISHER-MASTER') {
                //edit
                $(".well-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("wellCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewWellWisher', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //Update Wellwisher
                $('body').on('click', '#update-well-details', function () {
                    var welCode = $("#p_well_code").val().trim(),
                        welName = $("#p_well_name").val().trim().toUpperCase(),
                        welPhn = $("#p_well_phone").val().trim(),
                        welLoc = $("#p_well_location").val().trim().toUpperCase(),
                        welRemark = $("#p_well_remarks").val().trim().toUpperCase(),
                        welStatus = $("#p_well_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("welCode", welCode);
                    formData.append("welName", welName);
                    formData.append("welPhn", welPhn);
                    formData.append("welLoc", welLoc);
                    formData.append("welRemark", welRemark);
                    formData.append("welStatus", welStatus);

                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateWellWisher', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#well_table tbody button[data-id='" + welCode + "']").closest("tr");
                            $tblRow.find("td.wel-name").html(welName);
                            $tblRow.find("td.wel-phon").html(welPhn);
                            $tblRow.find("td.wel-loc").html(welLoc);
                            $tblRow.find("td.type-status").html($("#p_well_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            else if (page == 'RESPONSE-MASTER') {
                //Edit
                $('#response_table').on('click', '.edit-btn', function (e) {
                    $currentRow = $(this).closest('tr');
                    $currentRow.attr("data-update", "true");
                    $currentRow.find(".res-text").removeAttr("disabled");
                    $currentRow.find(".res-text").attr("contenteditable", "true");
                    current_head = $currentRow.find(".res-text").text();

                });
                //Update Response Master
                $('#response_table').on('click', '.save-btn', function (e) {
                    var Code = $currentRow.find("td:eq(0)").text(),
                        head = $currentRow.find(".res-text").text();
                    if (head.trim() != '') {
                        var formData = new FormData();
                        formData.append("Code", Code);
                        formData.append("head", head);
                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateResponse', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            $currentRow.find(".res-text").html(head.toUpperCase());
                            $currentRow.attr('data-update', 'false');
                            $currentRow.find(".res-text").attr('disabled', 'disabled');
                            $currentRow.find(".res-text").attr("contenteditable", "false");
                            sweetAlert("", data.text, "success");
                        } else if (data.status === 400) {
                            $currentRow.find(".res-text").html(head.toUpperCase());
                            $currentRow.attr('data-update', 'false');
                            $currentRow.find(".res-text").attr('disabled', 'disabled');
                            $currentRow.find(".res-text").attr("contenteditable", "false");
                            sweetAlert("", data.text, "warning");
                        }

                    },
                    function (textStatus, errorThrown) {
                        $currentRow.attr('data-update', 'false');
                        $currentRow.find(".res-text").attr('disabled', 'disabled');
                        $currentRow.find(".res-text").attr("contenteditable", "false");
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                    }
                    else {
                        sweetAlert("", "Please fill the field", "warning");
                        $currentRow.find(".res-text").html(current_head);
                    }
                });
                //Cancel
                $('#response_table').on('click', '.cancel-btn', function (e) {
                    $currentRow.attr('data-update', 'false');
                    $currentRow.find(".res-text").attr('disabled', 'disabled');
                    $currentRow.find(".res-text").attr("contenteditable", "false");
                    $currentRow.find(".res-text").html(current_head);
                });
                function toTitleCase(str) {
                    return str.replace(/\w\S*/g, function (txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); });
                }
                $("#form_status").submit(function () {
                    var err = 0,
                        st_head = $("#response_head").val();
                    if (st_head.trim() == '') {
                        $("#response_head").addClass("haserror");
                        err++;
                    }
                    if (err > 0) {
                        return false;
                    }
                    else {
                        return true;
                    }
                });
            }
            else if (page == 'STATUS-MASTER') {
                var $currentRow = '', current_head = ''; //global
                //edit
                $('#status_table').on('click', '.edit-btn', function (e) {
                    $currentRow = $(this).closest('tr');
                    $currentRow.attr("data-update", "true");
                    $currentRow.find(".res-text").removeAttr("disabled");
                    $currentRow.find(".res-text").attr("contenteditable", "true");
                    current_head = $currentRow.find(".res-text").text();
                });
                //Update
                $('#status_table').on('click', '.save-btn', function (e) {
                    var Code = $currentRow.find("td:eq(0)").text(),
                        head = $currentRow.find(".res-text").text();
                    if (head.trim() != '') {
                        $('.loaderDiv').removeClass('hide');
                        var formData = new FormData();
                        formData.append("Code", Code);
                        formData.append("head", head);
                        CIRCULATION.utils.sendAjaxPost('Masters/UpdateEntryStatus', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            if (data.status === 200) {
                                $currentRow.find(".res-text").html(head.toUpperCase());
                                $currentRow.attr('data-update', 'false');
                                $currentRow.find(".res-text").attr('disabled', 'disabled');
                                $currentRow.find(".res-text").attr("contenteditable", "false");
                                sweetAlert("", data.text, "success");
                            } else {
                                $currentRow.find(".res-text").html(head.toUpperCase());
                                $currentRow.attr('data-update', 'false');
                                $currentRow.find(".res-text").attr('disabled', 'disabled');
                                $currentRow.find(".res-text").attr("contenteditable", "false");
                                sweetAlert("", data.text, "warning");
                            }
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        $currentRow.attr('data-update', 'false');
                        $currentRow.find(".res-text").attr('disabled', 'disabled');
                        $currentRow.find(".res-text").attr("contenteditable", "false");
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                    }
                    else {
                        sweetAlert("", "Please fill the field", "warning");
                        $currentRow.find(".res-text").html(current_head);
                    }
                });
                $('#status_table').on('click', '.cancel-btn', function (e) {
                    $currentRow.attr('data-update', 'false');
                    $currentRow.find(".res-text").attr('disabled', 'disabled');
                    $currentRow.find(".res-text").attr("contenteditable", "false");
                    $currentRow.find(".res-text").html(current_head);
                });
            }
            else if (page == 'SPONSOR-MASTER') {
                //edit
                $(".sponsor-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("clientCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewSponsor', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //Update
                $('body').on('click', '#update-sponsor-details', function () {
                    var spCode = $("#p_sp_code").val().trim(),
                        spName = $("#p_sp_name").val().trim().toUpperCase(),
                        spAddress = $("#p_sp_address").val().trim(),
                        spPhn = $("#p_sp_mobile").val().trim(),
                        spStatus = $("#p_sp_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("spCode", spCode);
                    formData.append("spName", spName);
                    formData.append("spAddress", spAddress);
                    formData.append("spPhn", spPhn);
                    formData.append("spStatus", spStatus);

                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateSponsor', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#sponsor-table tbody button[data-id='" + spCode + "']").closest("tr");
                            $tblRow.find("td.sp-name").html(spName);
                            $tblRow.find("td.sp-address").html(spAddress);
                            $tblRow.find("td.sp-phn").html(spPhn);
                            $tblRow.find("td.sp-status").html($("#p_sp_status option:selected").text());
                            $('#common-modal').modal('toggle');
                           sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });
            }
            else if (page == 'BANK-MASTER') {
                //edit
                $(".bank-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("bnktCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Masters/ViewBankMaster', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //Update
                $('body').on('click', '#update-bank-details', function () {
                    var bnkCode = $("#p_bnk_code").val().trim(),
                        bnkName = $("#p_bank_name").val().trim().toUpperCase(),
                        bnkLoc = $("#p_bank_loc").val().trim().toUpperCase(),
                        bnkStatus = $("#p_bnk_status").val().trim(),
                        formData = new FormData();
                    CIRCULATION.utils.showLoader();
                    formData.append("bnkCode", bnkCode);
                    formData.append("bnkName", bnkName);
                    formData.append("bnkLoc", bnkLoc);
                    formData.append("bnkStatus", bnkStatus);
                    CIRCULATION.utils.sendAjaxPost('Masters/UpdateBankMaster', formData, 'json',
                    function (data) {
                        CIRCULATION.utils.hideLoader();
                        if (data.status === 200) {
                            var $tblRow = $("#bank-table tbody button[data-id='" + bnkCode + "']").closest("tr");
                            $tblRow.find("td.bnk-name").html(bnkName);
                            $tblRow.find("td.bnk-loc").html(bnkLoc);
                            $tblRow.find("td.sp-status").html($("#p_bnk_status option:selected").text());
                            $('#common-modal').modal('toggle');
                            sweetAlert("", data.text, "success");
                            //location.reload(true)
                        } else {
                            sweetAlert("Oops...", data.text, "error");
                        }
                    },
                    function (textStatus, errorThrown) {
                        CIRCULATION.utils.hideLoader();
                        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                    });
                });

            }
        }
    }
})();
