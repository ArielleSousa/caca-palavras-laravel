<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Palavra;

class PalavraSeeder extends Seeder
{
    public function run(): void
    {
        $palavras = [
            'animais' => [
                'GATO','CACHORRO','ELEFANTE','GIRAFA','LEAO','TIGRE','MACACO','COBRA',
                'JACARE','TARTARUGA','CAVALO','VACA','PORCO','GALINHA','PATO','PEIXE',
                'BALEIA','GOLFINHO','TUBARAO','POLVO','ARANHA','FORMIGA','ABELHA','BORBOLETA',
                'COELHO','RATO','LOBO','RAPOSA','URSO','PANDA','CANGURU','ZEBRA',
                'HIPOPOTAMO','RINOCERONTE','CROCODILO','LAGARTO','ESCORPIAO','PINGUIM','AGUIA','CORUJA',
                'PAPAGAIO','FLAMINGO','AVESTRUZ','MORCEGO','OURICO','TOUPEIRA','LONTRA','FOCA',
                'CAMELO','BURRO'
            ],
            'frutas' => [
                'BANANA','MACA','LARANJA','UVA','MORANGO','ABACAXI','MANGA','MAMAO',
                'MELANCIA','MELAO','PERA','PESSEGO','AMEIXA','GOIABA','CAJU','ACEROLA',
                'JABUTICABA','GRAVIOLA','CARAMBOLA','MARACUJA','LIMAO','TANGERINA','FIGO','KIWI',
                'ABACATE','COCO','ROMA','AMORA','FRAMBOESA','MIRTILO','PITANGA','GRAPEFRUIT',
                'CEREJA','TAMARA','LICHIA','PINHA','JACA','CUPUACU','BACURI','UMBU',
                'SAPOTI','AÇAI','BUTIA','PEQUI','MANGABA','GUARANA','CAMBUCI','ATEMOIA',
                'NECTARINA','DAMASCO'
            ],
            'paises' => [
                'BRASIL','ARGENTINA','CHILE','URUGUAI','PARAGUAI','BOLIVIA','PERU','COLOMBIA',
                'VENEZUELA','EQUADOR','PORTUGAL','ESPANHA','FRANCA','ITALIA','ALEMANHA','INGLATERRA',
                'HOLANDA','BELGICA','SUICA','AUSTRIA','GRECIA','TURQUIA','RUSSIA','CHINA',
                'JAPAO','INDIA','COREIA','TAILANDIA','VIETNA','INDONESIA','AUSTRALIA','CANADA',
                'MEXICO','CUBA','EGITO','MARROCOS','NIGERIA','QUENIA','ANGOLA','MOCAMBIQUE',
                'SUECIA','NORUEGA','DINAMARCA','FINLANDIA','POLONIA','UCRANIA','ISRAEL','IRLANDA',
                'ESCOCIA','CROACIA'
            ],
            'profissoes' => [
                'MEDICO','PROFESSOR','ENGENHEIRO','ADVOGADO','DENTISTA','ENFERMEIRO','PSICOLOGO','ARQUITETO',
                'CONTADOR','JORNALISTA','PROGRAMADOR','DESIGNER','FOTOGRAFO','COZINHEIRO','PADEIRO','ELETRICISTA',
                'ENCANADOR','MECANICO','PILOTO','MOTORISTA','BOMBEIRO','POLICIAL','VETERINARIO','FARMACEUTICO',
                'NUTRICIONISTA','FISIOTERAPEUTA','BIOLOGO','QUIMICO','FISICO','MATEMATICO','HISTORIADOR','GEOGRAFO',
                'ATOR','CANTOR','MUSICO','ESCRITOR','PINTOR','ESCULTOR','ALFAIATE','CABELEIREIRO',
                'BARBEIRO','GARCOM','RECEPCIONISTA','SECRETARIA','BIBLIOTECARIO','TRADUTOR','INTERPRETE','PILOTO',
                'MARINHEIRO','AGRICULTOR'
            ],
            'tecnologia' => [
                'COMPUTADOR','TECLADO','MOUSE','MONITOR','INTERNET','SOFTWARE','HARDWARE','PROGRAMA',
                'CODIGO','SERVIDOR','BANCO','DADOS','REDE','ROTEADOR','CELULAR','SMARTPHONE',
                'TABLET','NOTEBOOK','IMPRESSORA','ALGORITMO','LINGUAGEM','PYTHON','JAVASCRIPT','FRAMEWORK',
                'APLICATIVO','SISTEMA','ARQUIVO','PASTA','NUVEM','BACKUP','SEGURANCA','SENHA',
                'USUARIO','LOGIN','INTERFACE','PLATAFORMA','NAVEGADOR','DOWNLOAD','UPLOAD','BLUETOOTH',
                'BATERIA','PROCESSADOR','MEMORIA','PLACA','CABO','FONTE','GABINETE','WEBCAM',
                'MICROFONE','FONE'
            ],
            'esportes' => [
                'FUTEBOL','BASQUETE','VOLEIBOL','TENIS','NATACAO','ATLETISMO','CICLISMO','GINASTICA',
                'BOXE','JUDO','KARATE','SURFE','SKATE','GOLFE','RUGBI','HANDEBOL',
                'HOQUEI','ESGRIMA','REMO','TRIATLO','MARATONA','CANOAGEM','ESCALADA','PATINACAO',
                'CAPOEIRA','LUTA','XADREZ','BILHAR','SINUCA','BADMINTON','POLO','ARQUERIA',
                'HALTEROFILISMO','TAEKWONDO','MOTOCROSS','AUTOMOBILISMO','VELA','MERGULHO','SURFE','WINDSURF',
                'PARAPENTE','ALPINISMO','ORIENTACAO','FRISBEE','SOFTBOL','BASEBOL','CRICKET','SQUASH',
                'PINGUE','PONGUE'
            ],
        ];

        foreach ($palavras as $tema => $lista) {
            foreach (array_unique($lista) as $palavra) {
                Palavra::create([
                    'palavra' => $palavra,
                    'tema' => $tema,
                ]);
            }
        }
    }
}