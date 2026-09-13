<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Caça-Palavras - {{ ucfirst($dificuldade) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; user-select: none; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .topo {
            width: 100%;
            max-width: 700px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .topo a { color: #fff; text-decoration: none; opacity: 0.8; font-size: 14px; }
        .info { display: flex; gap: 16px; font-size: 14px; }
        .badge {
            background: rgba(255,255,255,0.15);
            padding: 6px 14px;
            border-radius: 20px;
        }
        .container-jogo {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
            max-width: 900px;
        }
        #tabuleiro {
            display: grid;
            gap: 2px;
            background: rgba(0,0,0,0.2);
            padding: 8px;
            border-radius: 10px;
        }
        .letra {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.08);
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }
        .letra.selecionada { background: #ffeb3b; color: #1e3c72; }
        .letra.encontrada { background: #4caf50; color: #fff; }
        .lista-palavras {
            min-width: 200px;
        }
        .letra.errada { background: #e53935 !important; color: #fff; }        
        .lista-palavras h3 { margin-bottom: 12px; }
        .lista-palavras ul { list-style: none; }
        .lista-palavras li {
            padding: 6px 10px;
            margin-bottom: 6px;
            background: rgba(255,255,255,0.08);
            border-radius: 6px;
            font-size: 14px;
        }
        .lista-palavras li.encontrada { background: #4caf50; text-decoration: line-through; opacity: 0.7; }
        .vitoria {
            display: none;
            margin-top: 20px;
            font-size: 20px;
            background: #4caf50;
            padding: 16px 24px;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="topo">
        <a href="/">← Voltar</a>
        <div class="info">
            <span class="badge">Nível: {{ ucfirst($dificuldade) }}</span>
            <span class="badge">⏱ <span id="cronometro">00:00</span></span>
            <span class="badge"><span id="contador">0</span>/{{ count($palavras) }}</span>
        </div>
    </div>

    <div class="container-jogo">
        <div id="tabuleiro" style="grid-template-columns: repeat({{ $tamanho }}, 32px);">
            @foreach ($grade as $l => $linha)
                @foreach ($linha as $c => $letra)
                    <div class="letra" data-linha="{{ $l }}" data-coluna="{{ $c }}">{{ $letra }}</div>
                @endforeach
            @endforeach
        </div>

        <div class="lista-palavras">
            <h3>Encontre:</h3>
            <ul id="lista">
                @foreach ($palavras as $p)
                    <li data-palavra="{{ $p['palavra'] }}">{{ $p['palavra'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="vitoria" id="vitoria">
        🎉 Parabéns! Você encontrou todas as palavras em <span id="tempoFinal"></span>!
        <br><br>
        <button id="btnReiniciar" style="padding: 10px 20px; border: none; border-radius: 8px; background: #fff; color: #1e3c72; font-weight: bold; cursor: pointer; font-size: 15px;">
             Jogar novamente
        </button>
    </div>

    <script>
        const palavrasData = @json($palavras);
        let encontradas = new Set();
        let selecionando = false;
        let celulasSelecionadas = [];
        let inicioTempo = Date.now();
        let cronometroInterval;

        cronometroInterval = setInterval(() => {
            const segundosTotais = Math.floor((Date.now() - inicioTempo) / 1000);
            const min = String(Math.floor(segundosTotais / 60)).padStart(2, '0');
            const seg = String(segundosTotais % 60).padStart(2, '0');
            document.getElementById('cronometro').textContent = `${min}:${seg}`;
        }, 1000);

        const celulas = document.querySelectorAll('.letra');

        function chaveCelula(l, c) {
            return `${l}-${c}`;
        }

        function limparSelecao() {
            celulasSelecionadas.forEach(el => el.classList.remove('selecionada'));
            celulasSelecionadas = [];
        }

        function getCelulasEntre(inicio, fim) {
            const l1 = parseInt(inicio.dataset.linha), c1 = parseInt(inicio.dataset.coluna);
            const l2 = parseInt(fim.dataset.linha), c2 = parseInt(fim.dataset.coluna);

            const dl = l2 - l1, dc = c2 - c1;
            const passos = Math.max(Math.abs(dl), Math.abs(dc));

            if (passos === 0) return [inicio];

            // Só permite linha reta (horizontal, vertical, diagonal)
            if (dl !== 0 && dc !== 0 && Math.abs(dl) !== Math.abs(dc)) return [];

            const passoL = dl === 0 ? 0 : dl / Math.abs(dl);
            const passoC = dc === 0 ? 0 : dc / Math.abs(dc);

            const resultado = [];
            for (let i = 0; i <= passos; i++) {
                const l = l1 + passoL * i;
                const c = c1 + passoC * i;
                const el = document.querySelector(`.letra[data-linha="${l}"][data-coluna="${c}"]`);
                if (!el) return [];
                resultado.push(el);
            }
            return resultado;
        }

        let celulaInicio = null;

        function iniciarSelecao(el) {
            selecionando = true;
            celulaInicio = el;
            limparSelecao();
            el.classList.add('selecionada');
            celulasSelecionadas = [el];
        }

        function atualizarSelecao(el) {
            if (!selecionando) return;
            const caminho = getCelulasEntre(celulaInicio, el);
            celulasSelecionadas.forEach(c => c.classList.remove('selecionada'));
            caminho.forEach(c => c.classList.add('selecionada'));
            celulasSelecionadas = caminho;
        }

        function finalizarSelecao() {
            if (!selecionando) return;
            selecionando = false;

            const palavraSelecionada = celulasSelecionadas.map(c => c.textContent).join('');
            const palavraInvertida = palavraSelecionada.split('').reverse().join('');

            const encontrou = palavrasData.find(p =>
                (p.palavra === palavraSelecionada || p.palavra === palavraInvertida) &&
                !encontradas.has(p.palavra)
            );

            if (encontrou) {
                encontradas.add(encontrou.palavra);
                celulasSelecionadas.forEach(c => {
                    c.classList.remove('selecionada');
                    c.classList.add('encontrada');
                });
                document.querySelector(`li[data-palavra="${encontrou.palavra}"]`).classList.add('encontrada');
                document.getElementById('contador').textContent = encontradas.size;

                if (encontradas.size === palavrasData.length) {
                    clearInterval(cronometroInterval);
                    const segundosTotais = Math.floor((Date.now() - inicioTempo) / 1000);
                    const min = String(Math.floor(segundosTotais / 60)).padStart(2, '0');
                    const seg = String(segundosTotais % 60).padStart(2, '0');
                    document.getElementById('tempoFinal').textContent = `${min}:${seg}`;
                    document.getElementById('vitoria').style.display = 'block';
                }
            } else if (celulasSelecionadas.length > 1) {
                celulasSelecionadas.forEach(c => {
                    c.classList.remove('selecionada');
                    c.classList.add('errada');
                });
                setTimeout(() => {
                    celulasSelecionadas.forEach(c => c.classList.remove('errada'));
                    celulasSelecionadas = [];
                }, 400);
            } else {
                limparSelecao();
            }
        }

        celulas.forEach(el => {
            el.addEventListener('mousedown', () => iniciarSelecao(el));
            el.addEventListener('mouseenter', () => atualizarSelecao(el));
            el.addEventListener('mouseup', finalizarSelecao);

            // Suporte a toque (celular/tablet)
            el.addEventListener('touchstart', (e) => {
                e.preventDefault();
                iniciarSelecao(el);
            });
        });

        document.addEventListener('touchmove', (e) => {
            if (!selecionando) return;
            e.preventDefault();
            const touch = e.touches[0];
            const elemento = document.elementFromPoint(touch.clientX, touch.clientY);
            if (elemento && elemento.classList.contains('letra')) {
                atualizarSelecao(elemento);
            }
        }, { passive: false });
        
        document.addEventListener('touchend', finalizarSelecao);
        document.addEventListener('mouseup', finalizarSelecao);
        document.getElementById('btnReiniciar').addEventListener('click', () => {
            window.location.reload();
        });
    </script>
</body>
</html>