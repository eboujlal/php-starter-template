<?php
/**
 * Created by PhpStorm.
 * User: marouaneboujlal
 * Date: 18/12/2015
 * Time: 21:40
 */

/**
 * @param $var variable
 * @return string return debug du varibale
 */
function debug($var){
   echo "<div class='col-lg-2'></div>";
   echo "<div class='col-lg-8 alert alert-warning'><pre class='alert alert-danger'>".print_r($var,true)."</pre></div>";
   echo "<div class='col-lg-2'></div>";
    die();
}

function opSess(){
    if(session_status()==PHP_SESSION_NONE) session_start();
}
function str_rand($len){
    $alpha = "0123456789azertyuiopmlkjhgfdsqwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN";
    return substr(str_shuffle(str_repeat($alpha,20)),0,$len);
}
function refresh($sec,$url){
    echo "
			<meta http-equiv='refresh' content='".$sec.";url=".$url."' />
		";
}
function getTime(){
    $jour = array("Sanday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");

    $mois = array("","January","Fubruary","Mars","April","May","June","July","August","September","October","November","December");

    $datefr = $jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y");

    return $datefr;

}

function logged(){
    $_SESSION['flash']['danger'] = "Vous deviez se connecter pour accéder à cette page.";
    header('location: login.php');
}

function getFrom($time,$by='/',$lang='EN'){
    //Format
    $moisFR = array("","Janvier","Févirier","Mars","Avrile","Mai","Juin","Juillet","Aôut","Sebtembre","Octobre","Novembre","Décembre");
    $moisEN = array("","January","Fubruary","Mars","April","May","June","July","August","September","October","November","December");
    $moisAR = array("","يناير","فبراير","مارس","أبريل","ماي","يونيو","يوليوز","غشت","شتنبر","أكتوبر","نونبر","دجنبر");
    $req = explode($by,$time);
    //ex de retourne : 19 Décembre 2015
    if($lang=='EN'){
        return $req[0]." ".$moisEN[intval($req[1])]." ".$req[2];
    }elseif($lang=='FR'){
        return $req[2]." ".$moisFR[intval($req[1])]." ".$req[0];
    }elseif($lang=='AR'){
        return $req[2]." ".$moisAR[intval($req[1])]." ".$req[0];

    }
}

function secureString($str){
    return htmlentities(htmlspecialchars(addslashes($str)));
}

function letGoTo($url){
    header("location:$url");
}
function detect() {
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
        $name = 'Internet explorer';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
        $name =  'Internet explorer';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
        $name =  'Mozilla Firefox';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
        $name = 'Google Chrome';
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
        $name = "Opera Mini";
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
        $name =  "Opera";
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
        $name =  "Safari";
    else
        $name =  'Inconu';

    // Running on what platform?
    if (preg_match('/linux/', $userAgent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/', $userAgent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/', $userAgent)) {
        $platform = 'windows';
    }
    else {
        $platform = 'unrecognized';
    }

    return array(
        'browser'      => $name,
        'device'  => $platform,
    );
}
function sqlDate($add=0){
    $date=date_create();
    if($add!=0){
        date_add($date,date_interval_create_from_date_string($add." days"));
    }

    return date_format($date,"Y-m-d");
}

function multiFile(&$dst,$src){
    for($i=0;$i<count($src['name']);$i++){
        $path = pathinfo($src['name'][$i]);
        $tmp = array(
            'name'=>$src['name'][$i],
            'type'=>$src['type'][$i],
            'extension'=>$path['extension'],
            'tmp_name'=>$src['tmp_name'][$i],
            'error'=>$src['error'][$i],
            'size'=>$src['size'][$i]
        );
        array_push($dst,$tmp);
    }
    return;
}
function getValueOf($value,$of){
    if($value==$of) echo 'selected';
    else echo '';
}

function checked($value,$of){
    if($value==$of) echo 'checked';
    else echo '';
}

function translater($key){
    $fr = "azertyuiopmlkjhgfdsqwxcvbn";
    $ar = "ضصثقفغعهخحكمنتالبيسشئءؤرلاى";
    return array(
        'fr'=>$fr[$i],
        'ar'=>$ar[$i]
    );
}

function GenerateUrl ($s) {
    //Convert accented characters, and remove parentheses and apostrophes
    $from = explode (',', ":,ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,i,ø,u,(,),[,],'");
    $to = explode (',', ',c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
    //Do the replacements, and convert all other non-alphanumeric characters to spaces
    //$f = preg_replace ('/[ ^A-Za-z0-9 ]/', '', str_replace ($from, $to,$s));
    //$f = preg_replace ('/[ ]/', '', str_replace ($from, $to,$f));
    $f = "";
    for($i=0;$i<strlen($s);$i++){
        $key = array_search($s[$i],$from);
        if(!is_numeric($key)){
            $f.=$s[$i];
        }else{
            $f.=$to[$key];
        }
    }
    $arf = explode(' ',$f);
    $key = array_search('',$arf);
    while($key != false){

        array_splice($arf,$key,1);

        $key = array_search('',$arf);
    }

    $f = implode('-',$arf);

    //Remove a - at the beginning or end and make lowercase
    return strtolower ($f);
}

function CheckUrl ($s) {
    // Get the current URL without the query string, with the initial slash
    //$myurl = preg_replace ('/?.*$/', '', $_SERVER['REQUEST_URI']);
    //If it is not the same as the desired URL, then redirect
        $srv = trim($_SERVER['REDIRECT_URL'],'/');
        $ns = explode('/',$srv);
        if($s!=$ns[3]){Header ("Location: ../index.php", true, 301); exit;}
    //if ($myurl != "annonces/$s") {Header ("Location: /$s", true, 301); exit;}
}

function getDistanceFromLatLonInKm($lat1,$lon1,$lat2,$lon2) {
    $r = 6371; // Radius of the earth in km
    $dLat = deg2rad($lat2-$lat1);  // deg2rad below
    $dLon = deg2rad($lon2-$lon1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $d = $r * $c; // Distance in km
    return ceil($d);
}
