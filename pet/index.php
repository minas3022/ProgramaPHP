<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$query = "SELECT * FROM cliente WHERE nome ILIKE :search ORDER BY id";
$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$search%"]);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Clientes</h1>
    <form method="get" action="index.php" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Pesquisar..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Pesquisar</button>
    </form>
    <a href="add.php" class="btn btn-primary mb-3">Adicionar Cliente</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $cliente['id']; ?>" class="btn btn-secondary">Editar</a>
                    <a href="delete.php?id=<?php echo $cliente['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
