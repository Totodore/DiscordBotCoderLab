
<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET["start"])) {
    echo "Error, argument start not provided";
    exit;
}

$helping = json_decode(file_get_contents("./state.json"), true)["helping"];

$webhookurl = "https://discordapp.com/api/webhooks/656608504072634378/RY4yN4F7DbnXyuSyZiU9MiY8Ip9tyw7oqnKBvTeQltIsYNtJ6aAeuBykSUyNTWMDioLs";
if ($_GET["start"] == "true" && !$helping) {
    $msg = ">>> Hey @everyone ! Help et support dispo en **code/informatique** ! ";
    file_put_contents("./state.json", json_encode(Array("helping" => true)));
} else if ($_GET["start"] == "false" && $helping) {
    $msg = ">>> Hey @everyone ! Sry fin de la session de help et support en **code/informatique** ! ";
    file_put_contents("./state.json", json_encode(Array("helping" => false)));
} else {
    header("HTTP/1.1 455 This state is already enabled");
    exit;
}

$json_data = array ('content'=>"$msg");
$make_json = json_encode($json_data);
$ch = curl_init($webhookurl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $make_json);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

//echo $response;
?>