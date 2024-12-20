<?php
include 'db.php';

// Suppression d'un client
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM Client WHERE NumClient = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Client successfully deleted.";
    } else {
        echo "Erreur : " . $conn->error;
    }
    exit;
}

// Récupération des clients
$sql = "SELECT NumClient, NomClient, TelClient,adrclient FROM Client";
$result = $conn->query($sql);

echo "<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['NumClient']}</td>
            <td>{$row['NomClient']}</td>
            <td>{$row['adrclient']}</td>
            <td>{$row['TelClient']}</td>
            <td>
                <button onclick=\"deleteItem('clients', {$row['NumClient']})\">Delete</button>
            </td>
          </tr>";
}
echo "</table>";

