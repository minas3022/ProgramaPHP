<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$query = "
    SELECT pet.*, cliente.nome as cliente_nome 
    FROM pet 
    LEFT JOIN cliente ON pet.cliente_id = cliente.id 
    WHERE pet.nome ILIKE :search OR cliente.nome ILIKE :search 
    ORDER BY pet.id
";
$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$search%"]);
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Pets</h1>
    <form method="get" action="index.php" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Pesquisar..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Pesquisar</button>
    </form>
    <a href="add.php" class="btn btn-primary mb-3">Adicionar Pet</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Raça</th>
            <th>Idade</th>
            <th>Dono</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pets as $pet): ?>
            <tr>
                <td><?php echo htmlspecialchars($pet['id']); ?></td>
                <td><?php echo htmlspecialchars($pet['nome']); ?></td>
                <td><?php echo htmlspecialchars($pet['especie']); ?></td>
                <td><?php echo htmlspecialchars($pet['raca']); ?></td>
                <td><?php echo htmlspecialchars($pet['idade']); ?></td>
                <td><?php echo htmlspecialchars($pet['cliente_nome']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $pet['id']; ?>" class="btn btn-secondary">Editar</a>
                    <a href="delete.php?id=<?php echo $pet['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este pet?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
