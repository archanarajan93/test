/*
*Author: Kaumudy
*Date: 14-09-2020
*Description: util.js serves common methods
*/
var EMPLOYEE = EMPLOYEE || {};
$(document).ready(function () {
    EMPLOYEE.utils.init();
});
String.prototype.fmt = function () {
    var s = this,
        i = arguments.length;
    while (i--) {
        s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
    }
    return s;
};
EMPLOYEE.utils = (function () {
    /***************
    *Private Region*
    ****************/
    var transliterationControl = {};
    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            
            $('body').on('click', '.haserror', function () {
                $(this).removeClass('haserror');
            });

        },
        
        hideLoader: function () {
            $("#process_loader,#process_loader_bg").addClass('hide');
        },   
        sendAjaxPost: function (url, formData, resType, successCallback, errorCallback) {
            $.ajax({
                type: 'POST',
                url: url.indexOf('http') === -1 ? (baseUrlACCS + url) : url,
                data: formData,
                dataType: resType,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: successCallback,
                error: errorCallback
            });
        },
        sendAjaxGet: function (url, formData, resType, successCallback, errorCallback) {
            $.ajax({
                type: 'GET',
                url: url.indexOf('http') === -1 ? (baseUrlACCS + url) : url,
                data: formData,
                dataType: resType,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: successCallback,
                error: errorCallback
            });
        },
        showLoader: function (a) {
            $("#process_loader,#process_loader_bg").removeClass('hide');
        },        
        
        formValidation: function (form) {
            var errorCount = 0, requiredSubsidaries = '', subsidaryValue = '', isSubsidaryMissing = false, dateFormat = '', inputValue='',
                $form = $(form);
            $form.find('input[required],select[required],textarea[required]').each(function () {
                requiredSubsidaries = $(this).attr('data-required');
                inputValue = $(this).val();
                isSubsidaryMissing = false;
                if (requiredSubsidaries) {
                    subsidaryValue = $('.' + requiredSubsidaries).val();
                    isSubsidaryMissing = subsidaryValue ? subsidaryValue.trim() == '' : true;
                }
                if (!inputValue || $.trim(inputValue) == '' || isSubsidaryMissing) {
                    if ($(this).hasClass('select2')) {
                        $(this).next(".select2-container").addClass('haserror');
                        $(this).next(".select2-container").find(".select2-selection").addClass('haserror');
                    }
                    $(this).addClass('haserror');
                    errorCount++;
                } else {
                    if ($(this).hasClass('select2')) {
                        $(this).next(".select2-container").removeClass('haserror');
                        $(this).next(".select2-container").find(".select2-selection").removeClass('haserror');
                    }
                    $(this).removeClass('haserror');
                }
            });
            $form.find('input[data-required]').each(function () {
                requiredSubsidaries = $(this).attr('data-required');
                isSubsidaryMissing = false;
                if (requiredSubsidaries) {
                    subsidaryValue = $('.' + requiredSubsidaries).val();
                    isSubsidaryMissing = subsidaryValue ? subsidaryValue.trim() == '' : true;
                }
                if (isSubsidaryMissing) {
                    $(this).addClass('haserror');
                    errorCount++;
                } else { $(this).removeClass('haserror'); }
            });
            $form.find('input[type=email]').each(function () {
                var $currentInput = $(this),
                    required = $currentInput.attr("required"),
                    regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (regex.test(required.val()) == false) {
                    $currentInput.addClass('haserror');
                    errorCount++;
                } else {
                    $currentInput.removeClass('haserror');
                }
            });
            $form.find('input[data-datemask]').each(function () {
                dateFormat = $(this).attr("data-datemask");
                subsidaryValue = $(this).val();
                if (subsidaryValue == '') {
                    var required = $(this).attr("required");
                    if (typeof required !== typeof undefined && required !== false) {
                        $(this).addClass('haserror');
                        errorCount++;
                    }
                } else {
                    var fromSelector = $(this).attr("data-from"),
                        currentMoment = moment(subsidaryValue, dateFormat, true);
                    if (!currentMoment.isValid()) {
                        $(this).addClass('haserror');
                        errorCount++;
                    } else if (typeof fromSelector !== typeof undefined && fromSelector !== false
                                && moment($(fromSelector).val(), dateFormat).valueOf() > currentMoment.valueOf()) {
                        $(this).addClass('haserror');
                        errorCount++;
                    }
                }
            });
            $form.find('select[data-PageCompare]').each(function () {
                var pageCompareFirst = $(this).attr("id"),
                    pageCompareSec = $(this).attr("data-Sec");
                if($("#"+pageCompareFirst).val() > $(pageCompareSec).val())
                {
                    $(this).addClass('haserror');
                    errorCount++;
                }
            });
            $form.find('input[data-month_compare]').each(function () {
                var $this = $(this),
                    dateFrom = (moment($("#" + $this.attr("id")).val(), 'DD-MM-YYYY')).format('YYYY-MM-DD'),
                    dateTo = (moment($($this.attr("data-sec")).val(), 'DD-MM-YYYY')).format('YYYY-MM-DD');

                if (moment(dateFrom).isSame(dateTo, 'month') === false) {
                    errorCount++;
                    $($this.attr("data-sec")).addClass("haserror");
                }
            });
            $form.find('.isAlpha').each(function () {
                inputValue = $(this).val();
                if (inputValue && !/^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/.test(inputValue)) {
                    $(this).addClass('haserror');
                    errorCount++;
                }
            });
            $form.find('.isMob').each(function () {
                inputValue = $(this).val();
                if (inputValue && !/^[0-9,]+$/.test(inputValue)) {
                    $(this).addClass('haserror');
                    errorCount++;
                }
            });
            var compDateLists = $form.find("input[data-compare]");
            compDateLists.each(function () {
                var CompareDate = $(this);
                var from_date = moment(CompareDate.val(), "DD/MM/YYYY").valueOf(), //date1
                       to_date = moment($(CompareDate.attr("data-compare")).val(), "DD/MM/YYYY").valueOf(); //date2
                var isGreater = (CompareDate.attr("data-greater") || false);
                    if (isGreater) {
                        if (from_date >= to_date) {
                            $(CompareDate).addClass("haserror");
                            errorCount++;
                        }
                    } else {
                        if (from_date <= to_date) {
                            //return true;
                        } else {
                            $(CompareDate).addClass("haserror");
                            errorCount++;
                        }
                    }
            }); 
            if (parseInt(errorCount) > 0) {
                return false;
            }
            else {
                return true;
            }
        },
        registerMethods: function () {
            if (page == 'EMPLOYEE-REGISTRATION') {
                EMPLOYEE.regitration.init();
            } 
        }
    }
})();