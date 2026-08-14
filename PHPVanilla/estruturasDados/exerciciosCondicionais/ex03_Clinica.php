<?php
declare(strict_types=1);
//Crie as variáveis $peso (ex: 85.5) e $altura (ex: 1.75).
$peso = 54;
$altura = 1.59;

$IMC = $peso/($altura**2);

if ($IMC < 18.5 ){
    echo "Abaixo do peso";
}
elseif($IMC >= 18.5) {
echo "peso normal";
}
elseif($IMC > 30) {
echo "Obesidade Grau I";
}
elseif($IMC > 35) {
echo "Obesidade Grau II ou III";
}





?>