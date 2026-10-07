# Situação de Aprendizagem Usando Sessão , Cookie e Autenticação

## Estrutura do Projeto

Organize sua pasta extamento com a seguinte árvores de arquivos

```text
SAAutenticacao/
├── config/
│   └── database.ini        <- Credenciais protegidas de acesso ao PostgreSQL
├── logs/
│   └── database.log        <- Logs do Banco de Dados
├── src/
│   ├── ConexaoBanco.php    <- Conexão Singleton PDO com PostgreSQL
│   ├── UsuarioDAO.php      <- Camada de persistência para consulta e cadastro
│   ├── AuthService.php     <- Serviço de gerenciamento de sessão e expiração
│   └── guard.php           <- Middleware interceptador de páginas restritas
├── schema.sql              <- Estrutura da tabela de usuários corporativos
├── login.php               <- Tela de autenticação pública
├── dashboard.php           <- Painel restrito protegido
├── logout.php              <- Encerramento seguro de sessão
├── cadastro.php            <- Página de Cadastro de Usuários
├── .gitignore              <- Arquivos não Versionados
└── README.md               <- Documentação do Projeto
```

## Criação da Tabela no Banco de Dados(PostgreSQL)

```sql
-- Criação da tabela devera ser dentro do banco almoxarifado_senai

CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL DEFAULT 'OPERADOR' CHECK (perfil IN ('ADMIN', 'OPERADOR')),
    ativo BOOLEAN NOT NULL DEFAULT TRUE,
    criado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

```
![alt text](image.png)

## Configurar os Dados do Banco e Criar a Conexão Singleton

Configurar os Dados do Banco de Dados (`config/datbase.ini`)

```ini
; config/database.ini
[database]
db_driver   = pgsql
db_host     = 127.0.0.1
db_port     = 5432
db_name     = almoxarifado_senai
db_user     = postgres
db_pass     = postgres
```

Criar a Classe de Conexão com o Banco de Dados em Formato Singleton (`src/ConexaoBanco.php`)


```php
<?php
declare(strict_types=1);

//criando uma classe responsável por realizar a a conexão com o Banco
// essa classe será uma Singleton ( permitira instanciar apenas um objeto por vez)

final class ConexaoBanco {
    //atributos
    // Armazenar a Conexão aberta com o Banco de Dados
    private static ?PDO $instancia = null;

    //métodos
    // toda classe precisa de um construtor (o construtor é um método que permite a criação de objetos)
    // em classes do tipo singleton o construtor é private e vazio
    private function __construct(){}

    // métodos de segurança anti clonagem e anti-serialização(desserialização)
    private function __clone(): void{}
    public function __wakeup(): void{
        // estou criando uma exception()
        throw new \Exception("Desserialização não permitida para Singleton");
    }

    //método para obter a Conexão ( precisa sem público e estático)
    public static function obterConexao(string $caminhoConfig): PDO {
        //verificar se já não existe uma conexão
        if(self::$instancia ===null){// se a conexão não exisitir, entao crio uma
            $config = self::carregarArquivoConfig($caminhoConfig);
            self::$instancia = self::estabelecerConexao($config);
        }// caso já exista, retrona a conexão já existente
        return self::$instancia;
    }
    
    //criar os método para carregar arquivo do .ini
    private static function carregarArquivoConfig(string $caminho): array {
        if(!file_exists($caminho)){ // se arquivo não exisitir 
            throw new \RuntimeException("Arquivo de Configuração não encontrado em {$caminho}");
        }// caso o arquivo exista
        $dados = parse_ini_file($caminho, true);
        if($dados === false || !isset($dados["database"])){
            throw new \RuntimeException("Seçao [database] ausente no arquivo de configuração");
        }// se tudo estiver certo
        return $dados["database"];
    }

    // criar método para estabelecer a conexão com o banco
    private static function estabelecerConexao(array $cfg): PDO{
        //montar o endereço de conexão (pgsql:host=127.0.0.1;port=5432;biblioteca_escola)
        $dsn = sprintf(
            "%s:host=%s;port=%s;dbname=%s",
            $cfg["db_driver"],
            $cfg["db_host"],
            $cfg["db_port"],
            $cfg["db_name"],
        );

        //montar as flags de Segurança do PDO
        $opcoes = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5
        ];
        return new PDO($dsn, $cfg["db_user"], $cfg["db_pass"], $opcoes);
    }
}
?>
```

