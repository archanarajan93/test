
<?php  if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
<script src="<?php echo base_url('assets/js/vendor/jquery-2.2.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jquery.inputmask.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jquery.inputmask.date.extensions.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/bootstrap-timepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/datatables.min.js?v=1.10.19'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/dataTables.fixedColumns.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/vendor/jstz.min.js'); ?>"></script>
<?php } else {?>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('scripts.php?ext=js&v=8');?>"></script>
<?php }?>
