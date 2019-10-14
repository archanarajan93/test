var CIRCULATION = CIRCULATION || {};
CIRCULATION.admintools = (function () {
    /***************
    *Private Region*
    ****************/

    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            new HelpController({
                fields: '#employee_name,#copy_type',
                fieldBtns: '#employee_name_search,#copy_type_search'
            });

            //$("[data-mask]:not([readonly])").inputmask();
            //$('[data-mask]:not([readonly])').datepicker({
            //    format: "dd-mm-yyyy",
            //    autoclose: true,
            //    todayHighlight: true,
            //    toggleActive: true
            //});
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

            if (page == 'USER-SEARCH' || page == 'USER-CREATE') {
                $(".select2").select2();
		
                //check username availability
                $('body').on("click", "#check-availability", function () {
                    CIRCULATION.utils.showLoader();
                    var login_name = $("#user_login_name").val();
                    formData = new FormData();
                    formData.append("login_name", login_name);                                 
                    CIRCULATION.utils.sendAjaxPost('AdminTools/LoginNameAvailable', formData, 'json',
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

                    CIRCULATION.utils.sendAjaxPost('AdminTools/ShowUserDetails', formData, 'html',
                    function successCallBack(data) {
                        $('#common-modal-body').html(data);
                        $(".select2").select2();
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
                        uMenuPer       = $("#menu_permission").val(),
                        uSubMenuPer    = $("#sub_menu_permission").val(),
                        formData = new FormData();
                    if (uId && uLoginName && uLoginPass && uUnitCode && uEmployeeData && unitPermission && prodPermission) {
                        CIRCULATION.utils.showLoader();
                        formData.append("user_id", uId);
                        formData.append("user_login_name", uLoginName);
                        formData.append("user_login_password", uLoginPass);
                        formData.append("user_unit_code", uUnitCode);
                        formData.append("employee_name_rec_sel", uEmployeeData);
                        formData.append("menu_permission", JSON.stringify(uMenuPer));
                        formData.append("sub_menu_permission", JSON.stringify(uSubMenuPer));
                        
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

                        CIRCULATION.utils.sendAjaxPost('AdminTools/UpdateUser', formData, 'json',
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
            //copy-master
            else if (page == 'COPY-MASTER') {
                //edit button click
                $('#copy-table tbody').on('click', '.edit-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $('#product-table tbody tr[data-save="true"]').attr('data-save', 'false').find('.form-control').prop('disabled', true);
                    $currentRow.attr('data-save', true);
                    $currentRow.find('.form-control').prop('disabled', false);
                    $currentRow.find('.text-success,.text-danger').addClass("hidden");
                });
                //save button click
                $('#copy-table tbody').on('click', '.save-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                        copyName = $currentRow.find('.copy_name').val().toUpperCase(),
                        copyCode = $currentRow.attr("data-cpyid");
                    var formData = new FormData();
                    formData.append("copy_code", copyCode);
                    formData.append("copy_name", copyName);
                    if ($.trim(copyName) != '') {
                        CIRCULATION.utils.showLoader();
                        CIRCULATION.utils.sendAjaxPost('AdminTools/UpdateCopyMaster', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                sweetAlert("", data.text, "success");
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
                    } else {
                        sweetAlert("Oops...", "Copy Name is mandatory!", "error");
                    }
                });
                //cancel button click 
                $('#copy-table tbody').on('click', '.cancel-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $currentRow.find('.product_name').val($currentRow.find('.product_name').attr("data-val"));
                    $currentRow.attr('data-save', false);
                    $currentRow.find('.form-control').prop('disabled', true);
                });
                //Delete button click
                $('#copy-table tbody').on('click', '.del-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                         copyCode = $currentRow.attr("data-cpyid");

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
                            formData.append("copy_code", copyCode);
                            CIRCULATION.utils.sendAjaxPost('AdminTools/DeleteCopyMaster', formData, 'json',
                            function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    sweetAlert("", data.text, "success");
                                    $currentRow.remove();
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
                });
            }
            //copy-group
            else if (page == 'GROUP-COPY') {
                //edit copy group master
                $(".grp-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("goup_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('AdminTools/ViewCopyGroup', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //cancel button click 
                $('#group-table tbody').on('click', '.cancel-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $currentRow.attr('data-save', false);
                    $currentRow.find('.form-control').prop('disabled', true);
                });
                //Delete button click
                $('#group-table tbody').on('click', '.del-btn', function (e) {
                     //$currentRow = $(this).closest('tr'),
                    var $del_group_code = $(this).attr("data-id");

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
                            formData.append("del_group_code", $del_group_code);
                            $.ajax({
                                type: 'POST',
                                url: baseUrlPMD + 'AdminTools/DeleteCopyGroup',
                                data: formData,
                                dataType: 'json',
                                processData: false,  // tell jQuery not to process the data
                                contentType: false, // tell jQuery not to set contentType
                                success: function (data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 200) {
                                        //$currentRow.remove();
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
                //Update copy group

                $('body').on('click', '#update-grp-details', function () {
                    var grpCode = $("#p_group_code").val().trim(),
                        grpName = $("#p_grp_name").val().trim(),
                        copyCode = $("#p_copy_code").val().trim(),
                        grpStatus = $("#p_grp_status").val().trim(),
                        formData = new FormData();
                    if (grpName && copyCode && grpStatus && grpCode) {
                        CIRCULATION.utils.showLoader();
                        formData.append("grpCode", grpCode);
                        formData.append("grpName", grpName);
                        formData.append("copyCode", copyCode);
                        formData.append("grpStatus", grpStatus);
                        CIRCULATION.utils.sendAjaxPost('AdminTools/UpdateCopyGroups', formData, 'json',
                function successCallBack(data) {
                    CIRCULATION.utils.hideLoader();
                    if (data.status === 200) {
                        var $tblRow = $("#group-table tbody button[data-id='" + grpCode + "']").closest("tr");
                        $tblRow.find("td.group-name").html(grpName);
                        $tblRow.find("td.copy-name").html($("#p_copy_code option:selected").text());
                        $tblRow.find("td.group-status").html($("#p_grp_status option:selected").text());
                        $('#common-modal-body').html(data);
                        $('#common-modal').modal('toggle');
                        sweetAlert("", data.text, "success");
                    } else {
                        sweetAlert("Oops...", data.text, "error");
                    }
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                       });
                    }

                });
            }
            //unit master
            else if (page == 'UNIT-MASTER') {
                //edit button click 
                $('#unit-table tbody').on('click', '.edit-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $('#unit-table tbody tr[data-save="true"]').attr('data-save', 'false').find('input[type="text"]').prop('disabled', true);
                    $currentRow.attr('data-save', true);
                    $currentRow.find('.unitname').prop('disabled', false);
                });
                //cancel button click 
                $('#unit-table tbody').on('click', '.cancel-btn', function (e) {
                    var $currentRow = $(this).closest('tr');
                    $currentRow.attr('data-save', false);
                    $currentRow.find('.form-control').prop('disabled', true);
                });
                //save button click
                $('#unit-table tbody').on('click', '.save-btn', function (e) {
                    var error = 0;
                    var $currentRow = $(this).closest('tr'),
                    unitCode = $.trim($currentRow.find(".unitcode").val()),
                    unitName = $.trim($currentRow.find(".unitname").val()),
                    formData = new FormData();
                    formData.append("unit_code", unitCode);
                    formData.append("unit_name", unitName);
                    if ($.trim(unitName) != '') {
                        CIRCULATION.utils.showLoader();
                        $.ajax({
                            type: 'POST',
                            url: baseUrlPMD + 'AdminTools/UpdateUnit',
                            data: formData,
                            dataType: 'json',
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,   // tell jQuery not to set contentType
                            success: function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
                                    sweetAlert("", data.text, "success");
                                    $currentRow.find(".unitname").val(unitName);
                                    $currentRow.attr('data-save', false);
                                    $currentRow.find('input[type="text"]').prop('disabled', true);
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
                    else {
                        sweetAlert("Oops...", "Unit Name is mandatory!", "error");
                    }
                });
                //Delete button click
                $('#unit-table tbody').on('click', '.del-btn', function (e) {
                    var $currentRow = $(this).closest('tr'),
                        unit_code = $currentRow.find(".unitcode").val();

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
                            formData.append("unit_code", unit_code);
                            $.ajax({
                                type: 'POST',
                                url: baseUrlPMD + 'AdminTools/DeleteUnit',
                                data: formData,
                                dataType: 'json',
                                processData: false,  // tell jQuery not to process the data
                                contentType: false,   // tell jQuery not to set contentType
                                success: function (data) {
                                    CIRCULATION.utils.hideLoader();
                                    if (data.status === 200) {
                                        $currentRow.remove();
                                        sweetAlert("", data.text, "success");
                                    } else {
                                        sweetAlert("", data.text, "error");
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
            //Rate Master
            else if (page == 'RATE-MASTER') {
                var $currentRow = '';
                $("#copy_group_code").change(function () {
                    $("#copy_type").val('');
                    $(".copy_type_clr").val('');
                });
                //save sales amount
                $('.content').on('click', '#save-sales-rates', function (e) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to update this.",
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
                            var copyRate = parseFloat($("#copy_rate").val()),
                                sunCopyRate = parseFloat($("#sunday_copy_rate").val()),
                                ekCopyRate = parseFloat($("#ek_copy_rate").val());

                            CIRCULATION.utils.showLoader();
                            var formData = new FormData();
                            formData.append("copy_rate", copyRate);
                            formData.append("sunday_copy_rate", sunCopyRate);
                            formData.append("ek_copy_rate", ekCopyRate);
                            CIRCULATION.utils.sendAjaxPost('AdminTools/SaveSalesCopyRate', formData, 'json',
                            function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
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
                });
                //EDIT Rate Master scheme
                $('#schrate-tbl').on('click', '.edit-sch-rates', function () {
                    $currentRow = $(this).closest('tr');
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("rate_code", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('AdminTools/EditSchemeCopyRate', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //Update scheme rates
                $('.modal-content').on('click', '#update-scheme-rates', function (e) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to update this.",
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
                            var rateCode = $("#edt_rate_code").val(),
                                schYears = parseInt($("#edt_years").val()),
                                schMonths = parseInt($("#edt_months").val()),
                                schDays = parseInt($("#edt_days").val()),
                                schRate = parseFloat($("#edt_rate").val());
                            if (!rateCode || !schRate) {
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                return false;
                            }
                            CIRCULATION.utils.showLoader();
                            var formData = new FormData();
                            formData.append("rate_code", rateCode);
                            formData.append("years", schYears);
                            formData.append("months", schMonths);
                            formData.append("days", schDays);
                            formData.append("rate", schRate);
                            CIRCULATION.utils.sendAjaxPost('AdminTools/UpdateSchemeCopyRate', formData, 'json',
                            function (data) {
                                CIRCULATION.utils.hideLoader();
                                $("#common-modal").modal('toggle');
                                if (data.status === 200) {
                                    var duration = '';
                                    if (schYears) duration += schYears + " yrs ";
                                    if (schMonths) duration += schMonths + " mnths ";
                                    if (schDays) duration += schDays + " days";
                                    $currentRow.find(".schrate-dur").text(duration);
                                    $currentRow.find(".schrate-amt").text(schRate);
                                    sweetAlert("", data.text, "success");
                                } else {
                                    sweetAlert("Oops...", data.text, "error");
                                }
                            },
                            function (textStatus, errorThrown) {
                                $("#common-modal").modal('toggle');
                                CIRCULATION.utils.hideLoader();
                                sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                            });
                        }
                    });
                });
                //save other products amount
                $('.content').on('click', '#other-prdt-rates', function (e) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to update this.",
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
                            var otherPrdtRates = [];
                            $("input.other_prdt").each(function () {
                                otherPrdtRates.push({ "prdt_code": $(this).attr("data-prdtcode"), "amount": parseFloat($(this).val()) });
                            });

                            CIRCULATION.utils.showLoader();
                            var formData = new FormData();
                            formData.append("other_prdt_rates", JSON.stringify(otherPrdtRates));
                            CIRCULATION.utils.sendAjaxPost('AdminTools/SaveOtherPrdtsRate', formData, 'json',
                            function (data) {
                                CIRCULATION.utils.hideLoader();
                                if (data.status === 200) {
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
                });

            }
        }
    }
})();
