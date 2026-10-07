<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Sceau d'Authenticité Officiel MFPMA — République de Côte d'Ivoire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .mono { font-family: 'JetBrains Mono', monospace; }
        .bg-ci-pattern {
            background-color: #F6F9F7;
            background-image: 
                radial-gradient(at 0% 0%, rgba(255, 130, 0, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(0, 154, 68, 0.08) 0px, transparent 50%);
        }
        /* Motif de fond "Mur de Star" avec le logo réitéré plusieurs fois */
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
    </style>
</head>

<body class="bg-ci-pattern min-h-screen text-slate-800 antialiased py-8 px-4 flex flex-col justify-between relative overflow-x-hidden">

    <!-- Bandeau Tricolore Ivoire -->
    <div class="fixed top-0 left-0 right-0 h-1.5 flex z-50">
        <div class="bg-[#FF8200] flex-1"></div>
        <div class="bg-white flex-1"></div>
        <div class="bg-[#009A44] flex-1"></div>
    </div>

    <!-- Motif de fond "Mur de Star" avec le Logo MFPMA répété -->
    <div class="star-wall-pattern"></div>

    <div class="max-w-xl mx-auto w-full pt-4 relative z-10">

        <!-- En-tête Institutionnel -->
        <header class="text-center mb-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-emerald-500/20 rounded-full shadow-sm text-xs font-bold text-emerald-800 uppercase tracking-widest mb-3">
                <span class="inline-block w-2 h-2 rounded-full bg-[#009A44] animate-pulse"></span>
                République de Côte d'Ivoire
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-md border border-slate-200/80 flex items-center gap-4 text-left">
                <img src="{{ asset('images/logo_mfpma.png') }}" class="w-14 h-auto flex-shrink-0" alt="Logo Officiel MFPMA">
                <div>
                    <h1 class="text-base font-extrabold text-slate-900 leading-tight">Portail National de Vérification d'Actes</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Ministère de la Fonction Publique et de la Modernisation de l'Administration</p>
                </div>
            </div>
        </header>

        <!-- Carte de Vérification Sécurisée -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden relative">
            <div class="h-2 bg-gradient-to-r from-[#FF8200] via-slate-200 to-[#009A44]"></div>

            @if(($status ?? 'ok') === 'ok')
                <!-- ETAT AUTHENTIQUE -->
                <div class="p-6 text-center border-b border-slate-100 bg-gradient-to-b from-emerald-50/50 to-transparent">
                    <!-- Grand cercle avec icône document + petit badge coche vert en bas à droite -->
                    <div class="w-24 h-24 mx-auto mb-3 rounded-full bg-emerald-100/80 text-[#009A44] flex items-center justify-center text-4xl shadow-inner relative border-4 border-white shadow-emerald-500/10">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-[#009A44] text-white text-sm flex items-center justify-center shadow-lg border-2 border-white">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-100 text-[#009A44] border border-emerald-300">
                        Document Officiel Authentifié
                    </span>
                    <h2 class="text-xl font-extrabold text-slate-900 mt-2">Certificat de Conformation Conforme</h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Contrôle de sécurité exécuté avec succès le <span class="mono font-bold text-slate-700">{{ $dateVerification ?? date('d/m/Y H:i') }}</span>
                    </p>
                </div>

                @php
                    $isPretBancaire = ($isPretBancaire ?? false) 
                        || (isset($prefix) && $prefix === 'PRET_BANCAIRE') 
                        || (isset($detailsActe['PREFIXE']) && $detailsActe['PREFIXE'] === 'PRET_BANCAIRE') 
                        || (isset($typeActe) && str_contains(strtolower($typeActe), 'prêt'));
                @endphp

                @if($isPretBancaire)
                    <!-- GRILLE SPÉCIFIQUE POUR PRET_BANCAIRE -->
                    <div class="p-6 space-y-4">
                        <!-- 1. TITRE -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                <i class="fa-solid fa-[#009A44] fa-file-contract mr-1"></i> Titre du Document
                            </span>
                            <div class="text-base font-bold text-[#007A34]">
                                {{ $detailsActe['TITRE'] ?? ($detailsActe['NATURE_ACTE_LIB'] ?? ($typeActe ?? "Attestation de Prêt Bancaire")) }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- 2. CE_AGT_MAT (Matricule) -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-id-card text-[#009A44] mr-1"></i> Matricule
                                </span>
                                <div class="text-sm font-bold mono text-slate-900">
                                    {{ $detailsActe['CE_AGT_MAT'] ?? ($detailsActe['MATRICULE'] ?? '-') }}
                                </div>
                            </div>

                            <!-- 3. CIVILITE & NOM_PREN -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-user text-[#009A44] mr-1"></i> Concerné(e)
                                </span>
                                <div class="text-xs font-bold text-slate-900">
                                    @php
                                        $civCode = $detailsActe['CIVILITE_CODE'] ?? null;
                                        $civilite = match((string)$civCode) {
                                            '1' => 'Monsieur',
                                            '2' => 'Madame',
                                            '3' => 'Mademoiselle',
                                            default => ($detailsActe['CIVILITE'] ?? '')
                                        };
                                    @endphp
                                    {{ trim($civilite . ' ' . ($detailsActe['NOM_PREN'] ?? ($detailsActe['NOM_PRENOM'] ?? '-'))) }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- 4. DATENAISS -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-cake-candles text-[#009A44] mr-1"></i> Date Naissance
                                </span>
                                <div class="text-xs font-bold text-slate-900">
                                    {{ $detailsActe['DATENAISS'] ?? ($detailsActe['DATE_NAISSANCE'] ?? '-') }}
                                </div>
                            </div>

                            <!-- 5. EMPLOI_LIB -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-briefcase text-[#009A44] mr-1"></i> Emploi
                                </span>
                                <div class="text-xs font-bold text-slate-900">
                                    {{ $detailsActe['EMPLOI_LIB'] ?? ($detailsActe['EMPLOI'] ?? '-') }}
                                </div>
                            </div>
                        </div>

                        <!-- 6. NOM_PRENOM_GEST -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                <i class="fa-solid fa-user-tie text-[#009A44] mr-1"></i> Gestionnaire du Dossier
                            </span>
                            <div class="text-xs font-bold text-slate-800">
                                {{ $detailsActe['NOM_PRENOM_GEST'] ?? ($detailsActe['GESTIONNAIRE'] ?? '-') }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- 7. CE_AGT_RADIATION -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-calendar-xmark text-[#009A44] mr-1"></i> Date Retraite
                                </span>
                                <div class="text-xs font-bold mono text-slate-900">
                                    {{ $detailsActe['CE_AGT_RADIATION'] ?? ($detailsActe['DATE_RETRAITE'] ?? '-') }}
                                </div>
                            </div>

                            <!-- 8. CE_AGT_ANCIENNETE -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-hourglass-half text-[#009A44] mr-1"></i> Ancienneté
                                </span>
                                <div class="text-xs font-bold mono text-slate-900">
                                    {{ $detailsActe['CE_AGT_ANCIENNETE'] ?? ($detailsActe['ANCIENNETE'] ?? '-') }}
                                </div>
                            </div>
                        </div>

                        <!-- 9. GL_ACTE_DATESIGN -->
                        <div class="bg-emerald-50/60 border border-emerald-200 rounded-2xl p-4">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-[#007A34] block mb-1">
                                <i class="fa-solid fa-[#007A34] fa-pen-nib mr-1"></i> Date Signature Officielle
                            </span>
                            <div class="text-sm font-bold mono text-[#007A34]">
                                {{ $detailsActe['GL_ACTE_DATESIGN'] ?? ($detailsActe['DATE_SIGNATURE'] ?? ($dateSignature ?? date('d/m/Y'))) }}
                            </div>
                        </div>
                    </div>

                @else
                    <!-- GRILLE GENERALE (AUTRES ACTES) -->
                    <div class="p-6 space-y-4">
                        <!-- 1. Nature de l'acte -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                <i class="fa-solid fa-file-contract text-[#009A44] mr-1"></i> Nature de l'Acte Officiel
                            </span>
                            <div class="text-base font-bold text-[#007A34]">
                                {{ $detailsActe['NATURE_ACTE_LIB'] ?? ($typeActe ?? "Mise en formation") }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- 2. Numéro d'acte -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-hashtag text-[#009A44] mr-1"></i> Numéro d'Acte
                                </span>
                                <div class="text-sm font-bold mono text-slate-900">
                                    {{ $detailsActe['NUMERO_ACTE'] ?? ($numeroActe ?? "0782342579") }}
                                </div>
                            </div>

                            <!-- 3. Date Signature -->
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-calendar-check text-[#009A44] mr-1"></i> Date Signature
                                </span>
                                <div class="text-sm font-bold text-slate-900">
                                    {{ $detailsActe['DATE_SIGNATURE'] ?? ($dateSignature ?? date('d/m/Y')) }}
                                </div>
                            </div>
                        </div>

                        @if(!empty($detailsActe['TYPECONC_LIB']) || !empty($detailsActe['CONC_LIB']))
                        <div class="grid grid-cols-2 gap-3">
                            @if(!empty($detailsActe['TYPECONC_LIB']))
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-layer-group text-[#009A44] mr-1"></i> Type Concours
                                </span>
                                <div class="text-xs font-semibold text-slate-800">
                                    {{ $detailsActe['TYPECONC_LIB'] }}
                                </div>
                            </div>
                            @endif

                            @if(!empty($detailsActe['CONC_LIB']))
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-award text-[#009A44] mr-1"></i> Concours
                                </span>
                                <div class="text-xs font-semibold text-slate-800">
                                    {{ $detailsActe['CONC_LIB'] }}
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        @if(!empty($detailsActe['ANNEE']) || isset($detailsActe['NBR_DOSSIER']))
                        <div class="grid grid-cols-2 gap-3">
                            @if(!empty($detailsActe['ANNEE']))
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-calendar text-[#009A44] mr-1"></i> Année
                                </span>
                                <div class="text-sm font-bold mono text-slate-900">
                                    {{ $detailsActe['ANNEE'] }}
                                </div>
                            </div>
                            @endif

                            @if(isset($detailsActe['NBR_DOSSIER']))
                            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                    <i class="fa-solid fa-folder-open text-[#009A44] mr-1"></i> Nbr Dossiers
                                </span>
                                <div class="text-sm font-bold mono text-[#007A34]">
                                    {{ $detailsActe['NBR_DOSSIER'] }}
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Fichier Source -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">
                                <i class="fa-solid fa-file-pdf text-[#009A44] mr-1"></i> Document PDF d'origine
                            </span>
                            <div class="text-xs font-bold mono text-slate-700 truncate">
                                {{ $detailsActe['NOM_FICHIER'] ?? ($nomOriginal ?? "PRET_BANCAIRE_0972240991.PDF") }}
                            </div>
                        </div>

                        <!-- Signataire -->
                        <div class="bg-emerald-50/60 border border-emerald-200 rounded-2xl p-4">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-[#007A34] block mb-1">
                                <i class="fa-solid fa-pen-nib mr-1"></i> Organisme Émetteur / Signataire
                            </span>
                            <div class="text-xs font-bold text-slate-800">
                                MINISTÈRE DE LA FONCTION PUBLIQUE ET DE LA MODERNISATION DE L'ADMINISTRATION
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action PDF -->
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    <a href="{{ $downloadUrl ?? '#' }}" target="_blank"
                       class="w-full py-3.5 px-4 bg-gradient-to-r from-[#FF8200] to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-orange-500/25 flex items-center justify-center gap-2 transition-all">
                        <i class="fa-solid fa-file-arrow-down text-lg"></i>
                        <span>Télécharger le Document PDF Certifié</span>
                    </a>
                </div>
            @else
                <!-- ETAT NON RECONNU -->
                <div class="p-8 text-center space-y-4">
                    <div class="w-24 h-24 mx-auto rounded-full bg-red-100 text-red-600 flex items-center justify-center text-4xl shadow-inner relative border-4 border-white">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                        <span class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-red-600 text-white text-sm flex items-center justify-center shadow-lg border-2 border-white">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-red-100 text-red-700 border border-red-200">
                        Sceau Non Reconnu
                    </span>
                    <h2 class="text-xl font-extrabold text-slate-900">Acte Introuvable</h2>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Le code QR scanné ne correspond à aucun acte répertorié au registre officiel de la Fonction Publique de Côte d'Ivoire.
                    </p>
                </div>
            @endif
        </div>

        <!-- Pied de page -->
        <footer class="text-center mt-6 space-y-2">
            <div class="text-[11px] font-extrabold tracking-widest text-[#E06B00] uppercase">
                Union — Discipline — Travail
            </div>
            <p class="text-[11px] text-slate-400">
                © {{ date('Y') }} Ministère de la Fonction Publique et de la Modernisation de l'Administration
            </p>
        </footer>

    </div>

</body>
</html>
