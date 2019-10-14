<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Scheme-Reports-CRM-".date("F-j-Y").".xlsx";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    foreach(range('A','Z') as $columnID) {
        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
    header('Content-Type: application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$FileName.'"');
    $writer->save("php://output");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Scheme Reports - CRM</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php $this->load->view('inc/styles.php');
          $this->load->view('inc/alerts');?>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <?php $this->load->view('inc/header'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <?php $this->load->view('inc/left-side-menu'); ?>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Scheme Reports - CRM</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Scheme Reports - CRM</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">
                        <form id="csr-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/CRMSchemeReports?g_fe=xEdtsg'); ?>">
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                              <label>Date Type</label>
                              <select class="form-control">
                                  <option value="1">Ending Date</option>
                                  <option value="2">Initial Response Date</option>
                                  <option value="3">Comment Date</option>
                              </select>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date From</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="issue_date" name="issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date To</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="issue_date" name="issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                               <label>Unit</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="false" placeholder="" />                                     
                                   <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                               <label>Product</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="product" name="product" data-request='{"id":"18","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                   <div class="input-group-addon btn" id="product_search" data-search="product"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Scheme</label>                                
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="scheme" name="scheme" data-request='{"id":"14","search":""}' data-select="{}" data-multiselect="true" placeholder=""/>
                                   <div class="input-group-addon btn" id="scheme_search" data-search="scheme"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Code</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme No</label>
                                <input autocomplete="off" value="" type="text" class="form-control" id="scheme_no" name="scheme_no"  />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Final Status</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="final_status" name="final_status" data-request='{"id":"24","search":""}' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="final_status_search" data-search="final_status"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button class="btn btn-block btn-primary show-report" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                       </form>
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <?php } elseif(isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body table-responsive">
<table width="100%" border="1" class="table table-results">
  <thead>
    <tr>
      <td colspan="29" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">
        <strong> Scheme Reports - CRM From 01-Sept-2019 to 28-Jun-2019 | 
        Date Type: Ending Date | 
        Unit: THIRUVANANTHAPURAM | 
        Product: DAILY | 
        Schemes: BBS 1 YEAR 2000, UNITY 2019 - 2 YEAR - 4500 | 
        Subscriber: SURESHAN C, STAR BHUVALSAM, ALANTHARA, VENJARAMOODU | 
        Agent: T0128 - JAYAPRAKASH K, VARKALA | 
        Final Status: UNWILLING TO RENEW </strong>
      </td>
    </tr>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Slno</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Code</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Subscriber Name & Address</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Scheme</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>From Date</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>To Date</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Agent Code</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Name</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Status</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Remarks</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>SlNo</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Canvassed By</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Canvassed    Mobile</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Canvassed Dept.</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Sub Code</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Incentive</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Ren Status</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right"><strong>Ren By</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right"><strong>CRM</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Intial Status</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Final Status</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Intial Response</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Int. Response    Date</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Final Response</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>TokenNo</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Unit Code</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Comments</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Comments Date</strong></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Comments By</strong></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>SDTVM00028654</td>
      <td>DR SATHEESH KUMAR    S,SIVA BHAVAN,TC9/1290,SASTHAMANGALAM TRIVANDRUM 695010,2729553 9846015478</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T0668</td>
      <td>VINUKUMARAN NAIR P,    NETHAJI ROAD</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>UDAYAKUMAR K</td>
      <td>9539051351</td>
      <td>P M D</td>
      <td>STVM000068489</td>
      <td align="right">100</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>PENDING-RENEWAL</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td align="right">02-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM074416 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>സ്റ്റാഫിനെ    അറിയിച്ചിട്ടുണ്ട്(ഉദയകുമാർ)​</td>
      <td>12-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>2</td>
      <td>SDTVM00028794</td>
      <td>RAMA    DEVI,YASHAS,PANAPARAKUNNU,,9048838773</td>
      <td>SDS 2016 1 YEAR -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T0749</td>
      <td>THOPPIL SREEKANTAN,    MULACKALTHUKAVU</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>VISHNU P A</td>
      <td>9846632244</td>
      <td>P M D</td>
      <td>STVM000076327</td>
      <td align="right">100</td>
      <td>RENEWED</td>
      <td align="right">1</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>RENEWED</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td align="right">01-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM074317 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>RENEWED</td>
      <td>02-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>3</td>
      <td>SDTVM00028820</td>
      <td>ANILKUMAR    P,SASTHAMVILA VEEDU,TC 7/1195(4),KOORA-175 MARUTHAMKUZHY 695013 VATTIYOORKAVU    P O,9400500995</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T0790</td>
      <td>SURESH KUMAR S.,    KOOTTAMVILA</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>ANU V S NAIR</td>
      <td>9497425887</td>
      <td>PRODUCTION</td>
      <td>STVM000083284</td>
      <td align="right">100</td>
      <td>RENEWED</td>
      <td align="right">1</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>RENEWED</td>
      <td>OTHER RESPONSE</td>
      <td align="right">17-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM076757 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>RENEWED</td>
      <td>08-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>4</td>
      <td>SDTVM00028821</td>
      <td>RAJASEKARAN NAIR,SREE    PRIYA,HOUSE NO 112,NSS ROAD, ANAYARA,9846115818</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T0732</td>
      <td>TEDY A, VENPALAVATTOM</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>ANU V S NAIR</td>
      <td>9497425887</td>
      <td>PRODUCTION</td>
      <td>STVM000068893</td>
      <td align="right">100</td>
      <td>RENEWED</td>
      <td align="right">1</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>RENEWED</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td align="right">03-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM074600 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>RENEWED</td>
      <td>08-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>5</td>
      <td>SDTVM00028823</td>
      <td>SUDHEER    S,VYKUDAM,NEAR SBI UCHAKKADA,PAYATTUVILA,9447167942</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T1194</td>
      <td>AJITH KUMAR A,    KATTUNADA</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>HARITH U R</td>
      <td>9633530878, 695021</td>
      <td>PRODUCTION</td>
      <td>STVM000083286</td>
      <td align="right">100</td>
      <td>RENEWED</td>
      <td align="right">1</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>RENEWED</td>
      <td>NO RESPONSE</td>
      <td align="right">17-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM076759 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>RENEWED</td>
      <td>03-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>6</td>
      <td>SDTVM00028824</td>
      <td>VINOD    R,VAISAKHAM,NAGAROOR P O,KESAVAPURAM KILIMANOOR 695601,9048329549</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T2529</td>
      <td>SOBHANA, KESAVAPURAM</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>REGI A C</td>
      <td>&nbsp;</td>
      <td>BROADCASTING DIVISION</td>
      <td>STVM000083287</td>
      <td align="right">100</td>
      <td>RENEWED</td>
      <td align="right">1</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>RENEWED</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td align="right">03-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM074602 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>RENEWED</td>
      <td>06-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>7</td>
      <td>SDTVM00028888</td>
      <td>RAJEEV S A,TC 17/1234    (12),SRA 177 ,SASTHA NAGAR,PAMGODU,9745340911 2350383</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T1986</td>
      <td>NAGARAJAN S,    ARAYALOOR</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>LIBU M THOMAS</td>
      <td>8606477672</td>
      <td>BROADCASTING DIVISION</td>
      <td>STVM000042617</td>
      <td align="right">100</td>
      <td>RENEWED</td>
      <td align="right">1</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>RENEWED</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td align="right">04-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM074771 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>&nbsp;</td>
      <td>10-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>8</td>
      <td>SDTVM00028897</td>
      <td>MURALEEDHARAN    B,KADAVILAKOM,AYYANKALI ROAD,MEDICAL COLLEGE P. O,2442964 9447041230</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T1092</td>
      <td>KUMAR BABY S,    ANAMUGHAM</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>U 12/26</td>
      <td>MANESH KRISHNA P</td>
      <td>9400370006, 0471 -    2460323, 2570336</td>
      <td>P M D</td>
      <td>STVM000000549</td>
      <td align="right">0</td>
      <td>RENEWED</td>
      <td align="right">1</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>RENEWED</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td align="right">04-Jul-19</td>
      <td>&nbsp;</td>
      <td>TVM074776 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>RENEWED</td>
      <td>02-Aug-19</td>
      <td>RAJI</td>
    </tr>
    <tr role="row">
      <td>9</td>
      <td>SDTVM00028900</td>
      <td>MANAGING    DIRECTOR,KERALA STATE POULTRY DEVELOPMENT    CORPORATION,KUDAPANAKUNNU,TRIVANDRUM,2478585 9495000920</td>
      <td>Unity 2018 1 Year -    2250</td>
      <td align="right">10-Aug-18</td>
      <td align="right">10-Aug-19</td>
      <td>T2427</td>
      <td>RETNAKARAN NAIR A,    KUDAPPANAKUNNU</td>
      <td>PAUSED</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>SANGEETH T P</td>
      <td>9946108180</td>
      <td>FINANCE &amp;    ACCOUNTS</td>
      <td>STVM000068823</td>
      <td align="right">100</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">1</td>
      <td>PMD - RENEWAL</td>
      <td>PMD - RENEWAL</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td align="right">04-Jul-19</td>
      <td>INTERESTED TO RENEW    SCHEME</td>
      <td>TVM074778 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/CRMTokenDetails?g_fe=TVM074776'); ?>"><i class="fa fa-share-square-o" aria-hidden="true"></i></a></td>
      <td>TVM</td>
      <td>പത്രം കിട്ടുന്നുണ്ട്    ,സ്കീം പുതുക്കാം,അതിനായി ഓഗസ്റ്റ് 10 നു മുന്നേ സാറിനെ വിളിച്ചിട്ടു    സ്റ്റാഫിനോട് ചെല്ലാൻ പറഞ്ഞു [AJAYAKUMAR -9495000920]</td>
      <td>04-Jul-19</td>
      <td>GOPIKRISHNA</td>
    </tr>
  </tbody>
</table>
                                              
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel(null, null, null, null, false, true);"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.close()" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       <?php 
       $this->load->view('inc/footer');
       $this->load->view('inc/help');     
       ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'CRM-SCHEME-REPORTS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>