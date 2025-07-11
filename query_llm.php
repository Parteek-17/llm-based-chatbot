<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no');

$input = json_decode(file_get_contents("php://input"), true);
$prompt = $input['prompt'] ?? '';

$ch = curl_init('http://localhost:11434/api/generate');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "model" => "phi",
    "prompt" => $prompt,
    "stream" => true
]));

curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
    $lines = explode("\n", $data);
    foreach ($lines as $line) {
        $line = trim($line);
        if (!$line) continue;
        $json = json_decode($line, true);
        if (isset($json['response'])) {
            echo "data: " . $json['response'] . "\n\n";
            @ob_flush();
            flush();
        }
    }
    return strlen($data);
});

curl_exec($ch);
curl_close($ch);

