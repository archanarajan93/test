var EMPLOYEE = EMPLOYEE || {};
EMPLOYEE.regitration = (function () {
    /***************
    *Private Region*
    ****************/

    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            
        
            //acc heads master
            if (page == 'SEARCH-COMPANY') {
                $().change(function () {
                    var comId = $(this).val();
                    if (comId) {
                        $("#company_stock_form").submit();
                    }

            }  
        }
    }
})();
