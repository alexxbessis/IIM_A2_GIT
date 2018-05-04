<?php
require('config/config.php');
require('model/functions.fn.php');
session_start();

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) &&
    !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);

    if (isUsernameAvailable($db, $username)) {
        if (isEmailAvailable($db, $email)) {
            userRegistration($db, $username, $email, $passwordEncrypted);

            userConnection($db, $email, $password);

            if (userConnection($db, $email, $password)) {
                header('Location: dashboard.php');
            } else {
                $error = "Identifiants Incorrects";
            }
        } else {
            $error = "L'e-mail n'est pas disponible";
        }
    } else {
        $error = "Nom d'utilisateur indisponible";
    }


} else {
    $_SESSION['message'] = 'Le formulaire est incomplet';
    header('Location: register.php');
}