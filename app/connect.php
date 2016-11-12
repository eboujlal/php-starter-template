<?php
include "app/functions.php";
include "vendor/Autoloader.php";

Autoloader::registre();
opSess();
ob_start();
if(!isset($aniHna)){
    $db = new MysqliDb('localhost','root','root','ktabi');
}
$lang = 'fr';
if(isset($_SESSION['conf']['lang'])) $lang = $_SESSION['conf']['lang'];
require_once 'at_assets/language/'.$lang.'_lang.php';
?>
