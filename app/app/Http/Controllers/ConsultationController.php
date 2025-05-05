<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsultationController extends Controller
{
    public function myConsultations(Request $request)
    {
        return Inertia::render('patient/Consultation', [
            'appointments' => [],
            'filters' => $request->only('status', 'date'),
            'links' => [],
        ]);
    }

}
