/*
*Author: Kaumudi
*Dated: 16-DEC-2017
*Desc: F1 help controls
*Require: LocalCache.js
*/
'use strict'
var HelpController = function (options) {
    var store = {
        $helpHeader: '',
        $helpBody: '',
        $searchInputElem: '',
        $searchDom: '',
        helpHeaderKeys: [],
        routeId: 0,
        requestId: 0,
        criteria: '',
        callback: '',
        clrCallback: ''
    };
    var elements = {
        selectors: {
            search: '#help_search',
            loader: '#loader',
            noRecords: '#no-records',
            helpModal: '#helpModal',
            helpWrap: '#help-info',
            helpTable: '#help-info table',
            helpTBody: '#help-tbody',
            helpTHead: '#help-thead',
            helpMultiSelectedText: '.selected-res'
        }
    };
    var routes = {
        EmployeeDetails: 1,
        ACMDetails: 2,
        ProductGroups: 3,
        Promoter: 5,
        ACM: 6,
        Bureau: 7,
        Edition: 10,
        Route: 11,
        DroppingPoint : 12,
        Units: 13,
        CopyType: 14,
        CopyGroup: 15,
        Union: 8,
        Shakha: 9,
        AgentMaster: 17,
        Products: 18,
        BillingPeriod: 19,
        BillingPeriodTo: 20,
        Regions: 21,
        AgentGroups: 22,
        Subscribers: 23,
        FinalStatus: 24,
        AmendmentType: 25,
        ResidenceAssociation: 26,
        Wellwisher: 27,
        Events: 28,
        Response:29,
        Status:30,
        AmendmentReason: 33,
        PacketReason: 34,
        CopyTypeAll: 35,
        AccountHead: 36,
	SponsorClients: 37,
        SchemeSubscriber: 38,
        BankMaster: 39,
        TempReceipt: 40,
        Scheme: 41,
        CopyMaster:42
    };
    var template = {
        multiselect: '<span class="multiselect-text"><span class="selected-res">SELECTED</span>' +
                    '<span class="clear-btn"><i class="fa fa-close"></i></span>' +
                    '<input type="hidden" class="multi-search-selected multi_sel_FIELD" name="multi_sel_FIELD" value="CHECKEDJSON"/></span>',
        multiselectapplybtn: '<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 no-padding multi-apply" style="height:40px;"><div style="width:96%;position:fixed;background:#fff;height: 40px;">' +
                             '<button type="button" class="btn btn-primary multiselect-apply-btn" style="margin:0 !important;">Apply</button></div>' +
                             '</div>'
    };
    var inProcessFlag = false, $this = '', $parent = '', selectedMultiItems = [];
    //Field Ids of F1 Help
    var helpInputFields = options.fields,
        helpInputClickbtns = options.fieldBtns;
    var getHelpResults = function (searchString, requestId, searchFields) {
        if (inProcessFlag) return; inProcessFlag = true; //force limit one call at a time
        //var cacheRecords = cacheLookUp(searchString, requestId, searchFields);
        //if (0 < cacheRecords.length) {
        //    attachHelpRecords(cacheRecords, requestId);
        //}
        //else {
        var JSONData = { 'search': searchString.indexOf(' Selected') !== -1 ? '' : searchString, 'criteria': store.criteria };
        $.ajax({
            url: baseUrlPMD + "api/endpoint?routeId=" + requestId + "&params=" + encodeURIComponent(JSON.stringify(JSONData)),
            type: "GET",
            contentType: "application/json",
            dataType: "json",
            cache: false,
            success: function (response) {
                //if (0 < response.length) {
                attachHelpRecords(response, requestId);
                //LocalCache.setLocalCache(requestId, store.criteria, searchString, response);
                /*} else {
                    $(elements.selectors.loader).hide();
                    $(elements.selectors.helpWrap).hide();
                }*/
            },
            error: function (data, textStatus, errorThrown) {
                console.log(errorThrown.message);
                $(elements.selectors.loader).hide();
                inProcessFlag = false;
            }
        });
        //}
    };
    var attachHelpRecords = function (records, requestId) {
        inProcessFlag = false;
        $(elements.selectors.search).focus();//Focus On Search Textbox
        var recordLength = records.length;
        if (0 < recordLength) {
            store.helpHeaderKeys = getKeys(records[0]);
            createHelpHeader();
            store.routeId = requestId;
            for (var i = 0; i < recordLength; i++) {
                createHelpBody(records[i], i + 1); //add each row of search
            }
            setTimeout(function () { freshLoader(); }, 500);
        }
        //get defined options
        var options = store.$searchInputElem.data('options');
        //set all checkbox selected for multiple select
        if (options && options.isSelected) {
            $(elements.selectors.helpTable).find('input[type="checkbox"]').prop('checked', true);
        }
        $(elements.selectors.helpWrap).toggle(0 < recordLength);
        $(elements.selectors.noRecords).toggle(0 == recordLength);
        $(elements.selectors.loader).addClass('hide'); //hide loading
        showApplyBtn();
    };
    //lookup cache for saved F1 queries
    var cacheLookUp = function (searchString, requestId, searchFields) {
        var similarRecords = [];
        var savedResults = LocalCache.getLocalCache(requestId, store.criteria, searchString); //1. cache for same string records
        if (0 == savedResults.length) {  //2. 1 fails, cache for search strings first char records
            similarRecords = LocalCache.getLocalCache(requestId, store.criteria, searchString.charAt(0));
            if (0 == similarRecords.length) {
                similarRecords = LocalCache.getLocalCache(requestId, store.criteria, ''); //3. 1,2 fails, cache for all records for that field
            }
            if (0 < similarRecords.length) {//fetch by searchstring from saved similar records
                var searchFields = searchFields.split(',');
                if (0 == searchFields.length) return "";//no search field
                var searchValue = searchString.toLowerCase();
                savedResults = [];
                for (var i = 0; i < similarRecords.length; i++) {
                    for (var sIndex = 0; sIndex < searchFields.length; sIndex++) {
                        var searchFieldValue = similarRecords[i][searchFields[sIndex]] ? similarRecords[i][searchFields[sIndex]].toLowerCase() : "";
                        if (-1 != searchFieldValue.indexOf(searchValue)) {
                            savedResults.push(similarRecords[i]);
                            break;
                        }
                    }
                }
            }
        }
        return savedResults;
    };
    var createHelpHeader = function () {
        var headRow = '<tr>';
        if (store.$searchInputElem.attr("data-multiselect") == 'true')
            headRow += '<th><input type="checkbox" class="rowCheck" value="All"></th>';
        for (var i = 0; i < store.helpHeaderKeys.length; i++) {
            var hiddenField = store.helpHeaderKeys[i].indexOf('\hidden') !== -1 ? 'hidden' : '';
            headRow += '<th class="' + hiddenField + '">' + store.helpHeaderKeys[i] + '</th>';
        }
        headRow += '</tr>';
        store.$helpHeader.innerHTML=headRow;
    };
    var createHelpBody = function (record, tabIndex) {

        var nodeTd = document.createElement('td'), newRecord = {};
        for (var key in record) {
            var newKey = key.replace('/hidden', '');
            newRecord[newKey] = record[key];
        }

        var dataRecord = encodeURIComponent(JSON.stringify(newRecord)),
            bodyRow = document.createElement('tr');
            bodyRow.setAttribute('visible', 'true');
            bodyRow.setAttribute('tabindex', '1');
            bodyRow.setAttribute('data-active', 'false');
            bodyRow.setAttribute('data-selected', 'false');
            bodyRow.setAttribute('data-record', dataRecord);
            //bodyRow = '<tr visible="true" tabindex="1" data-active="false" data-selected="false" data-record="' + dataRecord + '">';
        if (store.$searchInputElem.attr("data-multiselect") == 'true') {
            if (-1 != indexOf(selectedMultiItems, newRecord)) {
                bodyRow.setAttribute('data-selected', 'true');
                nodeTd.setAttribute('data-record', dataRecord);
                nodeTd.setAttribute('align', 'center');
                nodeTd.innerHTML = '<input type="checkbox" checked="checked" class="rowCheck" value="' + dataRecord + '">';
                bodyRow.appendChild(nodeTd);
                //bodyRow = '<td data-record="' + dataRecord + '" align="center"></td>';
            } else {
                bodyRow.setAttribute('data-selected', 'false');
                nodeTd.setAttribute('data-record', dataRecord);
                nodeTd.setAttribute('align', 'center');
                nodeTd.innerHTML = '<input type="checkbox" class="rowCheck" value="' + dataRecord + '">';
                bodyRow.appendChild(nodeTd);
                //bodyRow = '<tr visible="true" tabindex="1" data-active="false" data-selected="false"><td data-record="' + dataRecord + '" align="center"><input type="checkbox" class="rowCheck" value="' + dataRecord + '"></td>';
            }
        }
        for (var i = 0; i < store.helpHeaderKeys.length; i++)
        {
            nodeTd = document.createElement('td');
            var hiddenField = store.helpHeaderKeys[i].indexOf('\hidden') !== -1 ? 'hidden' : '';
            var tdText = '';
            if (record[store.helpHeaderKeys[i]]) {
                if (store.helpHeaderKeys[i].toLowerCase().indexOf("amount") !== -1) {
                    tdText = currencyFormat(record[store.helpHeaderKeys[i]]);
                } else {
                    tdText = record[store.helpHeaderKeys[i]];
                }
            }
            if (i == 0) {
                nodeTd.removeAttribute('data-record');
                nodeTd.setAttribute('align', 'center');
                nodeTd.setAttribute('class', hiddenField);
                nodeTd.innerHTML = '<input class="focusHere" />' + tdText;
                bodyRow.appendChild(nodeTd);
            } else {
                nodeTd.removeAttribute('data-record');
                nodeTd.setAttribute('align', 'center');
                nodeTd.setAttribute('class', hiddenField);
                nodeTd.innerHTML = tdText;
                bodyRow.appendChild(nodeTd);
            }
        }
        store.$helpBody.appendChild(bodyRow);
    };
    var indexOf = function (array, item) {
        for (var i = 0; i < array.length; i++) {
            if (JSON.stringify(array[i]) === JSON.stringify(item)) return i;
        }
        return -1;
    };
    //get property key names
    var getKeys = function (dictionary) {
        var keys = [];
        for (var key in dictionary) {
            //&& key.indexOf('/hidden')==-1
            if (dictionary.hasOwnProperty(key)) {
                keys.push(key);
            }
        }
        return keys;
    };
    var currencyFormat = function (amt) {
        amt = parseFloat(amt).toFixed(2);
        var x = amt.toString();
        var afterPoint = '';
        if (x.indexOf('.') > 0) afterPoint = x.substring(x.indexOf('.'), x.length);
        x = Math.floor(x);
        x = x.toString();
        var lastThree = x.substring(x.length - 3);
        var otherNumbers = x.substring(0, x.length - 3);
        if (otherNumbers != '')
            lastThree = ',' + lastThree;
        return otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
    };
    var searchTable = function (searchTerm) {
        var $helpBody = $(store.$helpBody);
        var listItem = $helpBody.children('tr');
        var filterVal = [], unitFilter = '', prdtFilter = '', grpFilter = '';
        filterVal = $('.modal-header #unit_filter').val();
        for (var item in filterVal) {
            unitFilter += "td:eq(2):contains('" + filterVal[item] + "'),";
        }
        filterVal = $('.modal-header #product_filter').val();
        for (var item in filterVal) {
            prdtFilter += "td:eq(3):contains('" + filterVal[item] + "'),";
        }
        filterVal = $('.modal-header #group_filter').val();
        for (var item in filterVal) {
            grpFilter += "td:eq(4):contains('" + filterVal[item] + "'),";
        }

        //var searchSplit = searchTerm.replace(/ /g, "'):containsi(' ");
        var searchSplit = searchTerm;
        $.extend($.expr[':'], {
            'containsi': function (elem, i, match, array) {
                var cellContents = '';
                for (var j = 0; j < elem.cells.length; j++) {
                    cellContents += elem.cells[j].innerText + '|';
                }
                return (cellContents || elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });
        $helpBody.find('tr').not(":containsi('" + searchSplit + "')").each(function (e) {
            $(this).attr('visible', 'false').attr('data-selected', 'false');
            $(this).find('input[type="checkbox"]').prop("checked",false);
        });
        var activeIndex = 0;
        $helpBody.find("tr:containsi('" + searchSplit + "')").each(function (e) {
            if ((!unitFilter || $(this).find(unitFilter.slice(0, unitFilter.length - 1)).length > 0)
                   && (!prdtFilter || $(this).find(prdtFilter.slice(0, prdtFilter.length - 1)).length > 0)
                   && (!grpFilter || $(this).find(grpFilter.slice(0, grpFilter.length - 1)).length > 0)) {
                activeIndex == 0 ? $(this).attr('data-active', 'true') : $(this).attr('data-active', 'false');
                $(this).attr('visible', 'true').attr('data-selected', 'false');
                $(this).find('input[type="checkbox"]').prop("checked", false);
                activeIndex++;
            } else {
                $(this).attr('visible', 'false').attr('data-selected', 'false');
                $(this).find('input[type="checkbox"]').prop("checked", false);
            }
        });
        //$(elements.selectors.helpWrap + ' .multi-apply').remove();
        $("#help-info").scrollTop(0);
    }
    function filterSearch() {
        var filterSlected =[], filterVal = [], unitFilter='',prdtFilter='',grpFilter='';
        var filterCond = '', filterNotCond='';
        var $helpBody = $(store.$helpBody);
        var listItem = $helpBody.children('tr');
        /*$('.modal-header .select2').each(function () {
            filterSlected = [];
            if($(this).val()) filterSlected = $(this).val();
            filterVal = filterVal.concat(filterSlected);
        });*/
        filterVal = $('.modal-header #unit_filter').val();
        for(var item in filterVal){
            unitFilter += "td:eq(2):contains('" + filterVal[item] + "'),";
        }
        filterVal = $('.modal-header #product_filter').val();
        for(var item in filterVal){
            prdtFilter += "td:eq(3):contains('" + filterVal[item] + "'),";
        }
        filterVal = $('.modal-header #group_filter').val();
        for(var item in filterVal){
            grpFilter += "td:eq(4):contains('" + filterVal[item] + "'),";
        }
        
        //var searchSplit = searchTerm.replace(/ /g, "'):containsi(' ");
        //var searchSplit = searchTerm;
        $.extend($.expr[':'], {
            'containsi': function (elem, i, match, array) {
                var cellContents = '';
                for (var j = 0; j < elem.cells.length; j++) {
                    cellContents += elem.cells[j].innerText + '|';
                }
                return (cellContents || elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });
        /*for (var item in filterVal) {
            filterCond += "tr:contains('" + filterVal[item] + "'),";
            filterNotCond += ":contains('" + filterVal[item] + "'),";
        }*/
        if (unitFilter || prdtFilter || grpFilter) {
            var activeIndex = 0;
            $helpBody.find('tr').each(function (e) {
                if ((!unitFilter || $(this).find(unitFilter.slice(0, unitFilter.length - 1)).length > 0)
                    && (!prdtFilter || $(this).find(prdtFilter.slice(0, prdtFilter.length - 1)).length > 0)
                    && (!grpFilter || $(this).find(grpFilter.slice(0, grpFilter.length - 1)).length > 0)) {
                    activeIndex == 0 ? $(this).attr('data-active', 'true') : $(this).attr('data-active', 'false');
                    $(this).attr('visible', 'true').attr('data-selected', 'false');
                    $(this).find('input[type="checkbox"]').prop("checked", false);
                    activeIndex++;
                } else {
                    $(this).attr('visible', 'false').attr('data-selected', 'false');
                    $(this).find('input[type="checkbox"]').prop("checked", false);
                }
            });
            /*var activeIndex = 0;
            $helpBody.find(filterCond.slice(0, filterCond.length - 1)).each(function (e) {
                activeIndex == 0 ? $(this).attr('data-active', 'true') : $(this).attr('data-active', 'false');
                $(this).attr('visible', 'true').attr('data-selected', 'false');
                $(this).find('input[type="checkbox"]').prop("checked", false);
                activeIndex++;
            });*/
        } else {
            $helpBody.find('tr').each(function (e) {
                $(this).attr('visible', 'true').attr('data-selected', 'false');
                $(this).find('input[type="checkbox"]').prop("checked", false);
            });
        }
        //$(elements.selectors.helpWrap + ' .multi-apply').remove();
    }
    function freshLoader() { //Method to refresh table
        $(elements.selectors.search).focus();
        $('#help-table tbody tr').attr("data-active", "false");
        $('#help-table tbody tr:visible:first').attr("data-active", "true");
    };
    function traverseToNext() { //Method to traverse downwards
        $('#help-table tbody tr[data-active="true"]').map(function () {
            var nextItem = $(this).nextAll("tr:visible:first");
            if (0 < nextItem.length) {
                $(this).attr("data-active", "false");
                nextItem.attr("data-active", "true").focus();
                nextItem.find('input').focus();
            }
        });
    };
    function traverseToPrevious() { //Method to traverse upwards
        $('#help-table tbody tr[data-active="true"]').map(function () {
            var previousItem = $(this).prevAll("tr:visible:first");
            if (0 < previousItem.length) {
                $(this).attr("data-active", "false");
                previousItem.attr("data-active", "true").focus();
                previousItem.find('input').focus();
            } else {
                $(elements.selectors.search).focus();//Focus On Search Textbox
            }
        });
    };
    function selectItem() { //fill the selected row items
        if ($(elements.selectors.helpWrap).attr('data-multiselect') == 'true') {
            selectMultipleSelection();
        } else {
            selectSingleSelection();
        }
        var nextFocus = store.$searchInputElem.data('select');
        if (0 < store.$searchInputElem.data('select').length)
            setFocus(nextFocus); //to set focus on next field
        else
            store.$searchInputElem.focus();
        //$("." + store.$searchInputElem.attr("id") + "_clr").closest('.search-module').find('.multiselect-text').remove();
        //$("." + store.$searchInputElem.attr("id") + "_clr").val("");
        //$(elements.selectors.helpModal).modal('toggle');
        $(elements.selectors.helpModal).modal('hide');
        store.$searchInputElem.focus();
    };
    function selectMultipleSelection() {
        var totalSelected = 0, selectedMultis = "[";
        $(elements.selectors.helpTBody + ' input[type="checkbox"]:checked').each(function () {
            selectedMultis += decodeURIComponent($(this).val()) + ',';
            totalSelected++;
        });
        if (totalSelected == 0) exit(0); //no item slected
        selectedMultis = selectedMultis.slice(0, -1) + "]";
        var multiTmpl = template.multiselect.replace("SELECTED", totalSelected + " Selected");
        multiTmpl = multiTmpl.replace("CHECKEDJSON", encodeURIComponent(selectedMultis));
        multiTmpl = multiTmpl.replace(/FIELD/g, store.$searchInputElem.attr("name"));
        //since it is called after f2 store>$searchDom carries parent Dom
        store.$searchDom.find('.multiselect-text').remove();
        store.$searchInputElem.val(totalSelected + " Selected");
        store.$searchInputElem.after(multiTmpl);
        if (store.callback) { window[store.callback](); }
    };
    function selectSingleSelection() {
        $('#help-table tbody tr[data-active="true"]').map(function () {
            //get defined options
            var options = store.$searchInputElem.data('options'),
                inputId = store.$searchInputElem.attr('id'),
                savedRecordId = inputId + '_rec_sel',
                selectIndex = store.$searchInputElem.attr("data-selectIndex"),
                targetInputs = store.$searchInputElem.attr("data-target"),
                targetValues = targetInputs?JSON.parse(targetInputs):'';

            store.$searchInputElem.closest('.input-group').find('#' + savedRecordId).remove();
            store.$searchInputElem.after('<input type="hidden" name="' + savedRecordId + '" class="' + inputId + '_clr" id="' + savedRecordId + '" value="' + $(this).attr('data-record') + '"/>');
            if (store.requestId == routes.EmployeeDetails) {
                $("#employee_id").val($(this).find("td:eq(4)").text());
                $("#employee_name").val($(this).find("td:eq(1)").text());
                $("#employee_department").val($(this).find("td:eq(2)").text());
                $("#employee_designation").val($(this).find("td:eq(3)").text());
                store.$searchInputElem.val($(this).find("td:eq(1)").text());
            }
            else if (store.requestId == routes.ACMDetails) {
                $("#promoter_acm_code, #agent_acm").val($(this).find("td:eq(0)").text());
                $("#agent_region").val($(this).find("td:eq(2)").text());                
                $("#agent_promoter_rec_sel").val('');                
            }
            else if (store.requestId == routes.ProductGroups) {
                $("#product_group").val($(this).find("td:eq(1)").text());
            }
            else if (store.requestId == routes.Promoter) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.ACM) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }            
            else if (store.requestId == routes.Units) {
                $("#unit").val($(this).find("td:eq(0)").text());
                $("#groupwise-wrap .multiselect-text").remove();
                $("#groupwise").val('');
            }
            else if (store.requestId == routes.CopyType || store.requestId == routes.CopyTypeAll) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }            
            else if (store.requestId == routes.CopyGroup) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.Union) {
                $("#shakha_union,#p_shakha_union,#agent_union").val($(this).find("td:eq(0)").text());
                $("#agent_shakha, #agent_shakha_rec_sel").val('');
            }
            else if (store.requestId == routes.Shakha) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
                store.$searchInputElem.closest('form').find("#sales_location").val($(this).find("td:eq(3)").text());
                store.$searchInputElem.closest('form').find("#contact_person").val($(this).find("td:eq(1)").text());
            }
            else if (store.requestId == routes.Bureau) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }            
            else if (store.requestId == routes.Edition) {                
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.Route) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
                $("#agent_dropping_point, #agent_dropping_point_rec_sel").val('');
            }
            else if (store.requestId == routes.DroppingPoint) {
                $("#agent_dropping_point").val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.AgentMaster) {
                if (selectIndex) {
                    store.$searchInputElem.val($(this).find("td:eq(" + selectIndex + ")").text());
                } else {
                    store.$searchInputElem.val($(this).find("td:eq(0)").text());
                }
                store.$searchInputElem.closest('form').find("#agent_name,#p_agent_name").val($(this).find("td:eq(1)").text());
                store.$searchInputElem.closest('form').find("#agent_loc,#p_agent_loc").val($(this).find("td:eq(2)").text());
                store.$searchInputElem.closest('tr').find(".ag_nme").val($(this).find("td:eq(1)").text());
                store.$searchInputElem.closest('tr').find(".ag_loc").val($(this).find("td:eq(2)").text());
            }            
            else if (store.requestId == routes.Products) {
                store.$searchInputElem.val($(this).find("td:eq(1)").text());
            }
            else if (store.requestId == routes.BillingPeriod) {
                $("#billing_period").val($(this).find("td:eq(0)").text());
            }
	     else if (store.requestId == routes.PacketReason) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
	     }
	     else if (store.requestId == routes.AccountHead) {
	         store.$searchInputElem.val($(this).find("td:eq(0)").text());
	     }
            else if (store.requestId == routes.BillingPeriodTo) {
                $("#billing_period_to").val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.Regions) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.AgentGroups) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.Subscribers) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
                store.$searchInputElem.closest('form').find("#sub_agent_name").val($(this).find("td:eq(2)").text());
                store.$searchInputElem.closest('form').find("#sub_agent_loc").val($(this).find("td:eq(3)").text());
                $('#sub_name').val($(this).find("td:eq(0)").text());
                $('#sub_addr').val($(this).find("td:eq(1)").text());
                $('#sub_contact').val($(this).find("td:eq(6)").text());
            }
            else if (store.requestId == routes.FinalStatus) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.AmendmentType) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }
            else if (store.requestId == routes.ResidenceAssociation) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());                
                store.$searchInputElem.closest('form').find("#sales_location").val($(this).find("td:eq(1)").text());
                store.$searchInputElem.closest('form').find("#contact_person").val($(this).find("td:eq(2)").text());
            }
            else if (store.requestId == routes.Wellwisher) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
                //store.$searchInputElem.closest('form').find("#contact_person").val($(this).find("td:eq(0)").text());
                store.$searchInputElem.closest('form').find("#sales_location").val($(this).find("td:eq(1)").text());
            }
            else if (store.requestId == routes.AmendmentReason) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
            }   
	        else if (store.requestId == routes.Events) {
                store.$searchInputElem.val($(this).find("td:eq(0)").text());
	        }
	        else if (store.requestId == routes.Response) {
	            store.$searchInputElem.val($(this).find("td:eq(0)").text());
	        }
	        else if (store.requestId == routes.Status) {
	            store.$searchInputElem.val($(this).find("td:eq(0)").text());
	        }
		else if (store.requestId == routes.SponsorClients) {
	            store.$searchInputElem.val($(this).find("td:eq(0)").text());
	        }
	        else if (store.requestId == routes.SchemeSubscriber) {
	            store.$searchInputElem.val($(this).find("td:eq(2)").text());
	        }
	        else if (store.requestId == routes.CopyMaster) {
	            store.$searchInputElem.val($(this).find("td:eq(0)").text());
	        }
		else if (store.requestId == routes.BankMaster) {
	            store.$searchInputElem.val($(this).find("td:eq(0)").text());
		}
		else if (store.requestId == routes.Scheme) {
		    store.$searchInputElem.val($(this).find("td:eq(1)").text());
		    $('#sub_executive_code').val("");
		    $('#sub_executive').val($(this).find("td:eq(4)").text());
		    $('#scheme_slno').val($(this).find("td:eq(5)").text());
		}
		else if (store.requestId == routes.TempReceipt) {
	            store.$searchInputElem.val($(this).find("td:eq(0)").text());
	        }
            if (options) {
                if (options.clearCls) {
                    $(options.clearCls).val('');
                }
                if (options.activeCls) {
                    $(options.activeCls).prop('readonly', false);
                    $(options.activeCls).removeAttr('data-selectable');
                    $(options.activeCls).closest('.search-module').removeAttr('data-selectable');
                }
            }
            if (targetValues) {
                for (var item in targetValues) {
                    var selectedValue = [];
                    var indexes = targetValues[item].indexes.split(",");
                    for (var indIndex in indexes) {
                        selectedValue.push($(this).find("td:eq(" + indexes[indIndex] + ")").text());
                    }
                    $(targetValues[item].selector).val(selectedValue.join(", "));
                }
            }
            if (store.callback) { window[store.callback](); }
        });
    };
    function processFilters() {
        //add filters if it has filter
        if (store.$searchInputElem.attr("data-filter") == 'on') {
            store.$searchDom.find(".filters .select2-container").each(function () { $(this).remove(); });
            $("#hlp_filters").html(store.$searchDom.find(".filters").html());
            $(".select2").each(function () {
                $(this).select2({ placeholder: $(this).attr("placeholder") });
            });
            $(".select2-container").css({ "width": "190px", "z-index": "11111" });
            $(".select2").on('select2:select', function (e) {
                filterSearch();
            });
            $('.select2').on('select2:unselect', function (e) {
                filterSearch();
            });
        } else {
            $("#hlp_filters").html('');
        }
    }
    function setFocus(nextFocus) {
        switch (nextFocus.type) {
            case 'input': $('#' + nextFocus.id).focus();
                break;
            case 'select': $('#' + nextFocus.id).select2('open');
                break;
            case 'radio': $('input[type="radio"][name="' + nextFocus.name + ']:checked').focus();
                break;
            default: store.$searchInputElem.focus();
                //fallback: if not specified next focus,set on search field itself.
        }
    };
    function showApplyBtn() {
        //if (0 < $(elements.selectors.helpTBody + ' input[type="checkbox"]:checked').length) {
        //    if (0 == $(elements.selectors.helpWrap + ' .multi-apply').length)
        //        $(elements.selectors.helpTable).before(template.multiselectapplybtn);
        //} else {
        //    $(elements.selectors.helpWrap + ' .multi-apply').remove();
        //}
        if (store.$searchInputElem.attr("data-multiselect") == 'true') {
            $(elements.selectors.helpTable).before(template.multiselectapplybtn);
        } else {
            $(elements.selectors.helpWrap + ' .multi-apply').remove();
        }
    };
    /* Method to get input quries,add to globals then call db*/
    function processHelpInputs(request, searchString, criteria, callback, clrCallback) {
        store.criteria = '';
        //Checking reqired fields 
        var errorMessage = 'All fields required.';
        if (criteria && criteria.length > 0) {
            var errorCount = 0, i = 0;
            for (i = 0; i < criteria.length; i++) {
                if (criteria[i]['custom'] == undefined || criteria[i]['custom'] != 'true') {
                    var rec = criteria[i]['input'].startsWith("$") ?  criteria[i]['input'].val(): $(criteria[i]['input']).val();
                    if (rec) {
                        var recSelect = criteria[i]['select'];
                        if (criteria[i]['encode'] == 'false')
                        {
                            criteria[i]["input"] = rec;
                        } else {
                            rec = JSON.parse(decodeURIComponent(rec));
                            criteria[i]["input"] = recSelect ? rec[recSelect] : rec;
                        }
                    }
                    else if (criteria[i]['required'] == 'false') {
                        criteria[i]["input"] = '';
                    }
                    else {
                        errorCount++;
                        if (criteria[i]["msg"] != '') errorMessage = criteria[i]["msg"];
                        break;
                    }
                }
            }
            if (errorCount > 0) {                
                swal("", errorMessage);
                return;
            }
            store.criteria = JSON.stringify(criteria);
        }
        store.$searchInputElem.removeClass('haserror');
        store.requestId = request.id;
        store.callback = callback;
        store.clrCallback = clrCallback;
        $(elements.selectors.search).val('');
        store.$helpHeader.innerHTML='';//clear help to load new
        store.$helpBody.innerHTML = '';
        $(elements.selectors.loader).removeClass('hide');
        $(elements.selectors.helpModal).modal();
        initializeMultiSelect();
        getHelpResults(searchString, request.id, request.search);
    };
    function initializeMultiSelect() {
        $(elements.selectors.helpWrap).attr('data-multiselect', store.$searchInputElem.attr("data-multiselect") == 'true');
        //get selected list for multiple selection
        selectedMultiItems = [];
        $(elements.selectors.helpTHead + ' tr input[type="checkbox"]').prop("checked", false);
        $(elements.selectors.helpWrap + ' .multi-apply').remove();
        var selectedData = store.$searchDom.find('.multi-search-selected').val();
        if (selectedData)
            selectedMultiItems = JSON.parse(decodeURIComponent(selectedData));
    };
    function selectRowActive($selected) {
        $('#help-table tbody tr').attr("data-active", "false");
        $selected.attr("data-active", "true");
    };
    var initialize = function () {
        store.$helpHeader = document.getElementById('help-thead');
        store.$helpBody = document.getElementById('help-tbody');
    };
    var init = function () {
        //F2 help event get from DB
        $('body').on('keydown', helpInputFields, function (e) {
            var notLettersKeyArray = [9, 13, 16, 17, 18, 20, 27, 37, 38, 39, 40, 113, 123];
            store.$searchInputElem = $(this);
            //f2 press
            if (store.$searchInputElem.attr('data-selectable') == 'false' || store.$searchInputElem.attr('readonly')) return;
            if (e.keyCode == 113) {
                e.preventDefault();
                var minChars = parseInt(store.$searchInputElem.attr('data-minchars'));
                if (minChars != '' && store.$searchInputElem.val().trim().length < minChars) {                    
                    swal("", "Please enter minimum " + minChars + " characters!");
                    return;
                }
                store.$searchInputElem.removeClass('error');
                store.$searchDom = $(this).closest('.input-group');//get parent search dom
                var request = JSON.parse(store.$searchInputElem.attr('data-request')),
				criteria = store.$searchInputElem.attr('data-criteria'),
				callback = store.$searchInputElem.attr('data-callback'),
                clrCallback = store.$searchInputElem.attr('data-clrcallback'),
                searchString = store.$searchInputElem.val();
                if (criteria) criteria = JSON.parse(criteria);
                $('#helpModal .select2-container').remove();
                processFilters();
                processHelpInputs(request, searchString, criteria, callback, clrCallback);
            }
            if (-1 === notLettersKeyArray.indexOf(e.keyCode)) { //clear all during backspace or new input
                var inputId = store.$searchInputElem.attr('id');
                //store.$searchInputElem.val('');
                $('.' + inputId + '_clr').val('');
                $('.' + inputId + '_div_clr').addClass('hide');
                $('.' + inputId + '_rec_sel').val('');
                clrCallback = store.$searchInputElem.attr('data-clrcallback');
                if (clrCallback) { window[clrCallback](); }
            }
        });
        //F2 help clicks event get records from DB
        $('body').on('click', helpInputClickbtns, function (e) {
            //store.$searchInputElem = $('#' + $(this).data('search'));
            store.$searchInputElem = $(this).closest('.input-group').find('input[type="text"][data-request]');
            if (store.$searchInputElem.attr('data-selectable') == 'false' || store.$searchInputElem.attr('readonly')) return;
            var minChars = parseInt(store.$searchInputElem.attr('data-minchars'));
            if (minChars != '' && store.$searchInputElem.val().trim().length < minChars) {                
                swal("", "Please enter minimum " + minChars + " characters!");
                return;
            }
            //store.$searchInputElem.removeClass('error');
            store.$searchDom = $(this).closest('.input-group');//get parent search dom
            var request = JSON.parse(store.$searchInputElem.attr('data-request')),
			criteria = store.$searchInputElem.attr('data-criteria'),
			callback = store.$searchInputElem.attr('data-callback'),
            clrCallback = store.$searchInputElem.attr('data-clrcallback'),
            searchString = store.$searchInputElem.val();
            if (criteria) criteria = JSON.parse(criteria);
            $('#helpModal .select2-container').remove();
            processFilters();
            processHelpInputs(request, searchString, criteria, callback, clrCallback);
        });

        //search a text on help table
        $(elements.selectors.search).keyup(function (e) {
            searchTable($(this).val());
        });
        //up , down & enter on help table rows
        $('#help-table tbody').on('keydown', 'tr', function (e) {
            if (e.keyCode == 40) {
                traverseToNext();
            }
            else if (e.keyCode == 38) {
                traverseToPrevious();
            }
            else if (e.keyCode == 13) {
                selectItem();
            }
            else if (e.keyCode == 27) {
                store.$searchInputElem.focus();
            }
        });
        $('#help-table thead').on('keydown', 'tr', function (e) { //if select all and hit enter
            if (e.keyCode == 40) {
                traverseToNext();
            }
            else if (e.keyCode == 38) {
                traverseToPrevious();
            }
            else if (e.keyCode == 13) {
                selectItem();
            }
        });
        $(elements.selectors.search).on('keydown', function (e) {
            if (e.keyCode == 13 || e.keyCode == 40) {
                $('#help-table tbody tr:visible:first').find("input").focus();
            }
        });
        //help table row click
        $(elements.selectors.helpTBody).on('click', 'tr', function (event) {
            $this = $(this);
            if ($(elements.selectors.helpWrap).attr('data-multiselect') == 'true') {
                //tick checkbox on row click for multiselection
                var rwcheckbox = $this.find('input[type="checkbox"]');
                $this.attr("data-selected", !rwcheckbox.prop("checked"));
                rwcheckbox.prop("checked", !rwcheckbox.prop("checked"));
                selectRowActive($this);
                //showApplyBtn();
            } else {
                //click to select row on help table for single selection
                selectRowActive($this);
                selectItem();
            }
        });

        $(elements.selectors.helpTBody).on('keydown', 'tr', function (e) {
            if (e.keyCode == 32) {
                if ($(elements.selectors.helpWrap).attr('data-multiselect') == 'true') {
                    $this = $(this);
                    //tick checkbox on row click for multiselection
                    var rwcheckbox = $this.find('input[type="checkbox"]');
                    $this.attr("data-selected", !rwcheckbox.prop("checked"));
                    rwcheckbox.prop("checked", !rwcheckbox.prop("checked"));
                    selectRowActive($this);
                    //showApplyBtn();
                }
            }
        });

        $(elements.selectors.helpTHead).on('click', 'input[type="checkbox"][value="All"]', function () {
            var isChecked = $(this).prop("checked");
            $(elements.selectors.helpTBody + ' tr').each(function(){
                if($(this).attr("visible")=='true'){
                    $(this).attr("data-selected", isChecked);
                    $(this).find('input[type="checkbox"]').prop("checked", isChecked);
                }else{
                    $(this).attr("data-selected", "false").attr("data-active", "false");
                    $(this).find('input[type="checkbox"]').prop("checked", false);
                }
            });
            //showApplyBtn();
        });

        $('body').on('click', elements.selectors.helpMultiSelectedText, function () {
            $(this).closest('.search-module').find('input[data-multiselect="true"]').focus();
        });

        $(elements.selectors.helpTBody).on('click', 'input[type="checkbox"]', function (e) {
            $this = $(this);
            var $parent = $(this).closest('tr');
            $parent.attr("data-selected", !$this.prop("checked"));
            $this.prop("checked", !$this.prop("checked"));
            selectRowActive($parent);
            //showApplyBtn();
        });

        $('body').on('click', '.multiselect-text .clear-btn', function (e) {
            $parent = $(this).closest('.search-module');
            $parent.find('.multiselect-text').remove();
            $parent.find('input[data-multiselect="true"]').val('').focus();
            var clrCallback = $parent.find('input[data-clrcallback]').attr("data-clrcallback");
            if (clrCallback) { window[clrCallback](); }
            //$("." + $parent.find('input').attr("id") + "_clr").closest('.search-module').find('.multiselect-text').remove();
            //$("." + $parent.find('input').attr("id") + "_clr").val("");
        });

        $(elements.selectors.helpWrap).on('click', '.multi-apply .multiselect-apply-btn', function (e) {
            selectItem();
        });

        initialize(); //initial load
    }();
};