<?php

namespace App\Http\Controllers;

use App\Models\Palavra;
use App\Services\GeradorCacaPalavras;
use Illuminate\Http\Request;

class JogoController extends Controller
{
    protected array $configuracoes = [
        'facil' => [
            'tamanho' => 10,
            'qtd_palavras' => 6,
            'direcoes' => [0, 1], // direita, baixo
        ],
        'medio' => [
            'tamanho' => 14,
            'qtd_palavras' => 10,
            'direcoes' => [0, 1, 2, 3], // + diagonais (sem invertidas)
        ],
        'dificil' => [
            'tamanho' => 18,
            'qtd_palavras' => 15,
            'direcoes' => [0, 1, 2, 3, 4, 5, 6, 7], // todas as direções
        ],
    ];

    public function home()
    {
        $temas = Palavra::select('tema')->distinct()->pluck('tema');
        return view('home', ['temas' => $temas]);
    }

    public function jogar(Request $request, string $dificuldade)
    {
        if (!array_key_exists($dificuldade, $this->configuracoes)) {
            abort(404);
        }

        $config = $this->configuracoes[$dificuldade];
        $tema = $request->query('tema');

        $query = Palavra::query();
        if ($tema) {
            $query->where('tema', $tema);
        }

        $palavras = $query->inRandomOrder()
            ->limit($config['qtd_palavras'])
            ->pluck('palavra')
            ->toArray();

        $gerador = new GeradorCacaPalavras();
        $resultado = $gerador->gerar($palavras, $config['tamanho'], $config['direcoes']);

        return view('jogo', [
            'grade' => $resultado['grade'],
            'palavras' => $resultado['palavras'],
            'dificuldade' => $dificuldade,
            'tamanho' => $config['tamanho'],
        ]);
    }
}