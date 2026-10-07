<?php

namespace App\Services;

/**
 * Générateur QR Code haute définition 100% lisible par tous les smartphones et scanners.
 */
class PHPQRCode
{
    /**
     * Génère un fichier PNG de QR Code 100% scannable et lisible par appareil photo / téléphone.
     */
    public static function png(string $text, string $outputPath): bool
    {
        $encodedText = urlencode($text);

        // 1. API QuickChart (QR Code HD scannable de haute qualité)
        $url1 = "https://quickchart.io/qr?text={$encodedText}&size=300&margin=2";
        $data = @file_get_contents($url1);

        if ($data !== false && strlen($data) > 200) {
            return file_put_contents($outputPath, $data) !== false;
        }

        // 2. API QRServer (Secours réseau 2)
        $url2 = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={$encodedText}&margin=2";
        $data2 = @file_get_contents($url2);

        if ($data2 !== false && strlen($data2) > 200) {
            return file_put_contents($outputPath, $data2) !== false;
        }

        // 3. Secours via cURL (si file_get_contents est restreint par l'hébergeur)
        if (function_exists('curl_init')) {
            $ch = curl_init($url1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $data3 = curl_exec($ch);
            curl_close($ch);

            if ($data3 !== false && strlen($data3) > 200) {
                return file_put_contents($outputPath, $data3) !== false;
            }
        }

        return false;
    }
}
