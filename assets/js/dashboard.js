/*
*Author: Kaumudy
*Date: 19-10-2017
*Desc:  
*/
var CIRCULATION = CIRCULATION || {};
CIRCULATION.dashboard = (function () {
    /***************
    *Private Region*
    ****************/    
    
    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            String.prototype.fmt = function () {
                var s = this,
                    i = arguments.length;
                while (i--) {
                    s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
                }
                return s;
            };
            if (page == 'dashboard') {
                var message = [], err = 0;                
                //MPEWARNING
                if (user_phone == '0' || user_phone =='') {
                    message.push("Phone");
                }
                if (user_email == '' || user_email == '0') {
                    message.push("Email");
                }
                if (user_photo == '' || user_photo == '0') {
                    message.push("Photo");
                 }
                if(message.length > 0)
                {
                    swal({
                        title: "",
                        text: CIRCULATION.Text.en_US.MPEWARNING.fmt(message.join(",")),
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "GO TO PROFILE",
                        cancelButtonText: "SKIP",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = baseUrlPMD + 'Profiles/';
                        }
                    });
                }
                //Force Logout All Idle Users
                if (idle_users) {
                    var data = JSON.parse(decodeURIComponent(idle_users));
                    $.each(data, function (i, item) {
                        CIRCULATION.utils.hardLogout(data[i]);
                    });
                }
            }
            else if (page == 'dashboardSetup') {
                $('input[type="checkbox"]').click(function (e) { e.stopPropagation(); });
                $('.menu-row').click(function () {
                    var $rowMenuChk = $(this).find('input[type="checkbox"]');
                    $rowMenuChk.prop('checked', !$rowMenuChk.prop('checked'));
                });
            }
        }
    }
})();
