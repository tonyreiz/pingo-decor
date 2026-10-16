<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Projetos;
use App\Models\Depoimento;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function home(): View
    {
        $bannerPrincipal = Banner::where('status_banner', 'Ativo')
            ->orderByDesc('id_banner')
            ->first();

        $projetosDinamicos = Projetos::where('status_projetos', 'Ativo')
            ->orderByDesc('id_projetos')
            ->get();

        $listaDepoimento = Depoimento::with('cliente')
            ->where('status_depoimento', 'Ativo')
            ->orderByDesc('id_depoimento')
            ->get();

        
        return view('site.home.home', compact('bannerPrincipal', 'projetosDinamicos', 'listaDepoimento'));
    }
}
