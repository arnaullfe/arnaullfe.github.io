<?php
include_once("../controllers/MainController.php");
include_once("../modals/Database.php");
include_once("../modals/User.php");
session_start();

if (isset($_POST["name_register"])) {
    unset($_SESSION["register_errors"]);
    unset($_SESSION["name_register"]);
    unset($_SESSION["lastnames_register"]);
    unset($_SESSION["email_register"]);
    unset($_SESSION["password_register"]);
    $vars = array(
        "data" => array($_POST["name_register"], $_POST["lastnames_register"], $_POST["email_register"], $_POST["password_register"], $_POST["password_confirm_register"], $_POST["g-recaptcha-response"]),
        "names" => array("name_register", "lastnames_register", "email_register", "password_register", "password_confirm_register", "recaptcha_register")
    );
    $errors = checkPostRequest($vars);
        $database = new Database();
        if (checkOnlyLetters($_POST["name_register"]) == false) {
            array_push($errors, "error_name_register");
        }

        if (checkOnlyLetters($_POST["lastnames_register"]) == false) {
            array_push($errors, "error_lastnames_register");
        }
        $num_emails = $database->executeQuery("SELECT count(*) as num FROM users WHERE email LIKE ?",array($_POST["email_register"]))[0]["num"];
        if (checkEmail($_POST["email_register"]) == false || $num_emails>0) {
            array_push($errors, "error_email_register");
        }

        if ($_POST["password_register"] < 5) {
            array_push($errors, "error_password_register");
        }

        if (comparePasswords($_POST["password_register"], $_POST["password_confirm_register"])) {
            array_push($errors, "error_password_confirm_register");
        }

        if (count($errors) == 0) {
            $user = new User($_POST["name_register"],$_POST["lastnames_register"],$_POST["email_register"],password_hash($_POST["password_register"],PASSWORD_DEFAULT));
            //insert
        } else{
            $_SESSION["register_errors"] = $errors;
            $_SESSION["name_register"] = $_POST["name_register"];
            $_SESSION["lastnames_register"] = $_POST["lastnames_register"];
            $_SESSION["email_register"] = $_POST["email_register"];
            $_SESSION["password_register"] = $_POST["password_register"];
            header("location: ../pages/admin_view/register.php");   
        }
}
