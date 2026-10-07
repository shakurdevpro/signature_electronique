<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Portail de Vérification d'Authenticité des Actes du MFPMA — République de Côte d'Ivoire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Couleurs nationales officielles de la Côte d'Ivoire */
            --ci-orange: #FF8200;
            --ci-orange-dark: #E06B00;
            --ci-orange-light: #FFF4E8;
            --ci-green: #009A44;
            --ci-green-dark: #007A34;
            --ci-green-light: #EBF7EE;
            --ci-white: #FFFFFF;

            /* Couleurs d'interface */
            --bg-base: #F8FAF9;
            --surface: #FFFFFF;
            --surface-subtle: #F2F5F3;
            --text-main: #141B17;
            --text-muted: #526359;
            --text-subtle: #7F9387;
            --border-light: rgba(0, 154, 68, 0.12);
            --border-strong: rgba(20, 27, 23, 0.1);

            /* Statuts */
            --status-ok: #009A44;
            --status-warn: #FF8200;
            --status-bad: #D32F2F;

            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 28px;

            --shadow-subtle: 0 4px 20px rgba(0, 50, 20, 0.04);
            --shadow-card: 0 16px 40px -10px rgba(0, 60, 25, 0.08), 0 2px 10px rgba(255, 130, 0, 0.04);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-base);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            padding: 32px 18px 60px;
            position: relative;
            overflow-x: hidden;
        }

        /* Motif de fond "Mur de Star" avec le logo MFPMA */
        .star-wall-pattern {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: url("{{ asset('images/logo_mfpma.png') }}");
            background-repeat: repeat;
            background-size: 190px auto;
            background-position: center top;
            opacity: 0.035;
            filter: grayscale(20%);
        }

        .bg-pattern {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(circle at 10% 0%, rgba(255, 130, 0, 0.08), transparent 42%),
                radial-gradient(circle at 90% 100%, rgba(0, 154, 68, 0.06), transparent 48%);
        }

        .flag-strip {
            height: 6px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            z-index: 10;
        }

        .flag-strip .orange { flex: 1; background: var(--ci-orange); }
        .flag-strip .white { flex: 1; background: var(--ci-white); }
        .flag-strip .green { flex: 1; background: var(--ci-green); }

        .wrap {
            position: relative;
            z-index: 1;
            max-width: 650px;
            margin: 0 auto;
        }

        /* En-tête officiel */
        header {
            text-align: center;
            margin-bottom: 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .republic-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface);
            border: 1px solid var(--border-light);
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 14px;
            box-shadow: 0 2px 8px rgba(0, 154, 68, 0.06);
        }

        .mini-flag {
            display: flex;
            width: 20px;
            height: 14px;
            border-radius: 2px;
            overflow: hidden;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.3);
        }

        .mini-flag span { flex: 1; height: 100%; }
        .mini-flag .c-or { background: #FF8200; }
        .mini-flag .c-wh { background: #FFFFFF; }
        .mini-flag .c-gr { background: #009A44; }

        .republic-badge span.text {
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--ci-green-dark);
        }

        .header-title-box {
            display: flex;
            align-items: center;
            gap: 14px;
            text-align: left;
            background: var(--surface);
            padding: 14px 20px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-subtle);
            width: 100%;
        }

        .official-seal-img {
            width: 58px;
            height: auto;
            flex: none;
            object-fit: contain;
        }

        .header-texts h1 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.01em;
            line-height: 1.3;
        }

        .header-texts p {
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 2px;
        }

        /* Carte Principale */
        .card {
            background: var(--surface);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(0, 154, 68, 0.15);
            overflow: hidden;
            position: relative;
        }

        .card-top-tricolor {
            height: 5px;
            display: flex;
            width: 100%;
        }

        .card-top-tricolor .part-or { background: #FF8200; flex: 1; }
        .card-top-tricolor .part-wh { background: #FFFFFF; flex: 1; border-bottom: 1px solid #ECECEC; }
        .card-top-tricolor .part-gr { background: #009A44; flex: 1; }

        .status-zone {
            padding: 36px 30px 24px;
            text-align: center;
            position: relative;
        }

        /* Grand cercle avec icône de document + badge coche vert */
        .seal-ring {
            width: 90px;
            height: 90px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: var(--ci-green-light);
            color: var(--ci-green);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 0 0 8px rgba(0, 154, 68, 0.08);
            transition: all 0.3s ease;
        }

        .seal-ring.status-bad {
            background: #FDF2F2;
            color: var(--status-bad);
            box-shadow: 0 0 0 8px rgba(211, 47, 47, 0.08);
        }

        .seal-ring .doc-icon {
            width: 44px;
            height: 44px;
        }

        .seal-ring .badge-check {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--ci-green);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(0, 154, 68, 0.35);
            border: 2px solid #FFFFFF;
        }

        .seal-ring.status-bad .badge-check {
            background: var(--status-bad);
            box-shadow: 0 3px 8px rgba(211, 47, 47, 0.35);
        }

        .seal-ring .badge-check svg {
            width: 16px;
            height: 16px;
        }

        .status-title {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .status-ok .status-title { color: var(--ci-green-dark); }
        .status-bad .status-title { color: var(--status-bad); }

        .status-sub {
            font-size: 13.5px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .status-sub .mono {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            color: var(--text-main);
            background: var(--surface-subtle);
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12.5px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(0, 154, 68, 0.15) 30%,
                    rgba(255, 130, 0, 0.2) 70%,
                    transparent 100%);
            margin: 4px 30px 10px;
        }

        /* Grille des informations d'acte */
        .fields-grid {
            padding: 22px 30px 10px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 20px;
        }

        .field-card {
            background: var(--surface-subtle);
            border: 1px solid var(--border-light);
            padding: 13px 15px;
            border-radius: var(--radius-md);
            position: relative;
        }

        .field-card.span-2 { grid-column: 1 / -1; }

        .field-card.highlight {
            background: linear-gradient(135deg, rgba(255, 244, 232, 0.6) 0%, rgba(235, 247, 238, 0.6) 100%);
            border-color: rgba(255, 130, 0, 0.25);
        }

        .field-card .lbl {
            font-size: 10.5px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-subtle);
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .field-card .lbl svg { width: 13px; height: 13px; color: var(--ci-green); }

        .field-card .val {
            font-size: 14.5px;
            font-weight: 600;
            color: var(--text-main);
            word-break: break-word;
            line-height: 1.4;
        }

        .field-card .val.mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13.5px;
            color: var(--ci-green-dark);
            font-weight: 600;
        }

        /* Bannière de Sécurité / Sceau d'Intégrité Numérique */
        .verification-banner {
            margin: 14px 30px 24px;
            padding: 14px 16px;
            background: linear-gradient(135deg, var(--ci-green-light) 0%, #FFFFFF 100%);
            border: 1px solid rgba(0, 154, 68, 0.25);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .banner-icon {
            width: 38px;
            height: 38px;
            flex: none;
            border-radius: 10px;
            background: var(--ci-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 154, 68, 0.25);
        }

        .banner-icon svg {
            width: 20px;
            height: 20px;
        }

        .banner-text {
            font-size: 12.5px;
            line-height: 1.5;
            color: var(--text-muted);
        }

        .banner-text strong {
            color: var(--ci-green-dark);
            font-weight: 700;
        }

        .alert-box {
            padding: 24px 30px 32px;
            text-align: center;
        }

        .alert-box p {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 440px;
            margin: 10px auto 0;
            background: var(--surface-subtle);
            padding: 16px 20px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-strong);
        }

        .action-actions {
            padding: 0 30px 30px;
            display: flex;
            gap: 12px;
        }

        .btn-ci {
            flex: 1;
            padding: 13px 18px;
            border-radius: 12px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--ci-orange) 0%, var(--ci-orange-dark) 100%);
            color: #FFFFFF;
            box-shadow: 0 6px 16px rgba(255, 130, 0, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(255, 130, 0, 0.35);
        }

        footer {
            margin-top: 32px;
            text-align: center;
            padding: 0 16px;
        }

        .footer-emblem-line {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .footer-emblem-line .line {
            width: 40px;
            height: 1px;
            background: var(--border-strong);
        }

        .footer-devise {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--ci-orange-dark);
        }

        footer p {
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.65;
            max-width: 520px;
            margin: 0 auto;
        }

        footer strong { color: var(--text-main); }

        @media (max-width: 520px) {
            .fields-grid { grid-template-columns: 1fr; }
            .action-actions { flex-direction: column; }
            .header-title-box { flex-direction: column; text-align: center; align-items: center; }
        }
    </style>
</head>

<body>

    <div class="flag-strip">
        <div class="orange"></div>
        <div class="white"></div>
        <div class="green"></div>
    </div>

    <div class="bg-pattern"></div>

    <!-- Motif de Fond "Mur de Star" avec le Logo MFPMA -->
    <div class="star-wall-pattern"></div>

    <div class="wrap">

        <header>
            <div class="republic-badge">
                <div class="mini-flag">
                    <span class="c-or"></span>
                    <span class="c-wh"></span>
                    <span class="c-gr"></span>
                </div>
                <span class="text">République de Côte d'Ivoire</span>
            </div>

            <div class="header-title-box">
                <img src="{{ asset('images/logo_mfpma.png') }}" class="official-seal-img" alt="Sceau Officiel MFPMA">
                <div class="header-texts">
                    <h1>Portail d'Authenticité des Actes</h1>
                    <p>Ministère de la Fonction Publique et de la Modernisation de l'Administration</p>
                </div>
            </div>
        </header>

        <!-- Carte Principale -->
        <div class="card">
            <div class="card-top-tricolor">
                <div class="part-or"></div>
                <div class="part-wh"></div>
                <div class="part-gr"></div>
            </div>

            @if($status === 'ok')
                <!-- ETAT 1: AUTHENTIQUE -->
                <div id="state-ok">
                    <div class="status-zone status-ok">
                        <!-- Cercle avec Icône Document Officiel + Badge Coche Vert -->
                        <div class="seal-ring">
                            <svg class="doc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <path d="M9 15l2 2 4-4" />
                            </svg>
                            <div class="badge-check">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>

                        <h2 class="status-title">Acte authentique et certifié</h2>
                        <p class="status-sub">Vérification effectuée avec succès le <span class="mono">{{ $dateVerification }}</span></p>
                    </div>

                    <div class="divider"></div>

                    @php
                        $getVal = function($val) {
                            if ($val === null || $val === 'NULL' || $val === 'null' || trim((string)$val) === '') {
                                return '-';
                            }
                            return trim((string)$val);
                        };

                        $isPretBancaire = ($isPretBancaire ?? false) 
                            || (isset($prefix) && $prefix === 'PRET_BANCAIRE') 
                            || (isset($detailsActe['PREFIXE']) && $detailsActe['PREFIXE'] === 'PRET_BANCAIRE') 
                            || (isset($typeActe) && str_contains(strtolower($typeActe), 'prêt'))
                            || (isset($detailsActe['TITRE']) && str_contains(strtolower($detailsActe['TITRE']), 'pret'));
                    @endphp

                    @if($isPretBancaire)
                        <!-- AFFICHAGE SPÉCIFIQUE POUR PRET_BANCAIRE -->
                        <div class="fields-grid">
                            <!-- 1. TITRE -->
                            <div class="field-card span-2 highlight">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    Titre du document
                                </div>
                                <div class="val" style="font-size: 16px; color: var(--ci-green-dark);">
                                    {{ $getVal($detailsActe['TITRE'] ?? ($detailsActe['NATURE_ACTE_LIB'] ?? ($typeActe ?? "Attestation de Prêt Bancaire"))) }}
                                </div>
                            </div>

                            <!-- 2. CE_AGT_MAT (Matricule) -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="16" rx="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    Matricule du concerné
                                </div>
                                <div class="val mono">{{ $getVal($detailsActe['CE_AGT_MAT'] ?? ($detailsActe['MATRICULE'] ?? null)) }}</div>
                            </div>

                            <!-- 3. CIVILITE & NOM_PREN -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Nom & Prénom(s) du concerné
                                </div>
                                <div class="val">
                                    @php
                                        $civCode = $detailsActe['CIVILITE_CODE'] ?? null;
                                        $civilite = match((string)$civCode) {
                                            '1' => 'Monsieur',
                                            '2' => 'Madame',
                                            '3' => 'Mademoiselle',
                                            default => ($detailsActe['CIVILITE'] ?? '')
                                        };
                                        $fullName = trim($civilite . ' ' . ($detailsActe['NOM_PREN'] ?? ($detailsActe['NOM_PRENOM'] ?? '')));
                                    @endphp
                                    {{ $getVal($fullName) }}
                                </div>
                            </div>

                            <!-- 4. DATENAISS (Date de naissance) -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    Date de Naissance
                                </div>
                                <div class="val">{{ $getVal($detailsActe['DATENAISS'] ?? ($detailsActe['DATE_NAISSANCE'] ?? null)) }}</div>
                            </div>

                            <!-- 5. EMPLOI_LIB (Emploi) -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    Emploi du concerné
                                </div>
                                <div class="val">{{ $getVal($detailsActe['EMPLOI_LIB'] ?? ($detailsActe['EMPLOI'] ?? null)) }}</div>
                            </div>

                            <!-- 6. NOM_PRENOM_GEST (Nom du gestionnaire) -->
                            <div class="field-card span-2">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    Nom du gestionnaire
                                </div>
                                <div class="val">{{ $getVal($detailsActe['NOM_PRENOM_GEST'] ?? ($detailsActe['GESTIONNAIRE'] ?? null)) }}</div>
                            </div>

                            <!-- 7. CE_AGT_RADIATION (Départ à la retraite) -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                    </svg>
                                    Date départ à la retraite
                                </div>
                                <div class="val mono">{{ $getVal($detailsActe['CE_AGT_RADIATION'] ?? ($detailsActe['DATE_RETRAITE'] ?? null)) }}</div>
                            </div>

                            <!-- 8. CE_AGT_ANCIENNETE (Ancienneté actuelle) -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    Ancienneté actuelle
                                </div>
                                <div class="val mono">{{ $getVal($detailsActe['CE_AGT_ANCIENNETE'] ?? ($detailsActe['ANCIENNETE'] ?? null)) }}</div>
                            </div>

                            <!-- 9. GL_ACTE_DATESIGN (Date de signature) -->
                            <div class="field-card span-2">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                    Date de Signature Officielle
                                </div>
                                <div class="val mono" style="color: var(--ci-green-dark);">
                                    {{ $getVal($detailsActe['GL_ACTE_DATESIGN'] ?? ($detailsActe['DATE_SIGNATURE'] ?? ($dateSignature ?? date('d/m/Y')))) }}
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- AFFICHAGE GENERAL (AUTRES ACTES) -->
                        <div class="fields-grid">
                            <!-- 1. NATURE_ACTE_LIB -->
                            <div class="field-card span-2 highlight">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    Nature de l'acte officiel
                                </div>
                                <div class="val" style="font-size: 16px; color: var(--ci-green-dark);">
                                    {{ $getVal($detailsActe['NATURE_ACTE_LIB'] ?? ($typeActe ?? "Document Officiel MFPMA")) }}
                                </div>
                            </div>

                            <!-- 2. NUMERO_ACTE -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="16" rx="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    Numéro d'Acte
                                </div>
                                <div class="val mono">{{ $getVal($detailsActe['NUMERO_ACTE'] ?? ($numeroActe ?? $nomOriginal)) }}</div>
                            </div>

                            <!-- 3. DATE_SIGNATURE -->
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    Date de signature
                                </div>
                                <div class="val">{{ $getVal($detailsActe['DATE_SIGNATURE'] ?? ($dateSignature ?? date('d/m/Y'))) }}</div>
                            </div>

                            <!-- 4. TYPECONC_LIB -->
                            @if(!empty($detailsActe['TYPECONC_LIB']))
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    Type de Concours
                                </div>
                                <div class="val">{{ $getVal($detailsActe['TYPECONC_LIB']) }}</div>
                            </div>
                            @endif

                            <!-- 5. CONC_LIB -->
                            @if(!empty($detailsActe['CONC_LIB']))
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                    </svg>
                                    Concours
                                </div>
                                <div class="val">{{ $getVal($detailsActe['CONC_LIB']) }}</div>
                            </div>
                            @endif

                            <!-- 6. ANNEE -->
                            @if(!empty($detailsActe['ANNEE']))
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                    </svg>
                                    Année
                                </div>
                                <div class="val mono">{{ $getVal($detailsActe['ANNEE']) }}</div>
                            </div>
                            @endif

                            <!-- 7. NBR_DOSSIER -->
                            @if(isset($detailsActe['NBR_DOSSIER']))
                            <div class="field-card">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    Nombre de dossiers
                                </div>
                                <div class="val mono" style="color: var(--ci-green-dark); font-weight: 700;">
                                    {{ $getVal($detailsActe['NBR_DOSSIER']) }}
                                </div>
                            </div>
                            @endif

                            <!-- 8. ACTE / NOM_FICHIER -->
                            <div class="field-card span-2">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                        <polyline points="13 2 13 9 20 9"></polyline>
                                    </svg>
                                    Fichier Acte
                                </div>
                                <div class="val mono" style="font-size: 13px;">
                                    {{ $getVal($detailsActe['NOM_FICHIER'] ?? ($detailsActe['ACTE'] ?? $nomOriginal)) }}
                                </div>
                            </div>

                            <!-- Signataires -->
                            <div class="field-card span-2">
                                <div class="lbl">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                    Signataire(s)
                                </div>
                                <div class="val" style="color: var(--ci-green-dark); padding-left: 15px;">
                                    <ul style="list-style-type: '- ';">
                                        <li>MINISTÈRE DE LA FONCTION PUBLIQUE ET DE LA MODERNISATION DE L'ADMINISTRATION</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Bannière de Sécurité / Sceau d'Intégrité Numérique -->
                    <div class="verification-banner">
                        <div class="banner-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <div class="banner-text">
                            <strong>Certificat d'Intégrité Numérique :</strong> Document original signé électroniquement, inviolable et conforme au registre de l'État de Côte d'Ivoire.
                        </div>
                    </div>

                    @if(!empty($downloadUrl))
                        <div class="action-actions">
                            <a class="btn-ci btn-primary" href="{{ $downloadUrl }}" target="_blank">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 6 2 18 2 18 9" />
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                    <rect x="6" y="14" width="12" height="8" />
                                </svg>
                                Consulter le document PDF
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <!-- ETAT: INTROUVABLE / NON RECONNU -->
                <div id="state-notfound">
                    <div class="status-zone status-bad">
                        <div class="seal-ring status-bad">
                            <svg class="doc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <line x1="9" y1="15" x2="15" y2="15" />
                            </svg>
                            <div class="badge-check">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="status-title">Acte non répertorié</h2>
                        <p class="status-sub">Aucune concordance dans le registre officiel</p>
                    </div>

                    <div class="alert-box">
                        <p>Le QR Code présenté ne figure pas dans le registre électronique des actes de la Fonction Publique de Côte d'Ivoire. Veuillez vérifier l'original ou vous rapprocher des services compétents.</p>
                    </div>
                </div>
            @endif

        </div>

        <!-- Pied de page officiel -->
        <footer>
            <div class="footer-emblem-line">
                <div class="line"></div>
                <div class="footer-devise">Union — Discipline — Travail</div>
                <div class="line"></div>
            </div>
            <p>
                <strong>Ministère de la Fonction Publique et de la Modernisation de l'Administration</strong><br>
                Plateforme conforme à la loi n° 2013-450 sur la protection des données personnelles en République de Côte d'Ivoire.
            </p>
        </footer>

    </div>

</body>
</html>
