

```php
<?php

// Produtos
$produtos = [
    1 => ["nome" => "Coxinha", "preco" => 6.00, "estoque" => 10],
    2 => ["nome" => "Suco", "preco" => 5.00, "estoque" => 8],
    3 => ["nome" => "Sanduíche", "preco" => 12.00, "estoque" => 5],
    4 => ["nome" => "Bolo", "preco" => 7.50, "estoque" => 6]
];

$pedido = [];
$opcao = 0;

// Menu
do {
    echo "\n--- CANTINA SENAI ---\n";
    echo "1 - Listar produtos\n";
    echo "2 - Adicionar produto\n";
    echo "3 - Resumo do pedido\n";
    echo "4 - Finalizar compra\n";
    echo "0 - Sair\n";

    $opcao = (int) readline("Escolha: ");

    // Listar produtos
    if ($opcao == 1) {

        foreach ($produtos as $codigo => $produto) {
            echo "$codigo | {$produto['nome']} | R$ {$produto['preco']} | Estoque: {$produto['estoque']}\n";
        }

    // Adicionar produto
    } elseif ($opcao == 2) {

        $codigo = (int) readline("Código do produto: ");

        if (!isset($produtos[$codigo])) {
            echo "Produto não existe!\n";
            continue;
        }

        $quantidade = 0;

        while ($quantidade <= 0 || $quantidade > $produtos[$codigo]["estoque"]) {

            $quantidade = (int) readline("Quantidade: ");

            if ($quantidade <= 0) {
                echo "Quantidade inválida!\n";
            } elseif ($quantidade > $produtos[$codigo]["estoque"]) {
                echo "Estoque insuficiente!\n";
            }
        }

        $produtos[$codigo]["estoque"] -= $quantidade;

        $pedido[] = [
            "nome" => $produtos[$codigo]["nome"],
            "preco" => $produtos[$codigo]["preco"],
            "quantidade" => $quantidade
        ];

        echo "Produto adicionado!\n";

    // Resumo
    } elseif ($opcao == 3) {

        if (empty($pedido)) {
            echo "Nenhum produto foi adicionado!\n";
            continue;
        }

        echo "\nProduto | Quantidade | Preço | Subtotal\n";

        foreach ($pedido as $item) {
            $subtotal = $item["quantidade"] * $item["preco"];

            echo "{$item['nome']} | ";
            echo "{$item['quantidade']} | ";
            echo "R$ {$item['preco']} | ";
            echo "R$ $subtotal\n";
        }

        $total = 0;

        for ($i = 0; $i < count($pedido); $i++) {
            $total += $pedido[$i]["quantidade"] * $pedido[$i]["preco"];
        }

        echo "Total: R$ $total\n";

    // Finalizar
    } elseif ($opcao == 4) {

        if (empty($pedido)) {
            echo "Pedido vazio!\n";
            continue;
        }

        $total = 0;

        for ($i = 0; $i < count($pedido); $i++) {
            $total += $pedido[$i]["quantidade"] * $pedido[$i]["preco"];
        }

        echo "Total da compra: R$ $total\n";
        echo "1 - Pix\n";
        echo "2 - Cartão\n";
        echo "3 - Dinheiro\n";

        $pagamento = (int) readline("Pagamento: ");

        if ($pagamento == 1) {
            $total = $total * 0.95;
            echo "Desconto de 5% aplicado!\n";
        } elseif ($pagamento == 2) {
            echo "Sem desconto.\n";
        } elseif ($pagamento == 3) {
            $total = $total * 0.97;
            echo "Desconto de 3% aplicado!\n";
        } else {
            echo "Pagamento inválido!\n";
            continue;
        }

        echo "Total final: R$ $total\n";
        echo "Compra finalizada!\n";

        break;

    // Sair
    } elseif ($opcao == 0) {

        echo "Saindo...\n";
        break;

    } else {

        echo "Opção inválida!\n";
        continue;
    }

} while ($opcao != 4 && $opcao != 0); //&& : para o resultado set verdadeiro, todas as combinaçoes tem que ser verdadeiras

?>
```

