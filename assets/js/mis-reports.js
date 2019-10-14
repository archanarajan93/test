var CIRCULATION = CIRCULATION || {};
CIRCULATION.misreports = (function () {
    /***************
    *Private Region*
    ****************/

    /**************
    *Public Region*
    ***************/
    return {
        init: function () {
            new HelpController({
                fields: '#product,#product_group,#acm,#team_member,#groupwise,#unit,#copy_type,#scheme,#grp_mem,#all_month,#agent,#billing_period,#billing_period_to,#agent_groups,#final_status,#subscriber,#amendment_type,#response,#status,#department,#entrytype,#copymaster,#copy_group,#canvassed_by',
                fieldBtns: '#product_search,#product_group_search,#acm_search,#team_member_search,#groupwise_search,#unit_search,#copy_type_search,#scheme_search,#grp_mem_search,#all_month_search,#agent_search,#billing_period_search,#billing_period_to_search,#agent_groups_search,#final_status_search,#subscriber_search,#amendment_type_search,#response_search,#status_search,#department_search,#entrytype_search,#copymaster_search,#copy_group_search,#canvassed_by_search'
            });

            var fields = { "5": "promoter_unit", "6": "acm_unit", "7": "bureau_unit", "8": "union_unit", "9": "shakha_unit", "10": "edition_unit", "11": "route_unit", "12": "drop_unit" };

            //plan for copies
            if (page == 'PLAN-COPIES') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                $(".select2").select2();
                $("#show_summ").click(function () {
                    $("#plancopies_report").attr("action", baseUrlPMD + 'MISReports/PlanForCopiesSummary').submit();
                });
                $("#show_detailed").click(function () {
                    $("#plancopies_report").attr("action", baseUrlPMD + 'MISReports/PlanForCopiesDetailed').submit();
                });
                $("#unit").change(function () {
                    $("#acm").val('');
                    $("#acm").closest('.search-module').find('.multiselect-text').remove();
                    $("#team_member").val('');
                    $("#team_member").closest('.search-module').find('.multiselect-text').remove();
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                 $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "auto",
                    "scrollX": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
            }
            //collection target
            else if (page == 'COLLECTION-TARGET') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });

                //toggle-unitwise-product-wise
                $("#type").change(function () {
                    if ($(this).val() != '1') {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
                        $(".toggle-grps, #detailed-btn").removeClass("hide");
                        $("#show_settlement").val(1);
                    }
                    else {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
                        $(".toggle-grps, #detailed-btn").addClass("hide");
                        $("#show_settlement").val(0);
                    }
                    $("#unit-wrap .multiselect-text, #groupwise-wrap .multiselect-text").remove();
                    $("#unit, #groupwise, #agent_groups, #agent_groups_rec_sel").val('');
                    $("#unit_rec_sel").remove();
                });

                //group-wise
                $("#groups").change(function () {
                    var val = $(this).val();
                    $("#groupwise").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                    $("#groupwise-wrap .multiselect-text").remove();
                    $("#groupwise").val('');
                    $("#member-title").html($("#groups option:selected").text());
                    var data = JSON.parse($("#groupwise").attr("data-criteria"));
                    for (var i = 0; i < data.length; i++) {
                        data[i].column = fields[val];
                    }
                    $("#groupwise").removeAttr("data-criteria").attr("data-criteria", JSON.stringify(data));
                });

                //toggle-action-of-form
                $(".show-report").click(function () {
                    if ($(this).attr("data-type") == 'summary') {
                        $("#dct-pilot").attr("action", baseUrlPMD + 'MISReports/CollectionTargetSummary').submit();
                    }
                    else {
                        $("#dct-pilot").attr("action", baseUrlPMD + 'MISReports/CollectionTargetDetailed').submit();
                    }
                });

                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });
            }
            //scheme details
            else if (page == 'SCHEME-DETAILS') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });

                //toggle-unitwise-product-wise
                $("#type").change(function () {
                    if ($(this).val() != '1') {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
                        $(".toggle-grps").removeClass("hide");
                        $("#detailed-btn").attr("disabled", false);
                    }
                    else {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
                        $(".toggle-grps").addClass("hide");
                        $("#detailed-btn").attr("disabled", true);
                    }
                    $("#unit-wrap .multiselect-text, #groupwise-wrap .multiselect-text").remove();
                    $("#unit, #groupwise").val('');
                    $("#unit_rec_sel").remove();
                });

                //group-wise
                $("#groups").change(function () {
                    var val = $(this).val();
                    $("#groupwise").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                    $("#groupwise-wrap .multiselect-text").remove();
                    $("#groupwise").val('');
                    $("#member-title").html($("#groups option:selected").text());
                    var data = JSON.parse($("#groupwise").attr("data-criteria"));
                    for (var i = 0; i < data.length; i++) {
                        data[i].column = fields[val];
                    }
                    $("#groupwise").removeAttr("data-criteria").attr("data-criteria", JSON.stringify(data));
                });

                $("#show_summ").click(function () {
                    $("#schdetails_report").attr("action", baseUrlPMD + 'MISReports/SchemeDetailsSummary').submit();
                });
                $("#show_detailed").click(function () {
                    $("#schdetails_report").attr("action", baseUrlPMD + 'MISReports/SchemeDetailsDetailed').submit();
                });

                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "500px",
                    "scrollX": true
                });
            }
            //daily-canvas-copies
            else if (page == 'DAILY-CANVAS-COPY') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true
                });

                $("#type").change(function () {
                    if ($(this).val() != '1') {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
                    }
                    else {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
                    }
                    $("#unit-wrap .multiselect-text").remove();
                    $("#unit").val('');
                });

                $(".drill-down").click(function () {
                    $("#daily-canvass-copies-detailed-form").submit();
                });
            }
            //cheque-bounce-monitor
            else if (page == 'CHEQUE-BOUNCE-MONITOR') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true,
                    "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
                });

                //toggle-unitwise-group-wise
                $("#type").change(function () {
                    if ($(this).val() != '1') {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
                        $(".toggle-grps").removeClass("hide");
                        $("#detailed-btn").attr("disabled", false);
                        $("#detbtn-blck").css({ "display": "block" });
                        $("#unit").attr("required","");
                    }
                    else {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
                        $(".toggle-grps").addClass("hide");
                        $("#detailed-btn").attr("disabled", true);
                        $("#detbtn-blck").css({ "display": "none" });
                        $("#unit").removeAttr("required");
                    }
                    $("#unit-wrap .multiselect-text, #groupwise-wrap .multiselect-text").remove();
                    $("#unit, #groupwise").val('');
                    $("#unit_rec_sel").remove();
                });

                //group-wise
                $("#groups").change(function () {
                    $("#groupwise").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": $(this).val(), "search": "" }));
                    $("#groupwise-wrap .multiselect-text").remove();
                    $("#groupwise").val('');
                    $("#member-title").html($("#groups option:selected").text());
                });

                //toggle-action-of-form
                $(".show-report").click(function () {
                    if ($(this).attr("data-type") == 'summary') {
                        $("#cbm-pilot").attr("action", baseUrlPMD + 'MISReports/ChequeBounceMonitorSummary').submit();
                    }
                    else {
                        $("#cbm-pilot").attr("action", baseUrlPMD + 'MISReports/ChequeBounceMonitorDetailed').submit();
                    }
                });
            }
            //other-income-monitor
            else if (page == 'OTHER-INCOME-MONITOR') {
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "45vh",
                    "scrollX": true
                });
				$("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
            }
            //monthly income split
            else if (page == 'MONTH-INCOME-SPLIT') {
                $("#month,#month_from,#month_to").datepicker({
                    format: "M yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                $("#report_type").change(function () {
                    if ($(this).val() == 'Unitwise') {
                        $(".multi-unit-sel").css({ "display": "block" });
                        $(".unit-sel").css({ "display": "none" });
                        $(".multi-month-sel").css({ "display": "none" });
                        $(".month-sel").css({ "display": "block" });
                    } else {
                        $(".multi-unit-sel").css({ "display": "none" });
                        $(".unit-sel").css({ "display": "block" });
                        $(".multi-month-sel").css({ "display": "block" });
                        $(".month-sel").css({ "display": "none" });
                    }
                });
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true
                });
            }
            //scheme-reports-contributors-non-contributors
            else if (page == 'SCHEME-REPORTS') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true
                });
            }
	        //agent details - 1 day
            else if (page == 'AGENT-COPY-DETAILS') {
                $(".select2").select2();
				$("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
            }
	        //copy-drop-chart
            else if (page == 'COPY-DROP-CHART') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //toggle-unitwise-product-wise
                $("#type").change(function () {
                    if ($(this).val() != '1') {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
                        $(".toggle-grps, #detailed-btn").removeClass("hide");
                    }
                    else {
                        $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
                        $(".toggle-grps, #detailed-btn").addClass("hide");
                    }
                    $("#unit-wrap .multiselect-text, #groupwise-wrap .multiselect-text").remove();
                    $("#unit, #groupwise").val('');
                    $("#unit_rec_sel").remove();
                });

                //group-wise
                $("#groups").change(function () {
                    var val = $(this).val();
                    $("#groupwise").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
                    $("#groupwise-wrap .multiselect-text").remove();
                    $("#groupwise").val('');
                    $("#member-title").html($("#groups option:selected").text());
                    var data = JSON.parse($("#groupwise").attr("data-criteria"));
                    for (var i = 0; i < data.length; i++) {
                        data[i].column = fields[val];
                    }
                    $("#groupwise").removeAttr("data-criteria").attr("data-criteria", JSON.stringify(data));
                });
                //toggle-action-of-form
                $(".show-report").click(function () {
                    if ($(this).attr("data-type") == 'summary') {
                        $("#cdc-pilot").attr("action", baseUrlPMD + 'MISReports/CopyDropChartSummary').submit();
                    }
                    else {
                        $("#cdc-pilot").attr("action", baseUrlPMD + 'MISReports/CopyDropChartDetailed').submit();
                    }
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true
                });

                $(".drill-down").click(function () {
                    $("#copy-drop-detailed-form").submit();
                });

            }
            //ledger summary
            else if (page == 'LEDGER-SUMMARY') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true
                });
                $("#show-report").click(function () {
                    $("#ledger-pilot").submit();
                });
                $("#report_mode").change(function () {
                    if ($(this).val() == '0') {
                        $("#ledger-pilot").attr("action", baseUrlPMD + 'MISReports/LedgerSummary?g_fe=xEdtsg' + $(this).val());
                    } else {
                        $("#ledger-pilot").attr("action", baseUrlPMD + 'MISReports/LedgerSummary?g_fe=xEdtsg' + $(this).val());
                    }
                });
            }
           //agent print order
            else if (page == 'AGENT-PRINT-ORDER') {
                $(".select2").select2();
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                $("#report_mode").change(function () {
                    if ($(this).val() == '0') {
                        $("#agent-printorder-pilot").attr("action", baseUrlPMD + 'MISReports/AgentPrintOrder?g_fe=xEdtsg' + $(this).val());
                    } else {
                        $("#agent-printorder-pilot").attr("action", baseUrlPMD + 'MISReports/AgentPrintOrder?g_fe=xEdtsg' + $(this).val());
                    }
                });
                $("#show-report").click(function () {
                    $("#agent-printorder-pilot").submit();
                });
                //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
            }
            //ente-kaumudi
	        else if (page == 'ENTE-KAUMUDI') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
                
                //toggle-action-of-form
                $(".show-report").click(function () {
                    if ($(this).attr("data-type") == 'summary') {
                        $("#ek-pilot").attr("action", baseUrlPMD + 'MISReports/EnteKaumudySummary').submit();
                    }
                    else {
                        var unitRec = $(".multi_sel_unit").val();
                        if (unitRec) {
                            var unitParse = JSON.parse(decodeURIComponent(unitRec));
                            if (unitParse.length == 1) {
                                $("#ek-pilot").attr("action", baseUrlPMD + 'MISReports/EnteKaumudyDetailed').submit();
                            }
                            else {
                                sweetAlert("", "Multiple units not allowed for detailed reports", "error");
                            }
                        }
                        else {
                            sweetAlert("", "Please select unit", "error");
                        }
                    }
                });
	            //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true
                });
	        }
            //CRM-scheme-reports
	        else if (page == 'CRM-SCHEME-REPORTS') {
                $("[data-mask]:not([readonly])").inputmask();
                $('[data-mask]:not([readonly])').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    toggleActive: true
                });
	            //clone table data before datatable
                CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
                $('.table-results').DataTable({
                    "paging": false,
                    "info": false,
                    "aaSorting": [],
                    "scrollY": "50vh",
                    "scrollX": true
                });
	        }
            //cumulative-receipt-summary
	        else if (page == 'CUMULATIVE-RECEIPT-SUMMARY') {
	            $("[data-mask]:not([readonly])").inputmask();
	            $('[data-mask]:not([readonly])').datepicker({
	                format: "dd-mm-yyyy",
	                autoclose: true,
	                todayHighlight: true,
	                toggleActive: true
	            });

	            //toggle-unitwise-product-wise
	            $("#type").change(function () {
	                if ($(this).val() != '1') {
	                    $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
	                    $("#prev_months").removeClass("hide");
	                }
	                else {
	                    $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
	                    $("#prev_months").addClass("hide");
	                }
	                $("#unit-wrap .multiselect-text, #groupwise-wrap .multiselect-text").remove();
	                $("#unit, #groupwise").val('');
	                $("#unit_rec_sel").remove();
	            });


	            //clone table data before datatable
	            CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
	            $('.table-results').DataTable({
	                "paging": false,
	                "info": false,
	                "aaSorting": [],
	                "scrollY": "50vh",
	                "scrollX": true
	            });

	            //show report
	            $(".show-report").click(function () {
	                if ($("#type").val() == '1') {
	                    //unitwise
	                    $("#crs-pilot").attr("action", baseUrlPMD + 'MISReports/CumulativeReceiptSummaryUnitwise').submit();
	                }
	                else {
	                    //groupwise
	                    $("#crs-pilot").attr("action", baseUrlPMD + 'MISReports/CumulativeReceiptSummaryMonthwise').submit();
	                }
	            });

	            $(".drill-down").click(function () {
	                $("#crs-unitwise-drilldown-form").submit();
	            });
	        }
	        //Bonus Analysis
	        else if (page == 'BONUS-ANALYSIS') {
	            //clone table data before datatable
	            CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
	            $('.table-results').DataTable({
	                "paging": false,
	                "info": false,
	                "aaSorting": [],
	                "scrollY": "50vh",
	                "scrollX": true,
	                "columnDefs": [{ "orderable": false, "targets": "no-sort" }]
	            });

	            //toggle-unitwise-group-wise
	            $("#type").change(function () {
	                if ($(this).val() != '1') {
	                    $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
	                    $(".toggle-grps").removeClass("hide");
	                    $("#detailed-btn").attr("disabled", false);
	                    $("#detbtn-blck").css({ "display": "block" });
	                    $("#unit").attr("required", "");
	                }
	                else {
	                    $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
	                    $(".toggle-grps").addClass("hide");
	                    $("#detailed-btn").attr("disabled", true);
	                    $("#detbtn-blck").css({ "display": "none" });
	                    $("#unit").removeAttr("required");
	                }
	                $("#unit-wrap .multiselect-text, #groupwise-wrap .multiselect-text").remove();
	                $("#unit, #groupwise").val('');
	                $("#unit_rec_sel").remove();
	            });

	            //group-wise
	            $("#groups").change(function () {
	                $("#groupwise").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": $(this).val(), "search": "" }));
	                $("#groupwise-wrap .multiselect-text").remove();
	                $("#groupwise").val('');
	                $("#member-title").html($("#groups option:selected").text());
	            });

	            //toggle-action-of-form
	            $(".show-report").click(function () {
	                if ($(this).attr("data-type") == 'summary') {
	                    $("#bonusans-form").attr("action", baseUrlPMD + 'MISReports/BonusAnalysisSummary').submit();
	                }
	                else {
	                    $("#bonusans-form").attr("action", baseUrlPMD + 'MISReports/BonusAnalysisDetailed').submit();
	                }
	            });
	        }
            //monthly-evaluation
	        else if (page == 'MONTHLY-EVALUATION') {

	            //toggle-unitwise-product-wise
	            $("#type").change(function () {
	                if ($(this).val() != '1') {
	                    $("#unit").removeAttr("data-multiselect").attr("data-multiselect", false);
	                    $("#detailed-wrap").removeClass('hide');
	                }
	                else {
	                    $("#unit").removeAttr("data-multiselect").attr("data-multiselect", true);
	                    $("#detailed-wrap").addClass('hide');
	                }
	                $("#unit-wrap .multiselect-text, #groupwise-wrap .multiselect-text").remove();
	                $("#unit, #groupwise").val('');
	                $("#unit_rec_sel").remove();
	            });

	            //clone table data before datatable
	            CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
	            $('.table-results').DataTable({
	                "paging": false,
	                "info": false,
	                "aaSorting": [],
	                "scrollY": "50vh",
	                "scrollCollapse": true,
	                "scrollX": true
	            });

	            //show report
	            $(".show-report").click(function () {
	                if ($(this).attr("data-type") == 'summary') {
	                    //unitwise
	                    $("#monthly-eval").attr("action", baseUrlPMD + 'MISReports/MonthlyEvaluationSummary').submit();
	                }
	                else {
	                    //groupwise
	                    $("#monthly-eval").attr("action", baseUrlPMD + 'MISReports/MonthlyEvaluationDetailed').submit();
	                }
	            });
	        }
	        else if (page == 'OTHER-RECEIPT-SUMMARY' || page == 'OTHER-RECEIPT-PDC-SUMMARY') {
	            $("[data-mask]:not([readonly])").inputmask();
	            $('[data-mask]:not([readonly])').datepicker({
	                format: "dd-mm-yyyy",
	                autoclose: true,
	                todayHighlight: true,
	                toggleActive: true
	            });
	            //clone table data before datatable
	            CIRCULATION.utils.exportExcel(null, null, null, null, true, false);
	            $("#canvassed_by_type").change(function () {
	                var val = parseInt($(this).val());
	                var selectIndex = "1,2";
	                $("#can_text").text($("#canvassed_by_type option:selected").text());
	                $("#can_det_text").text($("#canvassed_by_type option:selected").text() + " Details");
	                $("#canvassed_by, .canvassed_by_clr, #canvassed_by_others").val('');
	                if (val) {
	                    $(".canvassed_by_users").removeClass("hide");
	                    $("#canvassed_by_others").addClass("hide");
	                    $("#canvassed_by").removeAttr("data-request").attr("data-request", JSON.stringify({ "id": val, "search": "" }));
	                    if (val == 17) {
	                        selectIndex = "1,2";
	                        $("#canvassed_by").removeAttr("data-criteria").attr("data-criteria", JSON.stringify([{ "column": "agent_unit", "input": "#unit_code", "select": "", "encode": "false", "required": "false" }]));
	                    } else {
	                        selectIndex = "3";
	                        $("#canvassed_by").removeAttr("data-criteria");
	                    }
	                    $("#canvassed_by").removeAttr("data-target").attr("data-target", JSON.stringify([{ "selector": "#canvassed_name", "indexes": selectIndex }]));
	                } else {
	                    $(".canvassed_by_users").addClass("hide");
	                    $("#canvassed_by_others").removeClass("hide");
	                }
	            });

	        }
        }
    }
})();
