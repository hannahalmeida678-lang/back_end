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

        echo "\n--- PRODUTOS ---\n";

        foreach ($produtos as $codigo => $produto) {
            echo "$codigo - {$produto['nome']} | ";
            echo "R$ " . number_format($produto['preco'], 2, ',', '.') . " | ";
            echo "Estoque: {$produto['estoque']}\n";
        }

    // Adicionar produto
    } elseif ($opcao == 2) {

        $codigo = (int) readline("Código do produto: ");

        if (!isset($produtos[$codigo])) {
            echo "Produto não existe!\n";
            continue;
        }

        if ($produtos[$codigo]["estoque"] <= 0) {
            echo "Produto sem estoque!\n";
            continue;
        }

        $quantidade = (int) readline("Quantidade: ");

        if ($quantidade <= 0) {
            echo "Quantidade inválida!\n";
            continue;
        }

        if ($quantidade > $produtos[$codigo]["estoque"]) {
            echo "Estoque insuficiente!\n";
            continue;
        }

        // Retira do estoque
        $produtos[$codigo]["estoque"] -= $quantidade;

        // Verifica se o produto já está no pedido
        $encontrado = false;

        foreach ($pedido as $indice => $item) {

            if ($item["codigo"] == $codigo) {

                $pedido[$indice]["quantidade"] += $quantidade;
                $encontrado = true;

                break;
            }
        }

        // Se não estiver no pedido, adiciona
        if (!$encontrado) {

            $pedido[] = [
                "codigo" => $codigo,
                "nome" => $produtos[$codigo]["nome"],
                "preco" => $produtos[$codigo]["preco"],
                "quantidade" => $quantidade
            ];
        }

        echo "Produto adicionado ao pedido!\n";

    // Resumo
    } elseif ($opcao == 3) {

        if (empty($pedido)) {
            echo "Nenhum produto foi adicionado!\n";
            continue;
        }

        echo "\n--- RESUMO DO PEDIDO ---\n";

        $total = 0;

        foreach ($pedido as $item) {

            $subtotal = $item["quantidade"] * $item["preco"];
            $total += $subtotal;

            echo "Produto: {$item['nome']}\n";
            echo "Quantidade: {$item['quantidade']}\n";
            echo "Preço: R$ " . number_format($item["preco"], 2, ',', '.') . "\n";
            echo "Subtotal: R$ " . number_format($subtotal, 2, ',', '.') . "\n";
            echo "-------------------------\n";
        }

        echo "Total: R$ " . number_format($total, 2, ',', '.') . "\n";

    // Finalizar compra
    } elseif ($opcao == 4) {

        if (empty($pedido)) {
            echo "Pedido vazio!\n";
            continue;
        }

        $total = 0;

        foreach ($pedido as $item) {
            $total += $item["quantidade"] * $item["preco"];
        }

        echo "\n--- FINALIZAR COMPRA ---\n";
        echo "Total da compra: R$ " . number_format($total, 2, ',', '.') . "\n";

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

        echo "Total final: R$ " . number_format($total, 2, ',', '.') . "\n";
        echo "Compra finalizada com sucesso!\n";

        break;

    // Sair
    } elseif ($opcao == 0) {

        echo "Saindo...\n";
        break;

    // Opção inválida
    } else {

        echo "Opção inválida!\n";
    }

} while ($opcao != 4 && $opcao != 0);

?>