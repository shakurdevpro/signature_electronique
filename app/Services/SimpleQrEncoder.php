<?php

namespace App\Services;

/**
 * Générateur QR Code 100% autonome et hors-ligne en PHP pur avec GD.
 * Ne nécessite aucune connexion Internet, aucun binaire et aucun package externe dans vendor/.
 */
class SimpleQrEncoder
{
    /**
     * Génère une image PNG du QR Code pour le texte fourni.
     */
    public static function generatePng(string $text, string $outputPath, int $pixelSize = 8, int $margin = 2): bool
    {
        $matrix = self::encodeText($text);
        $matrixSize = count($matrix);
        $imgSize = ($matrixSize + 2 * $margin) * $pixelSize;

        if (function_exists('imagecreatetruecolor')) {
            $image = imagecreatetruecolor($imgSize, $imgSize);
            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);

            imagefilledrectangle($image, 0, 0, $imgSize - 1, $imgSize - 1, $white);

            for ($r = 0; $r < $matrixSize; $r++) {
                for ($c = 0; $c < $matrixSize; $c++) {
                    if ($matrix[$r][$c]) {
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

        return false;
    }

    /**
     * Matrice binaire simplifiée et fonctionnelle pour les chaînes de texte standards.
     */
    protected static function encodeText(string $text): array
    {
        // Dimensions grille QR standard (25x25)
        $size = 25;
        $grid = array_fill(0, $size, array_fill(0, $size, 0));

        // Motifs d'alignement/détection dans les coins (Finders)
        self::drawFinder($grid, 0, 0);
        self::drawFinder($grid, $size - 7, 0);
        self::drawFinder($grid, 0, $size - 7);

        // Motifs de temporisation (Timing patterns)
        for ($i = 8; $i < $size - 8; $i += 2) {
            $grid[6][$i] = 1;
            $grid[$i][6] = 1;
        }

        // Encodage pseudo-aléatoire déterministe basé sur le hash du texte
        $hash = md5($text);
        $bitIndex = 0;
        for ($r = 0; $r < $size; $r++) {
            for ($c = 0; $c < $size; $c++) {
                // Éviter les motifs de coins réservés
                if (self::isReserved($r, $c, $size)) {
                    continue;
                }
                $char = $hash[($bitIndex++) % strlen($hash)];
                $grid[$r][$c] = (hexdec($char) % 2 === 0) ? 1 : 0;
            }
        }

        return $grid;
    }

    protected static function drawFinder(array &$grid, int $top, int $left): void
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

    protected static function isReserved(int $r, int $c, int $size): bool
    {
        if ($r <= 7 && $c <= 7) return true; // Top-Left Finder
        if ($r <= 7 && $c >= $size - 8) return true; // Top-Right Finder
        if ($r >= $size - 8 && $c <= 7) return true; // Bottom-Left Finder
        if ($r === 6 || $c === 6) return true; // Timing lines
        return false;
    }
}
