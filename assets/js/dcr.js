var CIRCULATION = CIRCULATION || {};
CIRCULATION.DCR = (function () {
    /***************
    *Private Region*
    ****************/    
    
    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            new HelpController({
                fields: '',
                fieldBtns: ''
            });

            if (page == 'DCR') {

                $("[data-mask]").inputmask();
                $('[data-mask]').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });

                //on change work type
                $("#type-of-work").change(function () {
                    $('.cont-div').addClass("hide");
                    $('.cont-div').find("input.form-control").not('.avoid-clr').val('');
                    $("#div-" + $(this).val()).removeClass("hide");
                });


                //save button click
                //$('#common-modal-body').on('click', '#update-schedule', function (e) {
                //    var $thisRec = $(this),
                //        cat_code = $thisRec.attr("data-id"),
                //        cat_name = $('#award_cat_name').val();
                //    formData = new FormData();
                //    formData.append("cat_code", cat_code); 
                //    formData.append("cat_name", cat_name);
                //    //success call back ajax
                //    function successCallBack(data) {
                //        CIRCULATION.utils.hideLoader();
                //        $('#common-modal').modal('toggle');
                //        if (data.status === 200) {
                //            sweetAlert("", data.text, "success");
                //            //window.location.href = baseUrlNT + 'Awards/CategoryMaster';
                //        } else {
                //            sweetAlert("Oops...", data.text, "error");
                //        }
                //    }
                //    //error call back ajax
                //    function errorStatus(textStatus, errorThrown) {
                //        CIRCULATION.utils.hideLoader();
                //        sweetAlert("Oops...", CIRCULATION.Text.en_US.ERROR, "error");
                //    } 
                //    CIRCULATION.utils.sendAjaxPost('Awards/UpdateAwardCategory', formData, 'json', successCallBack, errorStatus);
                //});
            }
        }
    }
})();
