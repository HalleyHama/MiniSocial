<?php
    require_once 'config.php';
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $user = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$user]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password_hash'])){
            session_start();
            $_SESSION['username'] = $user["username"];
            header("Location: main/dashboard.php");
            exit();
        }
        else{
            session_start();
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            header("Location: login_register.php"); 
            exit();
        }
    }
?>