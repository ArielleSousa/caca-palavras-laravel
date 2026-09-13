<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Caça-Palavras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .card {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            width: 90%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        h1 { font-size: 28px; margin-bottom: 8px; }
        p.subtitulo { opacity: 0.8; margin-bottom: 30px; font-size: 14px; }
        label { display: block; text-align: left; margin-bottom: 6px; font-size: 14px; opacity: 0.9; }
        select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-bottom: 24px;
            font-size: 15px;
        }
        .niveis { display: flex; flex-direction: column; gap: 12px; }
        .btn-nivel {
            display: block;
            padding: 14px;
            border-radius: 10px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.15s ease;
        }
        .btn-nivel:hover { transform: scale(1.03); }
        .facil { background: #4caf50; color: #fff; }
        .medio { background: #ff9800; color: #fff; }
        .dificil { background: #e53935; color: #fff; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Caça-Palavras</h1>
        <p class="subtitulo">Escolha um tema e o nível de dificuldade</p>

        <label for="tema">Tema (opcional)</label>
        <select id="tema">
            <option value="">Misturar todos</option>
            @foreach ($temas as $tema)
                <option value="{{ $tema }}">{{ ucfirst($tema) }}</option>
            @endforeach
        </select>

        <div class="niveis">
            <a href="#" class="btn-nivel facil" data-dificuldade="facil">Fácil</a>
            <a href="#" class="btn-nivel medio" data-dificuldade="medio">Médio</a>
            <a href="#" class="btn-nivel dificil" data-dificuldade="dificil">Difícil</a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-nivel').forEach(botao => {
            botao.addEventListener('click', function (e) {
                e.preventDefault();
                const dificuldade = this.dataset.dificuldade;
                const tema = document.getElementById('tema').value;
                let url = `/jogar/${dificuldade}`;
                if (tema) url += `?tema=${tema}`;
                window.location.href = url;
            });
        });
    </script>
</body>
</html>