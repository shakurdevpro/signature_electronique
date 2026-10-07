<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SIGFAE_TEMPON extends Model
{

    protected $connection = 'mssql_biometrie';
    protected $table = 'SIGFAE';

    protected $primaryKey = 'SIGFAE_Matricule';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'SIGFAE_Matricule',
        'SIGFAE_Nom',
        'SIGFAE_Prenoms',
        'SIGFAE_NomEpouse',
        'SIGFAE_NomJeuneFille',
        'SIGFAE_DatNais',
        'SIGFAE_LieuNais',
        'SIGFAE_Sexe',
        'SIGFAE_SexeLibel',
        'SIGFAE_Civilite',
        'SIFGAE_CiviiteLibel',
        'SIGFAE_SituaMatrimo',
        'SIGFAE_SituaMatrimoLibel',
        'SIGFAE_PerNom',
        'SIGFAE_PerPrenoms',
        'SIGFAE_Pere',
        'SIGFAE_MerNom',
        'SIGFAE_MerPrenoms',
        'SIGFAE_Mere',
        'SIGFAE_PieceType',
        'SIGFAE_PieceNum',
        'SIGFAE_PieceDate',
        'SIGFAE_Contact',
        'SIGFAE_Structure',
        'SIGFAE_DirGenerale',
        'SIGFAE_DirCentrale',
        'SIGFAE_TypeAgent',
        'SIGFAE_Fonction',
        'SIGFAE_Emploi',
        'SIGFAE_LieuTravail',
        'SIGFAE_Email',
        'SIGFAE_DatEnroll',
        'SIGFAE_DatInsert',
        'SIGFAE_Cabinet',
        'SIGFAE_SousDirection',
        'SIGFAE_Service'
    ];
}