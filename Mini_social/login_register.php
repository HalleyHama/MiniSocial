<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription - Application Sociale</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <!-- Login Form -->
            <div id="login-form-container">
                <div class="login-header">
                    <div class="login-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                    </div>
                    <h1>Bienvenue</h1>
                    <p>Connectez-vous pour continuer</p>
                </div>
                <div id="error-message" style="color: red; text-align: center;">
                    <?php
                        if(isset($_SESSION['error'])){
                            echo htmlspecialchars($_SESSION['error']);
                            unset($_SESSION['error']);
                        }
                    ?>
                </div>
                <form class="login-form" method="POST" action="login.php">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" id="username" name="email" placeholder="Entrez votre nom" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn-primary">Se connecter</button>
                    
                    <div class="login-footer">
                        <a href="#" id="show-register">Créer un compte</a>
                    </div>
                </form>
            </div>

            <!-- Register Form -->
            <div id="register-form-container" style="display: none;">
                <div class="login-header">
                    <div class="login-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z"></path>
                            <path d="M6 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"></path>
                        </svg>
                    </div>
                    <h1>Créer un compte</h1>
                    <p>Rejoignez notre communauté</p>
                </div>
                <div class="register_error">
                    <?php
                        if(isset($_SESSION['error_register'])){
                            echo '<p style="color: red; text-align: center;">' .htmlspecialchars($_SESSION['error_register']). '</p>';
                            echo '<script>
                                    document.getElementById("login-form-container").style.display = "none";
                                    document.getElementById("register-form-container").style.display = "block";
                                </script>';
                            unset($_SESSION['error_register']);
                        }
                        else if(isset($_SESSION['confirm_mail'])){
                            echo '<p style="color: green; text-align: center;">' .htmlspecialchars($_SESSION['confirm_mail']). '</p>';
                            echo '<script>
                                    document.getElementById("login-form-container").style.display = "none";
                                    document.getElementById("register-form-container").style.display = "block";
                                </script>';
                            unset($_SESSION['confirm_mail']);
                        }
                    ?>
                </div>

                <form class="register-form" method="POST" action="register.php" >
                    <div class="form-group">
                        <label>Nom d'utilisateur</label>
                        <input type="text" id="reg-username" name="reg-username" placeholder="Entrez votre nom" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="reg-email" name="reg-email" placeholder="Entrez votre email" required>
                    </div>

                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" id="reg-password" name="reg-password" placeholder="••••••••" required>
                    </div>

                    <div class="form-group">
                        <label>Confirmer le mot de passe</label>
                        <input type="password" id="reg-password-confirm" name="reg-password-confirm" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn-primary">S'inscrire</button>
                    
                    <div class="login-footer">
                        <a href="#" id="show-login">Déjà un compte ? Connectez-vous</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('login-form-container');
        const registerForm = document.getElementById('register-form-container');

        const showRegisterLink = document.getElementById('show-register');
        const showLoginLink = document.getElementById('show-login');

        const password_register = document.getElementById('reg-password').value;
        const passwordConfirm = document.getElementById('reg-password-confirm').value;

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Basculer vers le formulaire d'inscription
        showRegisterLink.addEventListener('click', (e) => {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });

        // Basculer vers le formulaire de login
        showLoginLink.addEventListener('click', (e) => {
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        });

        // Validation du mot de passe lors de l'inscription
        function  handleRegister(){
            const password_register = document.getElementById('reg-password').value;
            const passwordConfirm = document.getElementById('reg-password-confirm').value;
            if(password_register !== passwordConfirm){
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }
            else{
                alert("Infos envoyées avec succès !");
                return true;
            }
        }


    </script>
</body>
</html>

