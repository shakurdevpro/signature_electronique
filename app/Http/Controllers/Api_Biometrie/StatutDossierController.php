<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StatutDossier;


class StatutDossierController extends Controller
{
    public function index()
    {
        return StatutDossier::with('fonctionnaires')->get();
    }

    
}
