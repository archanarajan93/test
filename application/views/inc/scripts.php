<script>
    var baseUrlPMD = '<?php echo base_url();?>'; var userId = '<?php echo isset($_SESSION['CIRSTAYLOGIN']['user_id']) ? $_SESSION['CIRSTAYLOGIN']['user_id'] : 0;?>';
    var userName = '<?php echo isset($_SESSION['CIRSTAYLOGIN']['user_name']) ? $_SESSION['CIRSTAYLOGIN']['user_name'] : 0;?>',
        userUnitCode = '<?php echo isset($_SESSION['CIRSTAYLOGIN']['user_unit_code']) ? $_SESSION['CIRSTAYLOGIN']['user_unit_code'] : 0;?>',
        userUnitName = '<?php echo isset($_SESSION['CIRSTAYLOGIN']['user_unit_name']) ? $_SESSION['CIRSTAYLOGIN']['user_unit_name'] : 0;?>',
        userProductName = '<?php echo isset($_SESSION['CIRSTAYLOGIN']['user_product_code']) ? $_SESSION['CIRSTAYLOGIN']['user_product_code'] : 0;?>',
        hostAddress = location.protocol + '//' + location.host;
</script>
<?php  if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
<script src="<?php echo base_url('assets/js/vendor/jquery-2.2.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/app.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/text.js'); ?>"></script>
<!--<script src="<?php //echo base_url('assets/js/vendor/spin.min.js'); ?>"></script>
<script src="<?php //echo base_url('assets/js/vendor/ladda.min.js'); ?>"></script>-->
<script src="<?php echo base_url('assets/js/vendor/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jquery.inputmask.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jquery.inputmask.date.extensions.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/bootstrap-timepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/datatables.min.js?v=1.10.19'); ?>"></script>
<!--<script src="<?php echo base_url('assets/js/vendor/dataTables.fixedColumns.min.js'); ?>"></script>-->
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>-->
<script src="<?php echo base_url('assets/js/vendor/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jstz.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/util.js?v='.$this->config->item('version')); ?>"></script>
<script src="<?php echo base_url('assets/js/Help.js?v='.$this->config->item('version')); ?>"></script>
<?php } else {?>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('scripts.php?ext=js&v='.$this->config->item('version'));?>"></script>
<?php }?>
<script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js'); ?>"></script>
<script>
    var timeZone = jstz.determine().name(),
	            userTZ = CIRCULATION.utils.getCookie("USERTZ");
    if (userTZ != timeZone) {
        CIRCULATION.utils.setCookie("USERTZ", timeZone, 100);
    }
    var url = '//123.63.104.234:3000';
    var socket = io.connect(location.protocol + url, { secure: true });
    socket.on('connect_error', handleNoConnect);
    socket.on('connect', onConnect);

    function handleNoConnect() {
        //console.log("No connection to "+location.protocol + "//124.124.113.125:3000");
        //socket = io.connect(location.protocol + '//192.168.0.6:3000');
        socket = io.connect(location.protocol + url, { secure: true });
        socket.on('connect_error', handleNoConnect2);
        socket.on('connect', onConnect);
    }
    function handleNoConnect2() {
        //console.log("No connection to " + location.protocol + "//192.168.0.6:3000");
        // decide what to do when you can't connect to either
    }
    function onConnect() {
        console.log("connected");
        // set other event handlers on a connected socket
        socket.on('disconnect', function () {
            console.log("disconnected");
        });
    }
</script>