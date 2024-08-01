<?php
include 'db.php';

// Busca clientes para preencher a combobox
$query = "SELECT id, nome FROM cliente";
$stmt = $pdo->query($query);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $cliente_id = $_POST['cliente_id'];

    $query = "INSERT INTO pet (nome, especie, raca, idade, cliente_id) VALUES (:nome, :especie, :raca, :idade, :cliente_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['nome' => $nome, 'especie' => $especie, 'raca' => $raca, 'idade' => $idade, 'cliente_id' => $cliente_id]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Pet</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Adicionar Pet</h1>
    <form method="post" action="add.php">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="especie">Espécie</label>
            <input type="text" id="especie" name="especie" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="raca">Raça</label>
            <input type="text" id="raca" name="raca" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="idade">Idade</label>
            <input type="number" id="idade" name="idade" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cliente_id">Dono</label>
            <select id="cliente_id" name="cliente_id" class="form-control" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nome']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
