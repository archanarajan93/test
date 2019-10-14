/*
*Author: Kaumudy
*Date: 19-10-2017
*Description: util.js serves common methods
*/
var CIRCULATION = CIRCULATION || {};
$(document).ready(function () {
    CIRCULATION.utils.init();
});
String.prototype.fmt = function () {
    var s = this,
        i = arguments.length;
    while (i--) {
        s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
    }
    return s;
};
CIRCULATION.utils = (function () {
    /***************
    *Private Region*
    ****************/
    var inputFocusId = '';   
    function validationRemove()
    {
        $('body').on("click", "input[required]", function () {
            $(this).removeClass("haserror");
        });
    }
    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            //var timeZone = jstz.determine().name(),
            //    userTZ = CIRCULATION.utils.getCookie("USERTZ");
            //if (userTZ != timeZone) {
            //    CIRCULATION.utils.setCookie("USERTZ", timeZone, 5);
            //}
            CIRCULATION.utils.registerMethods();
            $(window).scroll(function () {//scroll to top
                if ($(this).scrollTop() > 80) {
                    $('.scrollup').fadeIn();                  
                } else {
                    $('.scrollup').fadeOut();
                }
            });
            $('.scrollup').click(function () {
                $("html, body").animate({
                    scrollTop: 0
                }, 600);
                return false;
            });
            //Scroll Header
            var tableWrapper = $(".table-help");
            CIRCULATION.utils.fixTableHeader(tableWrapper, 470);
            $('body').on('click, focus', 'input', function () {
                $(this).select();
            });
            $('body').on('click', '.input-group-addon', function () {
                $(this).closest('.input-group').find('input').focus();
            });
            $('body').on('click', '#customalert-btn', function () {
                $("#html-modal").modal('hide');
            });
            $('body').on('click', '.errclose', function () { $(this).closest('.errbox').remove(); });
            /*#script: Input to Accept Numbers Only*/
            $('body').on('keydown', '.isNumberKey', function (e) {
                if ($(this).hasClass('isMob') && e.keyCode == 188) return;
                if ($(this).attr('isDecimal') == 'true' && (e.keyCode == 110 || e.keyCode == 190)) return;
                // Allow: backspace, delete, tab, escape, enter // DOT KEY CODE 110, 190
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: Ctrl+C
                    (e.keyCode == 67 && e.ctrlKey === true) ||
                    // Allow: Ctrl+X
                    (e.keyCode == 88 && e.ctrlKey === true) ||
                    // Allow: Ctrl+V
                    (e.keyCode == 86 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            /*#script: Input to Accept Numbers Only*/
            $('body').on('keydown', '.isAlpha', function (e) {
                if (e.keyCode === 222) { e.keyCode = 0; e.preventDefault();}
                // Allow: backspace, delete, tab, escape, enter // DOT KEY CODE 110, 190
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13,32]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: Ctrl+C
                    (e.keyCode == 67 && e.ctrlKey === true) ||
                    // Allow: Ctrl+X
                    (e.keyCode == 88 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if (e.shiftKey || !(e.keyCode >= 65 && e.keyCode <= 90)) {
                    e.preventDefault();
                }
                $(this).val($(this).val().replace(/['"]/g, ''));
            });
            $('body').on('keydown', 'input,select,textarea', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    e.stopPropagation();
                    var tabIndex = parseInt($(this).attr("tabindex")),
                        $newSelector = null, nodeName='';
                    if (!tabIndex) return;
                    if (!$(this).val() && ($(this).attr("required") || $(this).attr("isRequired"))) {
                        return false;
                    }
                    while(true){
                        tabIndex = tabIndex + 1;
                        $newSelector = $('[tabindex="' + tabIndex + '"]');
                        nodeName = $newSelector[0].nodeName.toLowerCase();
                        if (nodeName == 'button') {
                            $newSelector.click();
                            break;
                        }
                        else if ($newSelector.closest('.hide').length === 0 && !$newSelector.attr("readonly")) {
                            $newSelector.focus();
                            break;
                        }
                    }
                }
            });
            // Disable scroll when focused on a number input.
            $('form').on('focus', 'input[type=number].numeric', function (e) {
                $(this).on('wheel', function (e) {
                    e.preventDefault();
                });
            });
            // Restore scroll on number inputs.
            $('form').on('blur', 'input[type=number].numeric', function (e) {
                $(this).off('wheel');
            });
            // Disable up and down keys.
            $('form').on('keydown', 'input[type=number].numeric', function (e) {
                if (e.which == 38 || e.which == 40)
                    e.preventDefault();
            });            
            $('.imageOnly').change(function (e) {
                var imageData = $(this)[0].files[0].type;
                imageData = imageData.split("/");
                if (imageData[0] != 'image' || (imageData[0] == 'image' && (['jpeg', 'jpg', 'png'].indexOf(imageData[1]) == -1))) {
                    sweetAlert("", CIRCULATION.Text.en_US.IMGFORMAT, "error");
                    $(this).val('');
                }
            });
            $(".hover tbody tr").click(function () {
                $(".hover tbody tr").removeClass("active_row");
                $(this).addClass("active_row");
            });
            $('form').on('click', '.errclose', function () {
                $(this).closest('.errbox').remove();
            });
            $('body').on('click', '.haserror', function () {
                $(this).removeClass('haserror');
            });
            $('form').on('keyup', '.required-glow', function () {
                if ($(this).val() != '') {
                    $(this).removeClass('required-glow');
                }
            });
            $('.dropdown-submenu a.parent').on("click", function (e) {
                $('.dropdown-submenu').find('.dropdown-menu').hide();
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
            });
            $('.dropdown-menu li').on("click", function (e) {                
                if (e.target.tagName.toLowerCase() != 'input') {
                    $('.dropdown-menu input[type="checkbox"]').prop("checked", false);
                    $(this).find('input[type="checkbox"]').prop("checked", true);
                    e.preventDefault();
                } else {
                    $('.dropdown-menu input[type="checkbox"]').prop("checked", false);
                    $(this).find('input[type="checkbox"]').prop("checked", true);                    
                }
                e.stopPropagation();
            });
            $('#to_page_btn').click(function () {
                $('.dropdown-submenu').find('.dropdown-menu').hide();
                $('input[type="checkbox"]').prop("checked", false);
            });

            //SOCKET-SUBSCRIBE
            if (page !== 'login') {
                socket.on('connect', function () {// Connected, let's sign-up to receive messages for this room
                    socket.emit('subscribe', 'PMD_USER_' + userId);                    
                });
                socket.on('reload', function (pageId) {
                    if (!pageId || pageId == page) {
                        window.location.reload();
                    }
                });
                socket.on('redirect', function (pageURL) {
                    if (pageURL) {
                        window.location = pageURL;
                    }
                });                
                socket.on('logout', function (data) {
                    CIRCULATION.utils.hardLogout();
                });
            }
            //init methods
            //notifyPermission();
            validationRemove();
            $(".table-results tbody tr,.table-adv-results tbody tr").click(function () {
                $(".table-results tbody tr").removeClass("tr-active");
                $(this).addClass("tr-active");
            });
            //prevent-form-submit-on-enter-key
            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        },
        setCookie: function (cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        getCookie: function (cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        hideLoader: function () {
            $("#process_loader,#process_loader_bg").addClass('hide');
        },
        printItem: function (divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        },
        preventRightClick: function(a) {
            $(document).on("contextmenu dragstart", function(b) {
                if ($(b.target).is(a)) {
                    return false
                }
            })
        },
        userLogout: function () {            
                swal({
                    title: "Are you sure?",
                    text: "Your session will end!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Sign me out",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        CIRCULATION.utils.showLoader();
                        CIRCULATION.utils.sendAjaxPost('AuthController/Logout', new FormData(), 'json',
                        function (data) {
                            socket.emit('unsubscribe', 'PMD_USER_' + userId);
                            CIRCULATION.utils.hardLogout(userId);
                            setTimeout(function () {
                                window.location = baseUrlPMD;
                            }, 3000);
                        },
                        function (textStatus, errorThrown) {
                            CIRCULATION.utils.hideLoader();
                            sweetAlert("Oops!", "Error Occured! Try Again Later.", "error");
                        });
                    }
                });
        },   
        sendAjaxPost: function (url, formData, resType, successCallback, errorCallback) {
            $.ajax({
                type: 'POST',
                url: baseUrlPMD + url,
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
                url: baseUrlPMD + url,
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
        triggerNotification: function (theBody, theIcon, theTitle, link) {
            if (!("Notification" in window)) {
                console.log("This browser does not support system notifications");
                return false;
            }
            if (Notification.permission === "granted") {
                spawnNotification(theBody, theIcon, theTitle, link);
            }
                // Otherwise, we need to ask the user for permission
            else if (Notification.permission !== 'granted') {
                Notification.requestPermission(function (permission) {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        spawnNotification(theBody, theIcon, theTitle, link);
                    }
                });
            }
        },
        fixTableHeader : function (tableWrapper, height) {
            if (tableWrapper[0]) {
                if (height > 0) tableWrapper.height(height);
                tableWrapper[0].addEventListener("scroll", function () {
                    var translate = "translate(0," + this.scrollTop + "px)";
                    var hFixed = this.querySelector(".head-fixed");
                    this.querySelector("thead").style.transform = translate;
                    if (hFixed) hFixed.style.transform = "translate(" + this.scrollLeft + "px,0)";
                });
            }
        },
        notificationTypes: {
            MINIMALIST: 'minimalist',
            WARNING: 'pastel-warning',
            INFO: 'pastel-info',
            DANGER: 'pastel-danger'
        },
        showInAppNotification: function(icon, title, msg, url, type) {//@types:minimalist,pastel-warning,pastel-info,pastel-danger
            $.notify({
                icon: icon,
                title: title,
                message: msg,
                url: url,
                target: "_blank"
            }, {
                type: type,
                delay: 36000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
                icon_type: 'image',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss"><i class="fa fa-window-close" aria-hidden="true"></i></button>' +
                    '<img data-notify="icon" class="img-circle pull-left">' +
                    '<span data-notify="title">{1}</span>' +
                    '<span data-notify="message">{2}</span>' +
                '</div>'
            });
            document.getElementById('notify_audio').play();
        },
        enlargeImage: function (item) {
            $("#common-modal").modal();
            var imgSrc = $(item).attr('data-large') ? $(item).attr('data-large') : $(item).attr('src');
            $("#common-modal-body").html("<span style='width:100%;text-align:center;'><img style='max-width:100%;' src='" + imgSrc + "'></span>");
        },
        exportExcel: function (tblName, formlId, formField, headertbl, isClone, isExport) {
            if (isClone) { //clone table data to textarea
                var clone_val = $(tblName ? tblName : ".table-results,.table-adv-results").not('.deny-export').clone(),
                    head_clone_val = $(headertbl).not('.deny-export').clone();
                clone_val.find('.remove_on_excel').remove();
                $(formField ? formField : "#tData,#tDataCustom").val($('<span><style> .textFormat {  mso-number-format:"\@"; } .numberFormat { mso-number-format:"0\.00" }  </style>').append(head_clone_val).append(clone_val).html());
            }
            if(isExport){
                if($(formField ? formField : "#tData").val() == "")
                {
                    alert("No data to export.!!");
                }
                else
                {
                    $(formlId ? formlId: "#tDataform").submit();
                }
            }
        },
        formValidation: function (form) {
            var errorCount = 0, requiredSubsidaries = '', subsidaryValue = '', isSubsidaryMissing = false, dateFormat = '', inputValue='',
                $form = $(form);
            $form.find('input[required],select[required],textarea[required]').each(function () {
                requiredSubsidaries = $(this).attr('data-required');
                isSubsidaryMissing = false;
                if (requiredSubsidaries) {
                    subsidaryValue = $('.' + requiredSubsidaries).val();
                    isSubsidaryMissing = subsidaryValue ? subsidaryValue.trim() == '' : true;
                }
                if ($(this).val().trim() == '' || isSubsidaryMissing) {
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
                    var isGreater = CompareDate.attr("data-greater") || false;
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
        hardRefresh: function (pmdUserId, pageId) {
            if (pmdUserId) {
                socket.emit('refresh_page', {
                    room: 'PMD_USER_' + pmdUserId,
                    pageId: pageId
                });
            }
        },
        hardLogout: function () {
            socket.emit('unsubscribe', 'PMD_USER_' + userId);
            setTimeout(function () { window.location = baseUrlPMD + 'AuthController/Logout/1'; }, 1000);
        },
        redirectPage: function (pmdUserId, pageURL) {
            if (pmdUserId) {
                socket.emit('redirect_page', {
                    room: 'PMD_USER_' + pmdUserId,
                    pageURL: baseUrlPMD + pageURL
                });
            }
        },
        registerMethods: function () {
            if (page === 'PRODUCT-MASTER' || page === 'PRODUCT-GROUP' || page == 'ISSUE-MASTER' || page == 'ACM-MASTER' || page == 'BUREAU-MASTER' || page == 'PROMOTER-MASTER' || page == 'RESIDENCE-MASTER'
                || page == 'COPY-TYPE-MASTER' || page == 'UNION-MASTER' || page == 'SHAKHA-MASTER' || page == 'EDITION-MASTER' || page == 'ROUTE-MASTER' || page == 'DROPPING-POINT-MASTER' || page == 'ACCOUNT-HEADS'
                || page == 'EVENT-MASTER' || page == 'AGENT-MASTER' || page == 'AGENT-GROUPS-MASTER' || page == 'REGION-MASTER' || page == 'HOLIDAY-MASTER' || page == 'SUBSCRIBER-MASTER' || page == 'AMENDMENT-REASON' || page == 'AGENT-SEARCH' || page == 'AMENDMENT-TYPE'
                || page == 'WELLWISHER-MASTER' || page == 'RESPONSE-MASTER' || page == 'STATUS-MASTER' || page == 'SPONSOR-MASTER' || page == 'BANK-MASTER') {
                CIRCULATION.masters.init();
            }
            else if (page === 'USER-SEARCH' || page === 'USER-CREATE' || page === 'COPY-MASTER' || page === 'COPY-GROUP' || page === 'GROUP-COPY' || page === 'UNIT-MASTER' || page === 'RATE-MASTER') {
                CIRCULATION.admintools.init();
            }
            else if (page === 'PLAN-COPIES' || page === 'COLLECTION-TARGET' || page == 'DAILY-CANVAS-COPY' || page === 'SCHEME-DETAILS' || page == 'CHEQUE-BOUNCE-MONITOR' || page == 'MONTH-INCOME-SPLIT' 
	            || page == 'OTHER-INCOME-MONITOR' || page == 'SCHEME-REPORTS' || page == 'COPY-DROP-CHART' || page == 'AGENT-COPY-DETAILS' || page == 'LEDGER-SUMMARY' || page == 'AGENT-PRINT-ORDER' || page == 'ENTE-KAUMUDI' || page == 'CRM-SCHEME-REPORTS' || page == 'CUMULATIVE-RECEIPT-SUMMARY' || page == 'BONUS-ANALYSIS'
                || page == 'MONTHLY-EVALUATION' || page == 'CRM-REPORT' || page == 'OTHER-RECEIPT-SUMMARY' || page == 'OTHER-RECEIPT-PDC-SUMMARY') {
                CIRCULATION.misreports.init();
            }
            else if (page === 'CHANGE-PRODUCT' || page === 'CHANGE-UNIT' || page === 'SET-BONUS-DATE' || page === 'BILL-GENERATE') {
                CIRCULATION.tools.init();
            }
            else if (page === 'ENROLL' || page === 'SCHEME' || page == 'SCHEME-CREATE' || page === 'START-COPY' || page === 'PACKERS-DIARY' || page === 'JOURNAL-FINALIZE' || page === 'OTHER-RECEIPTS' || page === 'OTHER-RECEIPTS-CREATE' || page === 'JOURNAL-ENTRY' || page == 'SPONSOR' || page === 'START-COPY' || page === 'FREE-COPY' || page === 'ENTE-KAUMUDI-TRANS'
                || page === 'INITIATE-AMENDMENTS' || page === 'OTHER-RECEIPTS-PDC' || page === 'OTHER-RECEIPTS-PDC-CREATE' || page == 'WEEKDAY-AMENDMENTS' || page == 'FREE-COPY-CREATE' || page == 'RECEIPTS' || page == 'FINALIZE-AMENDMENTS') {
                CIRCULATION.transactions.init();
            }
            else if (page === 'DCR') {
                CIRCULATION.DCR.init();
            }
            else if (page === 'CRM-CREATE' || page === 'CRM-SEARCH' || page === 'CRM-VIEW' || page === 'APPROVAL') {
                CIRCULATION.crm.init();
            }
        }
    }
})();