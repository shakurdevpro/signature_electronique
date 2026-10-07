<?php

namespace App\Services;

use RuntimeException;

class PdfQrService
{
    /**
     * Charge de manière isolée chillerlan/php-qrcode, Endroid, BaconQrCode et Dasprid sans modifier vendor/composer/.
     */
    protected function ensureEndroidLoaded(): void
    {
        if (class_exists(\chillerlan\QRCode\QRCode::class) || class_exists(\Endroid\QrCode\QrCode::class)) {
            return;
        }

        spl_autoload_register(static function ($class) {
            $prefixes = [
                'chillerlan\\QRCode\\' => base_path('vendor/chillerlan/php-qrcode/src/'),
                'chillerlan\\Settings\\' => base_path('vendor/chillerlan/php-settings-container/src/'),
                'Endroid\\QrCode\\' => base_path('vendor/endroid/qr-code/src/'),
                'BaconQrCode\\' => base_path('vendor/bacon/bacon-qr-code/src/'),
                'DASPRID\\Enum\\' => base_path('vendor/dasprid/enum/src/'),
            ];

            foreach ($prefixes as $prefix => $baseDir) {
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    continue;
                }

                $relativeClass = substr($class, $len);
                $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }

    /**
     * S'assure que les classes FPDF et FPDI sont chargées.
     */
    protected function ensureFpdiLoaded(): void
    {
        if (class_exists(\setasign\Fpdi\Fpdi::class)) {
            return;
        }

        $fpdfPath = base_path('vendor/setasign/fpdf/fpdf.php');
        if (file_exists($fpdfPath)) {
            require_once $fpdfPath;
        }

        $fpdiAutoload = base_path('vendor/setasign/fpdi/src/autoload.php');
        if (file_exists($fpdiAutoload)) {
            require_once $fpdiAutoload;
        }

        if (!class_exists(\setasign\Fpdi\Fpdi::class)) {
            throw new RuntimeException("Le dossier 'vendor/setasign' est manquant sur votre serveur FTP. Veuillez copier le dossier 'vendor/setasign' sur votre FTP.");
        }
    }

    /**
     * Résout et garantit l'existence du chemin d'accès absolu au fichier PDF.
     *
     * @param string|null $filePath
     * @return string
     */
    public function resolveFilePath(?string $filePath): string
    {
        if (empty($filePath)) {
            $filePath = storage_path('DOCTEMP.PDF');
        }

        if (file_exists($filePath)) {
            return realpath($filePath);
        }

        $basename = basename($filePath);

        // Recherche dans public/DOSSIER_SAVE/A_SIGNER_TEST
        $inPublicSave = public_path('DOSSIER_SAVE/A_SIGNER_TEST/' . $basename);
        if (file_exists($inPublicSave)) {
            return realpath($inPublicSave);
        }

        $inStorage = storage_path($basename);
        if (file_exists($inStorage)) {
            return realpath($inStorage);
        }

        $inStorageApp = storage_path('app/' . $basename);
        if (file_exists($inStorageApp)) {
            return realpath($inStorageApp);
        }

        $inBase = base_path($filePath);
        if (file_exists($inBase)) {
            return realpath($inBase);
        }

        // Si le fichier DOCTEMP.PDF est manquant, on le crée automatiquement pour le test
        $defaultPath = storage_path('DOCTEMP.PDF');
        if (!file_exists($defaultPath)) {
            $directory = dirname($defaultPath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            $this->ensureFpdiLoaded();
            $pdf = new \FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 14);
            $pdf->Text(30, 50, 'DOCUMENT DE TEST POUR SIGNATURE ELECTRONIQUE');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Text(120, 200, 'Emplacement du QR Code : #');
            $pdf->Output('F', $defaultPath);
        }

        return realpath($defaultPath) ?: $defaultPath;
    }

    /**
     * Extrait les coordonnées (X, Y) du repère '#' dans le document PDF spécifié.
     *
     * @param string|null $filePath
     * @return array{X: float, Y: float}
     * @throws RuntimeException
     */
    public function positionxy_QR(?string $filePath = null): array
    {
        $resolvedFilePath = $this->resolveFilePath($filePath);

        if (!file_exists($resolvedFilePath)) {
            throw new RuntimeException("Le fichier PDF est introuvable à l'emplacement : {$resolvedFilePath}");
        }

        $jarPath = base_path('java/getXY_QR.jar');

        if (!file_exists($jarPath)) {
            throw new RuntimeException("Le fichier JAR est introuvable à l'emplacement : {$jarPath}");
        }

        $javaBinary = $this->getJavaBinary();

        $cmd = sprintf('"%s" -jar "%s" "%s" 2>&1', $javaBinary, $jarPath, $resolvedFilePath);

        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        $filteredOutput = array_filter($output, function ($line) {
            return trim($line) !== '' && str_contains($line, '_');
        });

        if (empty($filteredOutput)) {
            $rawOutput = trim(implode("\n", $output));
            throw new RuntimeException("Échec de la récupération des coordonnées du repère '#' sur le PDF. Sortie Java : {$rawOutput}");
        }

        $firstLine = trim(reset($filteredOutput));
        $coords = explode('_', $firstLine);

        if (count($coords) < 2) {
            throw new RuntimeException("Format de coordonnées invalide reçu : {$firstLine}");
        }

        return [
            'X' => (float) $coords[0],
            'Y' => (float) $coords[1],
        ];
    }

    /**
     * Génère une image PNG de QR Code (Compatible PHP 7.4 / 8.0 / 8.1 / 8.2 / 8.3 sans erreur readonly).
     */
    public function generateQrCodeImage(string $text, ?string $outputPath = null): string
    {
        $outputPath = $outputPath ?? storage_path('app/temp_qr_' . uniqid() . '.png');

        $directory = dirname($outputPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $this->ensureEndroidLoaded();

        // 1. Essai avec chillerlan\QRCode (100% compatible PHP 7.4 / 8.0 sans mot-clé readonly)
        if (class_exists(\chillerlan\QRCode\QRCode::class)) {
            try {
                $options = new \chillerlan\QRCode\QROptions([
                    'version' => 5,
                    'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
                    'eccLevel' => \chillerlan\QRCode\QRCode::ECC_L,
                    'scale' => 6,
                ]);
                $qrcode = new \chillerlan\QRCode\QRCode($options);
                $qrcode->render($text, $outputPath);
                return $outputPath;
            } catch (\Throwable $e) {
                // Continuer
            }
        }

        // 2. Essai avec Endroid\QrCode (si PHP >= 8.1)
        try {
            if (class_exists(\Endroid\QrCode\QrCode::class)) {
                $qrCode = new \Endroid\QrCode\QrCode($text);
                $writer = new \Endroid\QrCode\Writer\PngWriter();
                $result = $writer->write($qrCode);
                $result->saveToFile($outputPath);
                return $outputPath;
            }
        } catch (\Throwable $e) {
            // Continuer
        }

        // 3. Génération via API QuickChart
        $qrApiUrl = 'https://quickchart.io/qr?text=' . urlencode($text) . '&size=300&margin=2';
        $imageData = @file_get_contents($qrApiUrl);

        if ($imageData !== false && strlen($imageData) > 200) {
            file_put_contents($outputPath, $imageData);
            return $outputPath;
        }

        // 4. Secours local PHP 7.4 / 8.0
        if (PHP7QrEncoder::generatePng($text, $outputPath)) {
            return $outputPath;
        }

        throw new RuntimeException("Impossible de générer l'image du QR Code.");
    }

    /**
     * Insère un QR Code sur le PDF à l'emplacement du repère '#'
     * et ré-enregistre le document dans le même dossier avec le même nom.
     * Si aucun $qrText n'est transmis, le nom du fichier PDF est utilisé par défaut.
     *
     * @param string|null $filePath Chemin du document
     * @param string|null $qrText Texte contenu dans le QR Code (si null: utilise le nom du fichier PDF)
     * @param float $qrWidth Largeur du QR code en mm (défaut: 25)
     * @param float $qrHeight Hauteur du QR code en mm (défaut: 25)
     * @return string Chemin du fichier PDF mis à jour
     */
    public function ajouterQrSurPdf(
        ?string $filePath = null,
        ?string $qrText = null,
        float $qrWidth = 40.0,
        float $qrHeight = 40.0
    ): string {
        $this->ensureFpdiLoaded();

        $targetFilePath = $this->resolveFilePath($filePath);

        // Si aucun texte n'est spécifié, utiliser le nom du fichier (ex: MISE_EN_FORMATION_0782342570.PDF)
        if (empty($qrText)) {
            $qrText = basename($targetFilePath);
        }

        // 1. Récupération des coordonnées X, Y de #
        $coordonnee_QR = $this->positionxy_QR($targetFilePath);

        $x_QR = $coordonnee_QR["X"]-55;
        $y_QR = $coordonnee_QR["Y"]-55;

        // 2. Génération de l'image QR Code avec le nom du document
        $tempQrImagePath = $this->generateQrCodeImage($qrText);

        // 3. Superposition du QR Code avec FPDI
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile($targetFilePath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
            $pdf->AddPage($orientation, [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            if ($pageNo === 1) {
                // Conversion des points PDF en mm pour FPDI (1 pt = 0.352777778 mm)
                $xInMm = $x_QR * 0.352777778;
                $yInMm = $y_QR * 0.352777778;

                // 3a. Effacement / Masquage du symbole '#' ou de l'ancien QR code avec un rectangle blanc opaque
                $pdf->SetFillColor(255, 255, 255);
                $pdf->Rect($xInMm - 0.5, $yInMm - 0.5, $qrWidth + 1, $qrHeight + 1, 'F');

                // 3b. Dessin du nouveau QR Code par-dessus
                $pdf->Image($tempQrImagePath, $xInMm, $yInMm, $qrWidth, $qrHeight);
            }
        }

        // 4. Sauvegarde puis remplacement du fichier d'origine
        $tempPdfPath = storage_path('app/temp_doc_' . uniqid() . '.pdf');
        $pdf->Output('F', $tempPdfPath);

        if (file_exists($tempQrImagePath)) {
            @unlink($tempQrImagePath);
        }

        rename($tempPdfPath, $targetFilePath);

        return $targetFilePath;
    }

    /**
     * Récupère la liste de tous les fichiers PDF dans le dossier spécifié.
     *
     * @param string|null $dirPath
     * @return array
     */
    public function getDocumentsList(?string $dirPath = null): array
    {
        $targetDir = $dirPath ?? public_path('DOSSIER_SAVE/A_SIGNER_TEST');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $files = glob($targetDir . '/*.PDF');
        $files = array_merge($files, glob($targetDir . '/*.pdf'));
        $files = array_unique($files);

        $list = [];
        foreach ($files as $file) {
            $filename = basename($file);
            $size = filesize($file);
            $mtime = filemtime($file);

            $list[] = [
                'filename' => $filename,
                'path' => $file,
                'size_bytes' => $size,
                'size_formatted' => $this->formatBytes($size),
                'mtime' => $mtime,
                'mtime_formatted' => date('d/m/Y H:i:s', $mtime),
                'public_url' => asset('DOSSIER_SAVE/A_SIGNER_TEST/' . $filename),
            ];
        }

        usort($list, fn($a, $b) => strcmp($a['filename'], $b['filename']));

        return $list;
    }

    /**
     * Formate le nombre d'octets en unité lisible
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['o', 'Ko', 'Mo', 'Go'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Recherche du binaire Java exécutable (Priorité à /opt/java/jdk17/bin/java sous Linux)
     */
    protected function getJavaBinary(): string
    {
        $customJava = env('JAVA_BINARY_PATH');
        if ($customJava && file_exists($customJava)) {
            return $customJava;
        }

        $commonPaths = [
            'C:\Program Files\Eclipse Adoptium\jdk-17.0.20.101-hotspot\bin\java.exe', // Windows Local
            'C:\Program Files\Java\jdk-17\bin\java.exe',
            '/opt/java/jdk17/bin/java', // Serveur FTP Linux
            '/usr/bin/java',
            '/usr/local/bin/java',
            '/bin/java',
        ];

        foreach ($commonPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return (DIRECTORY_SEPARATOR === '/') ? '/opt/java/jdk17/bin/java' : 'java';
    }
}
