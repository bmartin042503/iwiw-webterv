<?php
session_start();
if (!isset($_SESSION['bejelentkezve']) || !$_SESSION['bejelentkezve']) {
    header('Location: ../index.php');
    exit;
}

$errs = "";

function is_num($str){
    if (is_numeric($str)) {
        $int = intval($str);

        return (string)$int === $str;
    } else return false;
}

if(isset($_POST['residence']))$_SESSION['user_data']['residence'] = $_POST['residence'];
if(isset($_POST['workplace']))$_SESSION['user_data']['workplace'] = $_POST['workplace'];

if(isset($_POST['iwiwplus']))$_SESSION['user_data']['iwiwplus'] = $_POST['iwiwplus']=="igen"?"true":"false";
if(isset($_POST['admin']))$_SESSION['user_data']['admin'] = $_POST['admin']=="igen"?"true":"false";


//require check
$email_regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
if(isset($_POST['email'])){
    if($_POST['email']!=""){
        if(preg_match($email_regex,$_POST['email']))$_SESSION['user_data']['email'] = $_POST['email'];
        else $errs .="Email nem helyes.";
    }
    else $errs .="Email nem lehet üres.";
}

if(isset($_POST['height'])) {
    if($_POST['height']!="") {
        if (is_num($_POST['height'])) {
            if (intval($_POST['height']) > 0 && intval($_POST['height']) < 300) $_SESSION['user_data']['height'] = $_POST['height'];
            else $errs .= "A magasságnak 1 és 299 (zárt intervallum) között kell lennie.\\n";
        } else $errs .= "A magasságnak 1 és 299 (zárt intervallum) közötti egész számnak kell lennie.\\n";
    }
    else $_SESSION['user_data']['height'] = $_POST['height'];
}
if(isset($_POST['weight'])) {
    if($_POST['weight']!=""){
        if (is_num($_POST['weight'])) {
            if (intval($_POST['weight']) > 0 && intval($_POST['weight']) < 300) $_SESSION['user_data']['weight'] = $_POST['weight'];
            else $errs .= "A súlynak 1 és 299 (zárt intervallum) között kell lennie.\\n";
        } else $errs .= "A sújnak 1 és 299 (zárt intervallum) közötti egész kell számnak lennie.\\n";
    }
    else $_SESSION['user_data']['weight'] = $_POST['weight'];
}
if(isset($_POST['acquaintances'])){
    if(is_num( $_POST['acquaintances'])){
        if(intval($_POST['acquaintances'])>=0 && intval($_POST['acquaintances'])<10000 )$_SESSION['user_data']['acquaintances'] = $_POST['acquaintances'];
        else $errs .= "Az imerősök számának 0 és 10000 között (zárt intervallum) között kell lennie.\\n";
    }
    else $errs .="Az ismerősök számának 0 és 10000 között (zárt intervallum) közötti egész számnak  kell lennie.\\n";
}


$data_file_path = '../db/users/' .$_SESSION['user_data']['id'] . '/data.txt';
file_put_contents($data_file_path, serialize($_SESSION['user_data']));

//echo $errs;
//echo '<script>alert("' .$errs. '");</script>';
if($errs != "")echo '<script>alert("' .$errs. '");window.location.href = "profile-edit.php";</script>';
else header('Location: profile-edit.php');

//foreach ($_POST as $key => $value) {
//    echo $key . ': ' . $value . '<br>';
//}

//foreach ($_SESSION['user_data'] as $key => $value) {
//    echo $key . ': ' . $value . '<br>';
//}