<?php
include 'db.php'; // Connexion à la base de données

// Activer les erreurs pour déboguer
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Récupérer les données JSON envoyées par le formulaire
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérifier les données reçues
    if (!$data || empty($data['accountBalance']) || empty($data['accountType']) || empty($data['clientNumber'])) {
        throw new Exception("Erreur : Tous les champs sont requis.");
    }

    // Récupération des valeurs
    $accountBalance = $data['accountBalance'];
    $accountType = $data['accountType'];
    $clientNumber = $data['clientNumber'];

    // Préparer la requête SQL
    $sql = "INSERT INTO compte (SoldeCpt, TypeCpt, NumClient) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Erreur lors de la préparation de la requête : " . $conn->error);
    }

    // Liaison des paramètres
    $stmt->bind_param("dsi", $accountBalance, $accountType, $clientNumber);

    // Exécuter la requête SQL
    if (!$stmt->execute()) {
        // Capture des erreurs MySQL (provenant du trigger)
        throw new Exception($stmt->error);
    }

    // Succès
    echo "Compte ajouté avec succès.";

} catch (Exception $e) {
    // Retourner l'erreur au frontend
    http_response_code(400); // Code 400 pour une requête invalide
    echo $e->getMessage();
}

// Fermer la connexion
if (isset($stmt)) $stmt->close();
$conn->close();
?>
