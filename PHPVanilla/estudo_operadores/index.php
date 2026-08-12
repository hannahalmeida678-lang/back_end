<?php
//  1. blindagem de operações entre variáveis de tipos diferentes
declare(strict_types=1);

//criar um calculo de holerite em php

// declaraçao de constantes
 
const TAXA_INSS = 0.08; 
const DESCONTO_VT = 150.00

//DECLARAR VARIAVEIS
//Dados do Funcionário
$nomeFuncionario = "jOÃO SILVA";
$salariobase = 3200.00;
$horasExtras = 10;

// declaraçao de variaveis usando camelcase
// regra -> primeira palavra toda minúsculo e depois as demais palavras usa-se maiusculas na primeira palavra
// exemplo $hojeEstáUmDiaBonito

//CALCULOS do salario
//Valor da extra (1.6 da hora normal
$valorHoraExtra = ($salariobase/220) * 1.6;
// crie uma variavel chamada $totaldehorasextras
$totalHoraExtra = $valorHoraExtra * $horasExtras;
// -> Crie uma variável $slarioBruto
$salarioBruto = $salariobase + $totalHoraExtra
// -> Criar a variável $descontoInss
 $descontoInss = $salarioBruto * TAXA_INSS;
// -> Criar a variável $salarioLiquido
$salarioliquido= ($salarioBruto - $descontoInss) - DESCONTO_VT

?>