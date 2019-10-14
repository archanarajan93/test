<?php
$root_folder = '/circulation/';
$cache_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.'cache';
if (!is_dir($cache_path)) {
  mkdir($cache_path, 0777, true);
  chmod(dirname(__FILE__).DIRECTORY_SEPARATOR.'writable', 0777); 
  chmod($cache_path, 0777);
}
$HTTP_USER_AGENT = '';
$useragent = (!empty($_SERVER["HTTP_USER_AGENT"])) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
ob_start();
$vendorcss = $cache_path.DIRECTORY_SEPARATOR.'vendor'.md5('css').'en0.css';
if(file_exists($vendorcss)&& $_COOKIE['ENVIRONMENT']=='production'){
	if ((!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($vendorcss)) || (!empty($_SERVER['HTTP_IF_NONE_MATCH']) && @trim($_SERVER['HTTP_IF_NONE_MATCH']) == md5_file($vendorcss))) {
		header("HTTP/1.1 304 Not Modified");
		exit;
	}
	readfile($vendorcss);
	$css = ob_get_clean();
}else{
        $dirty_css .= str_replace("url(../","url(".$root_folder."assets/css/",file_get_contents("assets/css/vendor/bootstrap.min.css"));
        $dirty_css .= str_replace("url('../","url('".$root_folder."assets/css/",file_get_contents("assets/css/vendor/font-awesome.min.css"));
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."bootstrap.min.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."font-awesome.min.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."AdminLTE.min.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."animate.min.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."select2.min.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."ladda-themeless.min.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."cropper.min.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."jquery-ui.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."icheck.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."theme.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."sweetalert.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."customalert.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."bootstrap-datepicker.min.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."bootstrap-timepicker.min.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."bootstrap-colorpicker.min.css");
        include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."datatables.min.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."custom.css");
        //include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."gallery.css");
        $dirty_css2 .= str_replace("url(../","url(".$root_folder."assets/",file_get_contents("assets/css/custom.css"));
        $dirty_css2 = str_replace("url('../","url('".$root_folder."assets/",$dirty_css2);
        $dirty_css2 = str_replace("url(fonts/","url(".$root_folder."assets/css/fonts/", $dirty_css2);
        $dirty_css2 = str_replace("url('fonts/","url('".$root_folder."assets/css/fonts/", $dirty_css2);
	$css = minify($dirty_css.ob_get_clean().$dirty_css2);
	$fp = @fopen($vendorcss,'w');
	@fwrite($fp,$css);
	@fclose($fp);
}
$lastModified = filemtime($vendorcss);
$etag = md5_file($vendorcss);

if(phpversion()>='4.0.4pl1'&&(strstr($useragent,'compatible')||strstr($useragent,'Gecko'))){
	if(extension_loaded('zlib')&&GZIP_ENABLED==1){
		ob_start('ob_gzhandler');
	}else{
		ob_start();
	}
}else{
	ob_start();
}
header('Content-type: text/css;charset=utf-8');

header("Last-Modified: ".gmdate("D, d M Y H:i:s",$lastModified)." GMT");
header('Expires: '.gmdate("D, d M Y H:i:s",time()+3600*24*365).' GMT');
header("Etag: ".$etag);
header("Vary: Accept-Encoding");
echo $css;
function cleanInput($input){
	$input = preg_replace("/[^+A-Za-z0-9\_]/","",trim($input));
	return strtolower($input);
}
function minify($css){
	$css = preg_replace('#\s+#',' ',$css);
	$css = preg_replace('#/\*.*?\*/#s','',$css);
	$css = str_replace('; ',';',$css);
	$css = str_replace(': ',':',$css);
	$css = str_replace(' {','{',$css);
	$css = str_replace('{ ','{',$css);
	$css = str_replace(', ',',',$css);
	$css = str_replace('} ','}',$css);
	$css = str_replace(';}','}',$css);
    //$css = str_replace('url(/','url('.base_url(),$css);
	return trim($css);
}
