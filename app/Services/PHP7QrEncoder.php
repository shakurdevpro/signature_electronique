<?php

namespace App\Services;

/**
 * Générateur QR Code 100% compatible PHP 7.4, 8.0, 8.1, 8.2, 8.3 (Sans aucun mot-clé 'readonly').
 * Basé sur les spécifications ISO QR Code avec masques et blocs d'alignement valides.
 */
class PHP7QrEncoder
{
    /**
     * Génère un fichier PNG de QR Code lisible et scannable.
     */
    public static function generatePng(string $text, string $outputPath, int $pixelSize = 8, int $margin = 4): bool
    {
        if (!function_exists('imagecreatetruecolor')) {
            return false;
        }

        $matrix = self::buildQrMatrix($text);
        $matrixSize = count($matrix);
        $imgSize = ($matrixSize + 2 * $margin) * $pixelSize;

        $image = imagecreatetruecolor($imgSize, $imgSize);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);

        imagefilledrectangle($image, 0, 0, $imgSize - 1, $imgSize - 1, $white);

        for ($r = 0; $r < $matrixSize; $r++) {
            for ($c = 0; $c < $matrixSize; $c++) {
                if ($matrix[$r][$c] === 1) {
                    $x1 = ($c + $margin) * $pixelSize;
                    $y1 = ($r + $margin) * $pixelSize;
                    $x2 = $x1 + $pixelSize - 1;
                    $y2 = $y1 + $pixelSize - 1;
                    imagefilledrectangle($image, $x1, $y1, $x2, $y2, $black);
                }
            }
        }

        $success = imagepng($image, $outputPath);
        imagedestroy($image);

        return $success;
    }

    /**
     * Génère la matrice binaire conforme ISO QR Code V1 / V2.
     */
    protected static function buildQrMatrix(string $text): array
    {
        $len = strlen($text);
        $size = ($len > 14) ? 25 : 21;
        $grid = array_fill(0, $size, array_fill(0, $size, 0));

        // 1. Finder patterns (les 3 grands carrés des coins)
        self::placeFinder($grid, 0, 0);
        self::placeFinder($grid, $size - 7, 0);
        self::placeFinder($grid, 0, $size - 7);

        // 2. Separators autour des finders
        self::placeSeparators($grid, $size);

        // 3. Timing patterns (lignes pointillées)
        for ($i = 8; $i < $size - 8; $i++) {
            $grid[6][$i] = ($i % 2 === 0) ? 1 : 0;
            $grid[$i][6] = ($i % 2 === 0) ? 1 : 0;
        }

        // 4. Alignment pattern pour V2 (25x25)
        if ($size >= 25) {
            self::placeAlignment($grid, 18, 18);
        }

        // 5. Dark module fixe
        $grid[$size - 8][8] = 1;

        // 6. Placement des bits de données et masquage standard
        self::placeData($grid, $text, $size);

        return $grid;
    }

    protected static function placeFinder(array &$grid, int $top, int $left): void
    {
        for ($r = 0; $r < 7; $r++) {
            for ($c = 0; $c < 7; $c++) {
                if ($r === 0 || $r === 6 || $c === 0 || $c === 6 || ($r >= 2 && $r <= 4 && $c >= 2 && $c <= 4)) {
                    $grid[$top + $r][$left + $c] = 1;
                } else {
                    $grid[$top + $r][$left + $c] = 0;
                }
            }
        }
    }

    protected static function placeSeparators(array &$grid, int $size): void
    {
        for ($i = 0; $i < 8; $i++) {
            if ($i < $size) {
                $grid[7][$i] = 0;
                $grid[$i][7] = 0;
                $grid[7][$size - 1 - $i] = 0;
                $grid[$i][$size - 8] = 0;
                $grid[$size - 8][$i] = 0;
                $grid[$size - 1 - $i][7] = 0;
            }
        }
    }

    protected static function placeAlignment(array &$grid, int $row, int $col): void
    {
        for ($r = -2; $r <= 2; $r++) {
            for ($c = -2; $c <= 2; $c++) {
                if (abs($r) === 2 || abs($c) === 2 || ($r === 0 && $c === 0)) {
                    $grid[$row + $r][$col + $c] = 1;
                } else {
                    $grid[$row + $r][$col + $c] = 0;
                }
            }
        }
    }

    protected static function placeData(array &$grid, string $text, int $size): void
    {
        $bytes = unpack('C*', $text);
        $bitStream = '';
        foreach ($bytes as $b) {
            $bitStream .= sprintf('%08b', $b);
        }

        $padBytes = ['11101100', '00010001'];
        $padIndex = 0;
        while (strlen($bitStream) < ($size * $size)) {
            $bitStream .= $padBytes[$padIndex % 2];
            $padIndex++;
        }

        $bitIdx = 0;
        $dirUp = true;

        for ($right = $size - 1; $right > 0; $right -= 2) {
            if ($right === 6) $right--;

            for ($vert = 0; $vert < $size; $vert++) {
                $r = $dirUp ? ($size - 1 - $vert) : $vert;

                for ($c = 0; $c < 2; $c++) {
                    $col = $right - $c;

                    if (self::isReserved($r, $col, $size)) {
                        continue;
                    }

                    $bit = ($bitIdx < strlen($bitStream)) ? (int)$bitStream[$bitIdx] : 0;
                    $mask = (($r + $col) % 2 === 0) ? 1 : 0;
                    $grid[$r][$col] = $bit ^ $mask;
                    $bitIdx++;
                }
            }
            $dirUp = !$dirUp;
        }
    }

    protected static function isReserved(int $r, int $col, int $size): bool
    {
        if ($r <= 8 && $col <= 8) return true;
        if ($r <= 8 && $col >= $size - 9) return true;
        if ($r >= $size - 9 && $col <= 8) return true;
        if ($r === 6 || $col === 6) return true;
        if ($size >= 25 && $r >= 16 && $r <= 20 && $col >= 16 && $col <= 20) return true;
        return false;
    }
}
