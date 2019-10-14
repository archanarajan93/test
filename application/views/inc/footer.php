<footer class="main-footer hideOnprint">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2019 <a href="#">CIRCULATION</a></strong></footer>
<!--SCROLL TO TOP-->
<img class="scrollup" src="<?php echo base_url('assets/imgs/goTop.png'); ?>">
<!--LOADING DIV-->
<div class="bg_overlay hide" id="process_loader_bg"></div>
<div class="loader_img hide" id="process_loader">
    <img width="100" src="<?php echo base_url('assets/imgs/loading.gif');?>"><br />
    <span class="loader_txt">Processing your request. Please wait..</span>
</div>
<!-- Common Modal -->
<div class="modal fade" id="common-modal" tabindex="-1" role="dialog" aria-labelledby="common-modalTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="padding-top:0px;padding-bottom:0px;" class="modal-header">                
                <button style="text-shadow:none;color:#FFF;opacity:1" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="common-modal-body" class="modal-body"></div>
            <div id="common-modal-footer" class="modal-footer hide"></div>
        </div>
    </div>
</div>
<!-- Html Message Modal -->
<div class="modal fade" id="html-modal" tabindex="-1" role="dialog" aria-labelledby="html-modalTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document" style="margin-top: 13%;width: 427px;">
        <div class="modal-content" style="border-radius: 5px;">
            <div id="html-modal-body" class="modal-body" style="text-align: center;font-size: 15px !important;">
                <div class="custom-alert showCustomAlert visible" style="background-color: #ffffff;width: auto;position: relative;left: 0;top: 0;overflow: hidden;z-index: 2000;display: block;margin: 0 0 0 0;padding: 2px 17px 11px 17px;">
                    <div class="sa-icon sa-success animate" style="display: none;">
                        <span class="sa-line sa-tip animateSuccessTip"></span>
                        <span class="sa-line sa-long animateSuccessLong"></span>
                        <div class="sa-placeholder"></div>
                        <div class="sa-fix"></div>
                    </div>
                    <div class="sa-icon sa-error animate" style="display: none;">
                        <span class="sa-x-mark">
                            <span class="sa-line sa-left"></span>
                            <span class="sa-line sa-right"></span>
                        </span>
                    </div>
                </div>
            <div style="color:#777; margin-bottom:20px;" id="msg-content"></div>
                <div class="sa-button-container">
                    <div class="sa-confirm-button-container">
                        <button class="btn btn-lg btn-primary" id="customalert-btn" tabindex="1" style="display: inline-block;">OK</button><div class="la-ball-fall">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<audio id="notif_audio"><source src="<?php echo base_url('sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('sounds/notify.wav');?>" type="audio/wav"></audio>
<!-- Export excel --> 
<form method="post" id="tDataform" class="excelForm">
    <textarea style="display:none;" id="tData" name="tableData"></textarea>
</form>