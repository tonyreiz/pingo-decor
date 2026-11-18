<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormularioController extends Controller
{
    public function index(Request $request): View
    {
        $consulta = Formulario::query();

        if ($request->filled('busca')) {
            $busca = $request->string('busca')->toString();
            $consulta->where(function ($query) use ($busca) {
                $query->where('nome', 'like', "%{$busca}%")
                    ->orWhere('telefone', 'like', "%{$busca}%")
                    ->orWhere('email', 'like', "%{$busca}%")
                    ->orWhere('tipo_projeto', 'like', "%{$busca}%");
            });
        }

        $formularios = $consulta->orderByDesc('id_formulario')->paginate(15)->withQueryString();

        return view('admin.formulario.index', compact('formularios'));
    }
}
