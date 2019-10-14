/*
*Author: Kaumudy
*Date: 19-10-2017
*Desc:  
*/
var CIRCULATION = CIRCULATION || {};
CIRCULATION.tools = (function () {
    /***************
    *Private Region*
    ****************/    
    
    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            if (page == 'CHANGE-PRODUCT') {
                $(".select-product").click(function () {
                    var pId = $(this).attr("data-prod");
                    if (pId) {
                        swal({
                            title: "",
                            text: "Are you sure to change product? All opened tabs will be refreshed.",
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
                                formData.append("product", pId);
                                CIRCULATION.utils.sendAjaxPost('Tools/UpdateProduct', formData, 'json',
                                function successCallBack(data) {                                    
                                    if (data.status === 200) {
                                        CIRCULATION.utils.redirectPage(userId, 'Dashboard');
                                    } else {
                                        CIRCULATION.utils.hideLoader();
                                        sweetAlert("Oops...", data.text, "error");
                                    }
                                },
                                function errorStatus(textStatus, errorThrown) {
                                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                });
                            }
                        });
                    }
                });                
            }
            else if (page == 'CHANGE-UNIT') {
                $(".select-unit").click(function () {
                    var uId = $(this).attr("data-unit");
                    if (uId) {
                        swal({
                            title: "",
                            text: "Are you sure to change unit? All opened tabs will be refreshed.",
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
                                formData.append("unit", uId);
                                CIRCULATION.utils.sendAjaxPost('Tools/UpdateUnit', formData, 'json',
                                function successCallBack(data) {
                                    if (data.status === 200) {
                                        CIRCULATION.utils.redirectPage(userId, 'Dashboard');
                                    } else {
                                        CIRCULATION.utils.hideLoader();
                                        sweetAlert("Oops...", data.text, "error");
                                    }
                                },
                                function errorStatus(textStatus, errorThrown) {
                                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                                });
                            }
                        });
                    }
                });
            }
                //Set Bonus Date
            else if (page == 'SET-BONUS-DATE') {
                //month picker
                $(".monthpicker").datepicker({ 
                    format: "MM-yyyy",
                    startView: "months",
                    minViewMode: "months",
                    autoclose: true
                }).on('changeDate', function () {
                    var selectedMonth = $(this).val(); 
                    var currentDate = moment('01-' + selectedMonth, "DD-MMMM-YYYY");
                    var startDate = new Date(currentDate.startOf('month').toDate());
                    var endDate = new Date(currentDate.endOf('month').toDate());
                    //date picker
                    $('[data-mask]:not([readonly])').datepicker('remove');
                    $("[data-mask]:not([readonly])").inputmask();
                    $('[data-mask]:not([readonly])').datepicker({
                        format: "dd-mm-yyyy",
                        autoclose: true,
                        startDate: startDate,
                        endDate: endDate
                    });
                });
                $("#select_month").change(function () {
                    $("#bonus_2,#bonus_1_5,#bonus_1").val('');
               
                });
                //edit set bonus date
                $(".bonus-edit-btn").click(function () {
                    $('#common-modal-body').html('<img src="' + baseUrlPMD + 'assets/imgs/loading.gif" style="margin: 0 auto;display: -webkit-box;" />');
                    $("#common-modal").modal();
                    var formData = new FormData();
                    formData.append("bonusCode", $(this).attr("data-id"));
                    CIRCULATION.utils.sendAjaxPost('Tools/SaveBonusDateEdit', formData, 'html',
                function successCallBack(data) {
                    $('#common-modal-body').html(data);
                    $(".monthpicker").datepicker({
                        format: "MM-yyyy",
                        startView: "months",
                        minViewMode: "months",
                        autoclose: true
                    }).on('changeDate', function () {
                        var selectedMonth = $(this).val();
                        triggerChange(selectedMonth);
                    });
                    function triggerChange(selectedMonth) {
                        var currentDate = moment('01-' + selectedMonth, "DD-MMMM-YYYY");
                        var startDate = new Date(currentDate.startOf('month').toDate());
                        var endDate = new Date(currentDate.endOf('month').toDate());
                        //date picker
                        $('[data-mask]:not([readonly])').datepicker('remove');
                        $("[data-mask]:not([readonly])").inputmask();
                        $('[data-mask]:not([readonly])').datepicker({
                            format: "dd-mm-yyyy",
                            autoclose: true,
                            startDate: startDate,
                            endDate: endDate
                        });
                    }
                    var selectedMonth = $("#p_bonus_month").val();
                    triggerChange(selectedMonth);
                },
                function errorStatus(textStatus, errorThrown) {
                    $("#common-modal").modal('toggle');
                    sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                });
                });
                //update set bonus date
                $('body').on('click', '#update-bonus-details', function () {
                    var bonusCode = $("#p_bonus_date_code").val().trim(),
                        bonusDateFrst = $("#p_bonus_2_date").val().trim().toUpperCase(),
                        bonusDateSec = $("#p_bonus_5_date").val().trim(),
                        bonusDateThrd = $("#p_bonus_1_date").val().trim().toUpperCase(),
                        bonusMonth = $("#p_bonus_month").val().trim().toUpperCase(),
                        formData = new FormData(),
                        isValid = CIRCULATION.utils.formValidation($("#p_bonus_form"));
                    if (isValid) {
                        CIRCULATION.utils.showLoader();
                        formData.append("bonusCode", bonusCode);
                        formData.append("bonusDateFrst", bonusDateFrst);
                        formData.append("bonusDateSec", bonusDateSec);
                        formData.append("bonusDateThrd", bonusDateThrd);
                        formData.append("bonusMonth", bonusMonth);
                        CIRCULATION.utils.sendAjaxPost('Tools/UpdateSetBonusDate', formData, 'json',
                        function (data) {
                            CIRCULATION.utils.hideLoader();
                            if (data.status === 200) {
                                var $tblRow = $("#set-bonus-date-table tbody button[data-id='" + bonusCode + "']").closest("tr");
                                $tblRow.find("td.bonus-month").html(bonusMonth);
                                $tblRow.find("td.bonus-first-per").html(bonusDateFrst);
                                $tblRow.find("td.bonus-sec-per").html(bonusDateSec);
                                $tblRow.find("td.bonus-third-per").html(bonusDateThrd);
                                $tblRow.find("td.bonus-month").html(bonusMonth);
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
                    }

                    
                });
            }
            else if (page == 'BILL-GENERATE') {
                $("#bill-gen-btn").click(function () {
                    swal({
                        title: "",
                        text: "Are you sure to generate bill for this period.",
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
                               CIRCULATION.utils.sendAjaxPost('Tools/GenerateAgentBills', formData, 'json',
                               function successCallBack(data) {
                                   CIRCULATION.utils.hideLoader();
                                   if (data.status === 200) {
                                       sweetAlert("", data.text, "success");
                                   } else {
                                       CIRCULATION.utils.hideLoader();
                                       sweetAlert("Oops...", data.text, "error");
                                   }
                               },
                               function errorStatus(textStatus, errorThrown) {
                                   sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                               });
                           }
                       });
                });
            }
        }       
    }
})();
