<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Pastikan parameter url ada
if (!isset($_GET['url'])) {
    echo json_encode(["error" => "Missing ?url parameter"]);
    exit;
}

$target = $_GET['url'];

// Batasi hanya untuk API BPS (keamanan)
if (!str_starts_with($target, "https://webapi.bps.go.id")) {
    echo json_encode(["error" => "URL tidak diperbolehkan"]);
    exit;
}

// CURL request
$ch = curl_init($target);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(["error" => $error]);
} else {
    echo $response;
}
?>
