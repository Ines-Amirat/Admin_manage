// Gestion du clic sur "Manage Clients"
document.getElementById("manage-clients-link").addEventListener("click", function () {
    document.getElementById("main-title").innerText = "Manage Clients";
    fetch("manage_clients.php")
        .then((response) => response.text())
        .then((data) => {
            document.getElementById("table-container").innerHTML = data;
        });
});

// Gestion du clic sur "Manage Accounts"
document.getElementById("manage-accounts-link").addEventListener("click", function () {
    document.getElementById("main-title").innerText = "Manage Accounts";
    fetch("manage_accounts.php")
        .then((response) => response.text())
        .then((data) => {
            document.getElementById("table-container").innerHTML = `
                <button id="add-account-button" style="margin-bottom: 10px;">Add an Account</button>
                ${data}
            `;
            document.getElementById("add-account-button").addEventListener("click", function () {
                window.open("add_account_interface.html", "_blank");
            });
        });
});

// Suppression d'un élément (client ou compte)
function deleteItem(type, id) {
    const responseMessage = document.getElementById("response-message");
    responseMessage.textContent = ""; // Réinitialise le message

    fetch(`manage_${type}.php?action=delete&id=${id}`, { method: "GET" })
        .then((response) => {
            if (!response.ok) {
                return response.text().then((error) => {
                    throw new Error(error);
                });
            }
            return response.text();
        })
        .then((data) => {
            // Affiche un message de succès
            responseMessage.style.color = "green";
            responseMessage.textContent = data;

            // Recharge la table
            if (type === "clients") {
                document.getElementById("manage-clients-link").click();
            } else if (type === "accounts") {
                document.getElementById("manage-accounts-link").click();
            }
        })
        .catch((error) => {
            // Affiche un message d'erreur
            responseMessage.style.color = "red";
            responseMessage.textContent = error.message;
        });
}
