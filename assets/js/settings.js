/*
*Author: Kaumudy
*Date: 19-10-2017
*Desc:  
*/
var CIRCULATION = CIRCULATION || {};
CIRCULATION.settings = (function () {
    /***************
    *Private Region*
    ****************/    
    
    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            if (page == 'USER-PRODUCT') {
                $(".select-product").click(function () {                    
                    var pId = $(this).attr("data-prod");
                    if (pId) {
                        CIRCULATION.utils.showLoader();
                        $("#user-product").val(pId);
                        $("#user-product-form").submit();
                    }
                });                
            }
        }       
    }
})();
