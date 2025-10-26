<?php

namespace App\Http\Controllers;

use App\Models\Aksara;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AtlasController extends Controller
{
    public function show(Aksara $aksara)
    {
        $aksara->load('lessons');

        return Inertia::render('Atlas/Show', [
            'aksara' => $aksara,
            'lesson' => $aksara->lessons->first(),
        ]);
    }
}
