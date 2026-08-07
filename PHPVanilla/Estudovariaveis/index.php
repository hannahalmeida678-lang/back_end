<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>estudo de variaveis</title>
</head>
<body>
   <h3>Estudo de Variáveis</h3>
   <?php
   // sintaxe para declarar uma variavel em php
   // variaveis são representadas pelo simbolo "$" seguido do nome de uma variavel
   $nome = "hannah"; //variavel tipo string
   $idade = 16;// variavel tipo Number
   $status = true; //variavel do tipo boolean
   $altura = 1.75;//variavel do tipo number(float)
   $email = null; //variavel tipo null
   #$endereço; nao e possivel declarar uma variavel sem atribuir um avlor a ela, não existe Undefined em PHP 
//exibir as variaveis na tela
    echo "nome: $nome <br>";
    echo "Idade: $idade <br>";
    echo "Status: $status <br>";
    echo "Altura: $altura <br>";
    echo "Email: $email <br>";

echo "<br> <h3> constantes <\h3> <br>";
//constantes são representadas pela palavra "const" ou "define" seguidas do nome da constante
const PI = 3,14; //constante do tipo number (float)
Const EMPRESA = "google"; //constante do tipo string
define("SITE", "www.google.com");
// sempre declarar o nome da constante com letras maiusculas, e o "$" ,com letras minusculas.
?>



</body>
</html>