<?php
$cache_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.'cache';
if (!is_dir($cache_path)) {
  mkdir($cache_path, 0777, true);
  chmod(dirname(__FILE__).DIRECTORY_SEPARATOR.'writable', 0777);
  chmod($cache_path, 0777);
}
//$mtime = explode(" ",microtime());
//$starttime = $mtime[1]+$mtime[0];
$HTTP_USER_AGENT = '';
$useragent = (!empty($_SERVER["HTTP_USER_AGENT"])) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
ob_start();
$vendorjs = $cache_path.DIRECTORY_SEPARATOR.'vendor'.md5('js').'en0.js';
if(file_exists($vendorjs)&& $_COOKIE['ENVIRONMENT']=='production'){
	if ((!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($vendorjs)) || (!empty($_SERVER['HTTP_IF_NONE_MATCH']) && @trim($_SERVER['HTTP_IF_NONE_MATCH']) == md5_file($vendorjs))) {
		header("HTTP/1.1 304 Not Modified");
		exit;
	}
	readfile($vendorjs);
	$js = ob_get_clean();
}else{
        $js .= "/*jquery begins here*/".file_get_contents("assets/js/vendor/jquery-2.2.0.min.js");
        $js .= "/*jquery begins here*/".file_get_contents("assets/js/vendor/jquery-ui.js");
        $js .= "/*bootstrap begins here*/".file_get_contents("assets/js/vendor/bootstrap.min.js");
        $js .= "/*adminlte begins here*/".file_get_contents("assets/js/vendor/app.min.js");
        $js .= "/*sweetalert begins here*/".file_get_contents("assets/js/vendor/sweetalert.min.js");
        //$js .= "/*ladda spin begins here*/".file_get_contents("assets/js/vendor/spin.min.js");
        //$js .= "/*ladda begins here*/".file_get_contents("assets/js/vendor/ladda.min.js");
        $js .= "/*inputmask begins here*/".file_get_contents("assets/js/vendor/jquery.inputmask.js");
        $js .= "/*input date mask begins here*/".file_get_contents("assets/js/vendor/jquery.inputmask.date.extensions.js");
        $js .= "/*datepicker begins here*/".file_get_contents("assets/js/vendor/bootstrap-datepicker.min.js");
        $js .= "/*timepicker begins here*/".file_get_contents("assets/js/vendor/bootstrap-timepicker.min.js");
        $js .= "/*select2 begins here*/".file_get_contents("assets/js/vendor/select2.full.min.js");
        $js .= "/*datatables begins here*/".file_get_contents("assets/js/vendor/datatables.min.js");
        $js .= "/*momentjs begins here*/".file_get_contents("assets/js/vendor/moment.min.js");
        $js .= "/*jstz begins here*/".file_get_contents("assets/js/vendor/jstz.min.js");
	$js .= "/*jsapi google transileration begins here*/".file_get_contents("assets/js/vendor/jsapi.min.js");
	$js .= "/*datatable fixed column begins here*/".file_get_contents("assets/js/vendor/dataTables.fixedColumns.min.js");
        //$js .= "/*cropper begins here*/".file_get_contents("assets/js/vendor/cropper.min.js");
        /*Unminified files add below*/
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."Help.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."text.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."util.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."dashboard.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."masters.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."settings.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."admin-tools.js");
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."transactions.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."crm.js");
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."mis-reports.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."dcr.js");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."tools.js");
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."build-docs.js");
	if(phpversion()>='5'){
	    include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'jsmin_helper.php');
		$js .= JSMin::minify(ob_get_clean());
	}else{
		$js .= ob_get_clean();
	}
	$fp = @fopen($vendorjs,'w');
	@fwrite($fp,$js);
	@fclose($fp);
}
$lastModified = filemtime($vendorjs);
$etag = md5_file($vendorjs);
if(phpversion()>='4.0.4pl1'&&(strstr($useragent,'compatible')||strstr($useragent,'Gecko'))){
	if(extension_loaded('zlib')&&GZIP_ENABLED==1){
		ob_start('ob_gzhandler');
	}else{
		ob_start();
	}
}else{
	ob_start();
}
header('Content-type: text/javascript;charset=utf-8');
//if(!empty($client)) {
//    header('Content-Length: '. strlen($js));
//    $tags = array(
//        'cod-'.$_SERVER['environment'].'-'.$client,
//        'cod-'.$_SERVER['environment'].'-'.$client.'-'.$lang,
//        'cod-'.$_SERVER['environment'].'-'.$client.'-'.$layout,
//        'cod-'.$_SERVER['environment'].'-'.$client.'-'.$color,
//        'cod-'.$_SERVER['environment'].'-'.$client.'-'.$enablecustomjs /* or css */
//    );
//    header('Cache-Tag: '.implode(' ', $tags));
//}
header("Last-Modified: ".gmdate("D, d M Y H:i:s",$lastModified)." GMT");
header('Expires: '.gmdate("D, d M Y H:i:s",time()+3600*24*365).' GMT');
header("Etag: ".$etag);
header("Vary: Accept-Encoding");
echo $js;
//$mtime = explode(" ",microtime());
//$endtime = $mtime[1]+$mtime[0];
//if(empty($client)) {
//    echo "\n\n/* Execution time: ".($endtime-$starttime)." seconds */";
//}
function cleanInput($input){
	return strtolower(preg_replace("/[^+A-Za-z0-9\_]/","",trim($input)));
}
