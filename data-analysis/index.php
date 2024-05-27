<?php

function readJsonFile($filename) {
    if (!file_exists($filename)) {
        die("File not found");
    }
    $json = file_get_contents($filename);
    return json_decode($json, true);
}

$data = readJsonFile('./message.json');

$totalSent = 0;
$totalReceived = 0;
$sentLength = 0;
$receivedLength = 0;
$wordCount = [];

foreach ($data as $message) {
    if ($message['status'] == 'sent') {
        $totalSent++;
        $sentLength += strlen($message['content']);
    } elseif ($message['status'] == 'received') {
        $totalReceived++;
        $receivedLength += strlen($message['content']);
    }

    $words = explode(' ', $message['content']);
    foreach ($words as $word) {
        if (!empty($word)) {
            if (isset($wordCount[$word])) {
                $wordCount[$word]++;
            } else {
                $wordCount[$word] = 1;
            }
        }
    }
}

$averageSentLength = $totalSent ? $sentLength / $totalSent : 0;
$averageReceivedLength = $totalReceived ? $receivedLength / $totalReceived : 0;

$topWords = array_slice($wordCount, 0, 5, true);

echo "Total pesan terkirim: $totalSent\n";
echo "Total pesan yang diterima: $totalReceived\n";
echo "Rata-rata panjang karakter yang dikirim: " . number_format($averageSentLength, 2) . "\n";
echo "Rata-rata panjang karakter yang diterima: " . number_format($averageReceivedLength, 2) . "\n";
echo "5 kata-kata terbanyak beserta jumlahnya:\n";
foreach ($topWords as $word => $count) {
    echo "$word: $count\n";
}
?>