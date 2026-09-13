# Caça-Palavras — Laravel

Jogo de caça-palavras desenvolvido em **Laravel** e **PostgreSQL**, com geração dinâmica de tabuleiro, múltiplos níveis de dificuldade e mais de 300 palavras organizadas por tema.


> Projeto desenvolvido como estudo prático de Laravel, lógica de algoritmos e organização de código em camadas (Models, Services, Controllers).

## Funcionalidades

- **3 níveis de dificuldade** (Fácil, Médio, Difícil), variando tamanho do tabuleiro, quantidade de palavras e direções permitidas (horizontal, vertical, diagonal e invertida)
- **6 temas de palavras**: animais, frutas, países, profissões, tecnologia e esportes
- Seleção de palavras **por arraste do mouse ou toque** (compatível com celular/tablet)
- Feedback visual de acerto (verde) e erro (vermelho)
- Cronômetro em tempo real
- Tela de vitória com botão para **jogar novamente** (gera um novo tabuleiro automaticamente)
- 
## Demonstração

### Tela inicial
<img width="571" height="626" alt="image" src="https://github.com/user-attachments/assets/c7d27638-ba46-41c0-a5fc-93218deb32e2" />


### Jogo em andamento
<img width="930" height="542" alt="image" src="https://github.com/user-attachments/assets/659d40b5-ff52-4c85-a201-f9b3c13148b2" />


### Tela de vitória
<img width="912" height="712" alt="image" src="https://github.com/user-attachments/assets/a1048e12-4fe1-4ac8-ab22-c58c18e34156" />

## Tecnologias utilizadas

- **PHP 8.5**
- **Laravel 13**
- **PostgreSQL**
- **Blade** (views)
- **JavaScript puro** (interação do tabuleiro, sem frameworks front-end)

## Como funciona o algoritmo do tabuleiro

O núcleo do jogo é a classe `App\Services\GeradorCacaPalavras`, responsável por:

1. Receber uma lista de palavras, o tamanho do tabuleiro e as direções permitidas para o nível escolhido
2. Tentar posicionar cada palavra em uma posição e direção aleatórias, validando se ela cabe sem conflitar com palavras já posicionadas
3. Preencher os espaços vazios restantes com letras aleatórias
4. Retornar a grade final e as posições de cada palavra (usadas pelo JavaScript para validar a seleção do jogador)

## Como rodar o projeto localmente

### Pré-requisitos
- PHP 8.2+
- Composer
- PostgreSQL

### Passos

# Clonar o repositório
git clone https://github.com/ArielleSousa/caca-palavras-laravel.git
cd caca-palavras-laravel

# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar o banco no .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
# Criar o banco de dados no PostgreSQL antes de rodar as migrations

# Rodar migrations e popular o banco
php artisan migrate
php artisan db:seed --class=PalavraSeeder

# Subir o servidor
php artisan serve

Acesse: `http://localhost:8000`
