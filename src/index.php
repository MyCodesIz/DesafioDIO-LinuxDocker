<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo PHP</title>
</head>
<body>

<?php
// Exibir erros apenas no ambiente de desenvolvimento
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Definir cabeçalho para UTF-8
header('Content-Type: text/html; charset=utf-8');

// Credenciais (usar variáveis de ambiente em produção)
$servername = getenv('DB_HOST') ?: '54.234.153.24';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'Senha123';
$database = getenv('DB_NAME') ?: 'meubanco';

// Tenta conectar ao banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    echo 'Versão Atual do PHP: ' . phpversion() . '<br>';

    // Gerar valores aleatórios
    $valor_rand1 = rand(1, 999);
    $valor_rand2 = strtoupper(substr(bin2hex(random_bytes(4)), 1));
    $host_name = gethostname();

    // Inserir dados de forma segura com prepared statement
    $query = "INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) 
              VALUES (:id, :nome, :sobrenome, :endereco, :cidade, :host)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':id' => $valor_rand1,
        ':nome' => $valor_rand2,
        ':sobrenome' => $valor_rand2,
        ':endereco' => $valor_rand2,
        ':cidade' => $valor_rand2,
        ':host' => $host_name
    ]);

    echo "Novo registro criado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados.";
    // Em produção, logar $e->getMessage() ao invés de exibi-lo.
}
?>

</body>
</html>
