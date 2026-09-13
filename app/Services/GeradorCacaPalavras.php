<?php

namespace App\Services;

class GeradorCacaPalavras
{
    protected int $tamanho;
    protected array $grade = [];
    protected array $palavrasPosicionadas = [];

    // Direções possíveis: [linha, coluna]
    protected array $todasDirecoes = [
        [0, 1],   // direita
        [1, 0],   // baixo
        [1, 1],   // diagonal baixo-direita
        [1, -1],  // diagonal baixo-esquerda
        [0, -1],  // esquerda (invertida)
        [-1, 0],  // cima (invertida)
        [-1, -1], // diagonal cima-esquerda (invertida)
        [-1, 1],  // diagonal cima-direita (invertida)
    ];

    public function gerar(array $palavras, int $tamanho, array $direcoesPermitidas): array
    {
        $this->tamanho = $tamanho;
        $this->grade = array_fill(0, $tamanho, array_fill(0, $tamanho, ''));
        $this->palavrasPosicionadas = [];

        // Filtra só as direções permitidas pro nível de dificuldade
        $direcoes = array_intersect_key(
            $this->todasDirecoes,
            array_flip($direcoesPermitidas)
        );

        // Ordena palavras da maior pra menor (facilita encaixar)
        usort($palavras, fn($a, $b) => strlen($b) <=> strlen($a));

        foreach ($palavras as $palavra) {
            $this->posicionarPalavra(strtoupper($palavra), array_values($direcoes));
        }

        $this->preencherEspacosVazios();

        return [
            'grade' => $this->grade,
            'palavras' => $this->palavrasPosicionadas,
        ];
    }

    protected function posicionarPalavra(string $palavra, array $direcoes): bool
    {
        $tentativas = 100;
        $tamanhoPalavra = mb_strlen($palavra);

        while ($tentativas > 0) {
            $direcao = $direcoes[array_rand($direcoes)];
            $linhaInicio = rand(0, $this->tamanho - 1);
            $colunaInicio = rand(0, $this->tamanho - 1);

            if ($this->cabeNaGrade($palavra, $linhaInicio, $colunaInicio, $direcao)) {
                $posicoes = [];
                for ($i = 0; $i < $tamanhoPalavra; $i++) {
                    $linha = $linhaInicio + ($direcao[0] * $i);
                    $coluna = $colunaInicio + ($direcao[1] * $i);
                    $this->grade[$linha][$coluna] = mb_substr($palavra, $i, 1);
                    $posicoes[] = ['linha' => $linha, 'coluna' => $coluna];
                }

                $this->palavrasPosicionadas[] = [
                    'palavra' => $palavra,
                    'posicoes' => $posicoes,
                ];

                return true;
            }

            $tentativas--;
        }

        return false; // não coube, ignora essa palavra
    }

    protected function cabeNaGrade(string $palavra, int $linha, int $coluna, array $direcao): bool
    {
        $tamanhoPalavra = mb_strlen($palavra);

        for ($i = 0; $i < $tamanhoPalavra; $i++) {
            $l = $linha + ($direcao[0] * $i);
            $c = $coluna + ($direcao[1] * $i);

            if ($l < 0 || $l >= $this->tamanho || $c < 0 || $c >= $this->tamanho) {
                return false;
            }

            $letraAtual = $this->grade[$l][$c];
            $letraNova = mb_substr($palavra, $i, 1);

            if ($letraAtual !== '' && $letraAtual !== $letraNova) {
                return false;
            }
        }

        return true;
    }

    protected function preencherEspacosVazios(): void
    {
        $alfabeto = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($l = 0; $l < $this->tamanho; $l++) {
            for ($c = 0; $c < $this->tamanho; $c++) {
                if ($this->grade[$l][$c] === '') {
                    $this->grade[$l][$c] = $alfabeto[rand(0, strlen($alfabeto) - 1)];
                }
            }
        }
    }
}