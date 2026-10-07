<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VW_FONCT_NON_RECENCE_SPEC_INTRANET extends Model
{
     protected $connection = 'connexion_oracl';
    protected $table = 'UT_MFPE.VW_FONCT_NON_RECENCE_SPEC';
    

    protected $primaryKey = 'MATRICULE';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'sigfae_matricule',
        'NOM',
        'PRENOMS',
        'NOM_JEUNE_FILLEE',
        'DATE_NAISSANCE',
        'LIEU_NAISSANCE',
        'PA_SEXE_CODE',
        'SEXE',
        'PA_CIVILITE_CODE',
        'CIVILITE',
        'PA_SITFAM_CODE',
        'SITUATION_FAMILIALE',
        'NOM_PERE',
        'NOM_MERE',
        'CNI',
        'EMAIL',
        'STRUCTURE',
        'TELEPHONE',
        'CELLULAIRE',
        'DIRECTION_GENERALE',
        'DIRECTION_CENTRALE',
        'EMPLOI',
        'OPTION_EMPLOI',
        'FONCTION',
        'TYPE_AGENT',
        'LIEU_TRAVAIL'
    ];
}