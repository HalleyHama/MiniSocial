<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_GET['confirmed']) && $_GET['confirmed'] == 1){
            echo "<p style='color: green; text-align: center;'>Votre adresse e-mail a été confirmée avec succès. Vous pouvez maintenant utiliser toutes les fonctionnalités du tableau de bord.</p>";
        }
        else{
            echo "<p style='text-align: center;'>Bienvenue sur votre tableau de bord.</p>";
        }
    ?>
</body>
</html>
