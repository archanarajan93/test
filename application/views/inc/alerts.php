<audio id="notify_audio">
  <source src="<?php echo base_url('sounds/notify.ogg');?>" type="audio/ogg">
  <source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg">
  <source src="<?php echo base_url('sounds/notify.m4r');?>" type="audio/mp4">
</audio>
<?php 
$message=json_decode($this->session->flashdata('flash_message'));
$html_message=json_decode($this->session->flashdata('html_flash_message'));
if($message) {
    if($message->status === 400)
    {
?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            sweetAlert("", "<?php echo $message->text; ?>", "error");
        }, false);
    </script>
    <?php }
    else {?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            sweetAlert("", "<?php echo $message->text; ?>", "success");
        }, false);
    </script>
<?php }
}
else if($notify=$this->session->flashdata('notification')) {?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () { CIRCULATION.utils.showInAppNotification("<?php echo $notify['icon'];?>","<?php echo $notify['title'];?>","<?php echo $notify['msg'];?>","<?php echo $notify['url'];?>","<?php echo $notify['type'];?>"); },4000);
        }, false);
</script>
<?php } else if($html_message){
          if($html_message->status === 400){
?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        $("#msg-content").html("<?php echo $html_message->text; ?>");
                        $("#html-modal").modal("toggle");
                        $("#html-modal").find('.sa-success').css({ "display": "none" });
                        $("#html-modal").find('.sa-error').css({ "display": "block" });
                        }, false);
                </script>
<?php
          } else{?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        $("#msg-content").html("<?php echo $html_message->text; ?>");
                        $("#html-modal").modal("toggle");
                        $("#html-modal").find('.sa-error').css({ "display": "none" });
                        $("#html-modal").find('.sa-success').css({ "display": "block" });
                        }, false);
                </script>
          <?php }   
            }?>
