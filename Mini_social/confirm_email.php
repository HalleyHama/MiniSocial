<?php
require_once 'config.php';
// Fonction pour afficher le message dans un style simple et propre
function showMessage($title, $message, $success = true) {
    $color = $success ? "#4CAF50" : "#F44336"; // vert = succès, rouge = erreur
    echo "
    <!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Vérification du compte</title>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                display: flex; 
                justify-content: center; 
                align-items: center; 
                height: 100vh; 
                background: #f4f4f4; 
            }
            .box {
                background: #fff;
                padding: 30px 40px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 400px;
            }
            h1 { color: $color; }
            p { font-size: 16px; margin-top: 10px; }
            a {
                display: inline-block;
                margin-top: 20px;
                text-decoration: none;
                color: #fff;
                background: #2196F3;
                padding: 10px 20px;
                border-radius: 5px;
            }
            a:hover { background: #1976D2; }
        </style>
    </head>
    <body>
        <div class='box'>
            <h1>$title</h1>
            <p>$message</p>
            <a href='login.php'>Se connecter</a>
        </div>
    </body>
    </html>
    ";
    exit;
}
if (!isset($_GET['token'])) {
    die("Token manquant");
    showMessage("Erreur", "Token manquant.", false);
}

$token = $_GET['token'];

// Récupérer le token et sa date d'expiration
$stmt = $pdo->prepare("SELECT id, token_expires_at FROM utilisateurs WHERE token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("Lien invalide");
    showMessage("Erreur", "Lien invalide", false);
}

// Vérifier expiration
$current_time = date("Y-m-d H:i:s");
if ($current_time > $user['token_expires_at']) {
    die("Ce lien a expiré");
    showMessage("Erreur", "Ce lien a expiré", false);
}

// Activer le compte
$pdo->prepare("UPDATE users SET is_verified = 1, token = NULL, token_expires_at = NULL WHERE id = ?")
    ->execute([$user['id']]);

// Redirection après succès
header("Location: login.php?confirmed=1");
exit;

?>