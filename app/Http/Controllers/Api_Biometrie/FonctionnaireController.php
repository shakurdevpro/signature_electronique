<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fonctionnaire;


class FonctionnaireController extends Controller
{
    public function index()
    {
        return Fonctionnaire::with('statut')->get();
    }

    
}
