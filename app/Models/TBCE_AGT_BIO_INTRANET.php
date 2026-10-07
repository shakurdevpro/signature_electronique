<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TBCE_AGT_BIO_INTRANET extends Model
{

   protected $connection = 'connexion_oracl';   

    protected $table = 'UT_MFPE.TBCE_AGT_BIO';

    protected $primaryKey = 'ce_agt_mat';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ce_agt_mat',
        'ce_agt_etat_recensement',
        'ce_agt_date_recensement'
    ];
}