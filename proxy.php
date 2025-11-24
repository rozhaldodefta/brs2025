<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if (!isset($_GET['url'])) {
    echo json_encode(["error" => "Missing ?url="]);
    exit;
}

$target = $_GET['url'];

// VALIDASI – hanya izinkan API BPS
if (!str_starts_with($target, "https://webapi.bps.go.id")) {
    echo json_encode(["error" => "URL tidak diperbolehkan"]);
    exit;
}

// Ambil data dari API
$ch = curl_init($target);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$error = curl_error($ch);

curl_close($ch);

if ($error) {
    echo json_encode(["error" => "CURL Error", "detail" => $error]);
} else {
    echo $response;
}
?>
