<?php
declare(strict_types=1);

//camada de acesso a dados (DAO) para o almoxerifado
//essa camada é uma classe - usa paradigma de programação orientada ao objeto


final class AlmoxarifadoDAO{
    //atributos -> as caracteristicas do objeto
    private PDO $pdo;

    // métodos -> ações
    //metodo que toda classe tem
    public function __constructor(PDO $pdo){
        $this->pdo = $pdo;
    }

    // métodos do CRUD
}