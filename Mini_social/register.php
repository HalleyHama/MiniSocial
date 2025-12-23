<?php
    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception; 
    require 'vendor/autoload.php'; 
    require_once "config.php";
    $mail = new PHPMailer(true);
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $username = trim($_POST["reg-username"]);
        $email = trim($_POST["reg-email"]);
        $password = $_POST["reg-password"];
        $confirm_password = $_POST["reg-password-confirm"];
       if($password !== $confirm_password){
            session_start();
            $_SESSION['error_register'] = "Les mots de passe ne correspondent pas.";
            header("Location: login_register.php");
            exit();
        }
        $token = bin2hex(random_bytes(16));
        $token_expires_at = date("Y-m-d H:i:s", strtotime('10 minutes'));
        $link = "https://dionne-unfenestrated-overbounteously.ngrok-free.dev/Mini_social/confirm_email.php?token=$token";

        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->rowCount() > 0){
            session_start();
            $_SESSION['error_register'] = "L'email est déjà utilisé.";
            header("Location: login_register.php");
            exit();
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO utilisateurs(username, email, password_hash, token, token_expires_at) VALUES(?, ?, ?, ?, ?)");
        $insert->execute([$username, $email, $password_hash, $token, $token_expires_at]);

        session_start();

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'socialapp1443@gmail.com';
        $mail->Password = 'eqlxsvykjskbofjk'; // mot de passe d'application sans espaces
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->isHTML(true);
        $mail->setFrom('socialapp1443@gmail.com', 'Social App'); // même que Username
        $mail->addAddress($email, $username);
        $mail->Subject = 'Merci de confirmer votre mail';
        $mail->Body    = "<p>Bonjour $username,</p>
                            <p>Merci de vous être inscrit sur notre application sociale. Veuillez cliquer sur le lien ci-dessous pour confirmer votre adresse e-mail :</p>
                            <a href='$link'>Confirmer mon email</a>
                            <p>Si vous n'avez pas créé de compte, veuillez ignorer cet e-mail.</p>
                            <p>Cordialement,<br>L'équipe Social App</p>
                        ";
        $mail->Altbody = "Bonjour $username,\n\nMerci de vous être inscrit sur notre application sociale. Veuillez cliquer sur le lien ci-dessous pour confirmer votre adresse e-mail :\n\n$link\n\nSi vous n'avez pas créé de compte, veuillez ignorer cet e-mail.\n\nCordialement,\nL'équipe Social App";

        $mail->send();

        $_SESSION['confirm_mail'] = "Un email de confirmation a été envoyé à $email. Veuillez vérifier votre boîte de réception.";
        header("Location: login_register.php");
        exit();

    } catch (Exception $e) {
        echo "Erreur : {$mail->ErrorInfo}";
    }
    }

?>
