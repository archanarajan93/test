
<!DOCTYPE html>
<html>
<head>
   
   <style>
   .haserror{
   background-color : #fa7c7c;
   }
   .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
    background: #2A3F54 !important;
}

.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
    background-color: #222d32;
}
.wrapper {
    min-height: 100%;
    position: static;
    overflow: hidden;
}
.content-wrapper, .right-side {
    min-height: 100%;
    background-color: #ecf0f5;
    z-index: 800;
}
.content {
    min-height: 250px;
    padding: 15px;
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
}
.box-body {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    padding: 10px;
}

.table-responsive {
    min-height: .01%;
    overflow-x: auto;
}
 .form-control {
    font-size: 12px !important;
}
.form-control {
    color: #73879C;
    border: 1px solid #ccc !important;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%) !important;
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%) !important;
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s !important;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s !important;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s !important;
}
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
}
.form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
       #searchInput {
     
    background-position: 19px 12px;
    background-repeat: no-repeat;
    width: 58%;
    font-size: 16px;
    padding: 14px 20px 13px 85px;
    border: 1px solid #ddd;
    margin-left: 12;
    margin-left: 233px;
}
  
   </style>
    <?php $this->load->view('inc/styles.php');
          $this->load->view('inc/alerts');?>
</head>
<body class="hold-transition skin-blue  sidebar-collapse">
 <div class="content-wrapper">
     <section class="content-header">
                <h1></h1>
            </section>
    <section class="content">
        <div class="box">
            <div class="box-body table-responsive">
                <form method="post" action=" <?php echo base_url('AuthController/CompanyName?g_fe=rfX'); ?>" id="company_stock_form">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <h1 style="text-align: center;">The easiest way to buy and sell stock</h1> 
                            <h4 style="text-align: center;">Stock analysis and screening tool for Investers in India</h4> 
                        </p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="myDropdown">
                        <select type="search" id="searchInput" name="searchInput" onchange="this.form.submit()" placeholder="Search for names.." title="Type in a name" >
                        <option> Select</option>
                         <?php foreach($comp_rec as $rec){?>
                        <option <?php if($rec->comp_slno){echo "selected";}?> value="<?php echo $rec->comp_slno?>"><?php echo $rec->comp_name; ?></option>
                        <?php } ?>
                        </select>
                        
                    </div>
                    

                </form>
                </div>
             </div>
<?php if(isset($_GET['g_fe'])){?>
             <div class="box">
    <div id="append_records" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
        <table width="100%" class="table table-results no-data-tbl" id="cash_book_tbl">
            <thead>
                <tr>
                      <td style="border: 1px solid #eeeeef;background: #d6e6f7;color: #ef2a6a;font-weight: bold;" colspan="11">
                          
                          
                      </td>
                </tr>
                <tr>
                   
                    <td width="15%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;"><b>Name</b></td>
                    <td width="15%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>Current Market Price</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>Market Cap</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>Stock P/E</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>Dividend Yield</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>ROCE %</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>ROE Previous Annum</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>Debt to Equity</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>EPS</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>Reserves	Debt</b></td>
                    <td width="20%" style="border: 1px solid #eeeeef;background: #dcdee0; color:#de521c;text-align:right;"><b>Debt</b></td>
                </tr>
            </thead>
            <tbody>
            <?php  foreach($comp_name_rec as $rec){
                       
            ?>
                <tr class="no-records">
                   <td><?php echo $rec->comp_name; ?></td>
                   <td style="text-align:right;"><?php echo $rec->current_market_price; ?></td>
                   <td style="text-align:right;"><?php echo $rec->market_cap; ?></td>
                   <td style="text-align:right;"><?php echo $rec->stock; ?></td>
                   <td style="text-align:right;"><?php echo $rec->divident_yield; ?></td>
                   <td style="text-align:right;"><?php echo $rec->roce_perc; ?></td>
                   <td style="text-align:right;"><?php echo $rec->roce_previous_ann; ?></td>
                   <td style="text-align:right;"><?php echo $rec->debt_to_equity; ?></td>
                   <td style="text-align:right;"><?php echo $rec->eps; ?></td>
                   <td style="text-align:right;"><?php echo $rec->reservs; ?></td>
                   <td style="text-align:right;"><?php echo $rec->debt; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
   
</div>
<?php } ?>
            </section> 
</div>
        <script>
           
        function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("txtHint").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","getuser.php?q="+str,true);
  xmlhttp.send();
}
           </script>
 <script>
        var page = 'SEARCH-COMPANY';
    </script>
       <?php $this->load->view('inc/scripts.php');?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/util.js?v=2'); ?>"></script>  
    <script src="<?php echo base_url('assets/js/registration.js?v=2'); ?>"></script>  
    </body>
</html>
