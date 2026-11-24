<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $totalFormularios = Formulario::count();
        $formulariosRecentes = Formulario::orderByDesc('id_formulario')->limit(5)->get();

        return view('admin.dashboard', compact('totalFormularios', 'formulariosRecentes'));
    }
}
