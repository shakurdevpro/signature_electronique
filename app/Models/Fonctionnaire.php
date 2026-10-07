<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonctionnaire extends Model
{
    use HasFactory;

    protected $connection = 'mssql_biometrie';
    protected $table = 'FONCTIONNAIRE';
    protected $primaryKey = 'FON_Matricule';
    public $incrementing = false; // matricule non auto-incrémenté
    protected $keyType = 'string';
    public $timestamps = false;

    
    protected $fillable = [
    'FON_Matricule',
    'STAT_Code',
    'FON_SIGFAENom',
    'FON_SIGFAEPrenoms',
    'FON_SIGFAENomEpouse',
    'FON_SIGFAENomJeuneFille',
    'FON_SIGFAEDatNais',
    'FON_SIGFAELieuNais',
    'FON_SIGFAESexe',
    'FON_SIGFAESexeLibel',
    'FON_SIGFAECivilite',
    'FON_SIGFAECiviliteLibel',
    'FON_SIGFAESituaMatrimo',
    'FON_SIGFAESituaMatrimoLibel',
    'FON_SIGFAEPerNom',
    'FON_SIGFAEPerPrenoms',
    'FON_SIGFAEPere',
    'FON_SIGFAEMerNom',
    'FON_SIGFAEMerPrenoms',
    'FON_SIGFAEMere',
    'FON_SIGFAEPieceType',
    'FON_SIGFAEPieceNum',
    'FON_SIGFAEPieceDate',
    'FON_SIGFAEContact',
    'FON_SIGFAEFonction',
    'FON_SIGFAEEmploi',
    'FON_SIGFAEStructure',
    'FON_SIGFAEDirGenerale',
    'FON_SIGFAEDrCentrale',
    'FON_SIGFAETypeAgent',
    'FON_SIGFAELieuTravail',
    'FON_SIGFAEEmail',
    'FON_Nom',
    'FON_Prenoms',
    'FON_NomPrenoms',
    'FON_NomEpouse',
    'FON_DatNais',
    'FON_LieuNais',
    'FON_Sexe',
    'FON_Civilite',
    'FON_SituaMatrimo',
    'FON_PerNom',
    'FON_PerPrenoms',
    'FON_MerNom',
    'FON_MerPrenoms',
    'FON_PieceType',
    'FON_PieceNum',
    'FON_PieceDate',
    'FON_PieceLieu',
    'FON_NNI',
    'FON_Contact',
    'FON_Fonction',
    'FON_Emploi',
    'FON_Structure',
    'FON_DirGenerale',
    'FON_DirCentrale',
    'FON_TypeAgent',
    'FON_LieuTravail',
    'FON_LocTravail',
    'FON_LocTravailCode',
    'FON_Email',
    'FON_DatSaisie',
    'FON_LocSaisie',
    'FON_LocSaisieCode',
    'FON_OperaMatricule',
    'FON_OperaIdentite',
    'FON_DatTransfert',
    'FON_CodeValise',
    'FON_SITCode',
    'FON_SECCode',
    'FON_LRCode',
    'FON_LRLibel',
    'FON_OperationAbisDate',
    'FON_OperationAbisType',
];

    // Relation vers STATUT_DOSSIER
    public function statut()
    {
        return $this->belongsTo(StatutDossier::class, 'STAT_Code', 'STAT_Code');
    }
}
