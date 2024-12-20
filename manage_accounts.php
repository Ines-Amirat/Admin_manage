<?php
include 'db.php'; // Inclure la connexion à la base de données

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $sql = "DELETE FROM compte WHERE NumCpt = $id";
        if ($conn->query($sql) === TRUE) {
            echo "Account successfully deleted.";
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        // Retourner l'erreur du trigger ou une erreur SQL
        http_response_code(400); // Code d'erreur HTTP 400 (mauvaise requête)
        echo $e->getMessage();
    }
    exit;
}

// Récupérer les comptes depuis la base de données
$sql = "SELECT NumCpt, SoldeCpt, TypeCpt, NumClient FROM compte";
$result = $conn->query($sql);

// Créer le tableau HTML
echo "<table>
        <tr>
            <th>ID</th>
            <th>Balance</th>
            <th>Type</th>
            <th>Client Number</th>
            <th>Actions</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['NumCpt']}</td>
            <td>{$row['SoldeCpt']}</td>
            <td>{$row['TypeCpt']}</td>
            <td>{$row['NumClient']}</td>
            <td>
                <button onclick=\"deleteItem('accounts', {$row['NumCpt']})\">Delete</button>
            </td>
          </tr>";
}
echo "</table>";

$conn->close();
?>
