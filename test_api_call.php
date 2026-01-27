<?php

$url = 'http://127.0.0.1:8000/api/map/properties';
$data = [
    'bounds' => [
        'southwest' => ['lat' => 51.37643474580499, 'lng' => -0.7313614013671854],
        'northeast' => ['lat' => 51.63643474580499, 'lng' => 0.4863614013671854]
    ],
    'zoom_level' => 10
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo "Error occurred\n";
} else {
    echo "Response:\n";
    echo $result;
}