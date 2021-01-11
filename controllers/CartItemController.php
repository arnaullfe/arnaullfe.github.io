<?php
include_once ('../modals/CartItem.php');
include_once ('../modals/Database.php');
include_once ('./MainController.php');

if(isset($_POST["product_id_addCart"])){
    if(!isset($_SESSION["user_id"])){
        header("location: ../pages/admin_view/login.php");
    } else{
        $database = new Database();
        $cartItems = $database->executeQuery("SELECT * FROM cartItems WHERE cart_id = (SELECT id FROM carts WHERE user_id=? ) AND product_id = ?",array($_SESSION["user_id"],$_POST["product_id_editCart"]));
        if(count($cartItems)>0){
            $database->executeQuery("UPDATE cartItems SET units=? WHERE id=?",array($_POST["units_addCart"],$cartItems[0]["id"]));
        }else{
            $database->executeQuery("INSERT INTO cartItems (cart_id,product_id,units,created_at) VALUES ((SELECT id FROM carts WHERE user_id=?))",array($_SESSION["user_id"],$_POST["product_id_editCart"],$_POST["units_editCart"],getCurrentDateTime()));
        }
        $cartId = $database->executeQuery('SELECT id FROM carts WHERE user_id=?',array($_SESSION["user_id"]));
        header("location: ../pages/botiga_view/cart.php?cart_id=".$cartId);
    }

}

if(isset($_POST["product_id_editCart"])){
    $error = false;
    if(!isset($_SESSION["user_id"]) ){
        header("location: ../pages/admin_view/login.php");
    } else{
        $database = new Database();
        $cartItems = $database->executeQuery("SELECT * FROM cartItems WHERE cart_id = (SELECT id FROM carts WHERE user_id=? ) AND product_id = ?",array($_SESSION["user_id"],$_POST["product_id_editCart"]));
        if(count($cartItems)>0){
            $units = $cartItems[0]["units"] + $_POST["units_editCart"];
            if(checkUnits($_POST["product_id_editCart"],$units)==true){
                $database->executeQuery("UPDATE cartItems SET units=? WHERE id=?",array($units,$cartItems[0]["id"]));
            }else{
                $error= true;
            }
        }else{
            if(checkUnits($_POST["product_id_editCart"],$_POST["units_editCart"])==true){
                $database->executeQuery("INSERT INTO cartItems (cart_id,product_id,units,created_at) VALUES ((SELECT id FROM carts WHERE user_id=?),?,?,?)",array($_SESSION["user_id"],$_POST["product_id_editCart"],$_POST["units_editCart"],getCurrentDateTime()));
            }else{
                $error= true;
            }
        }
        if($error==false){
            $cartId = $database->executeQuery('SELECT id FROM carts WHERE user_id=?',array($_SESSION["user_id"]));
            header("location: ../pages/botiga_view/cart.php?cart_id=".$cartId[0]["id"]);
        } else{
            $units_product = $database->executeQuery("SELECT units FROM products WHERE id = ?",array($_POST["product_id_editCart"]));
            $_SESSION["error_message"] = "<strong>Error!</strong>No hi ha prous unitats, pots afegir màxim ".$units_product[0]['units']." unitats";
            header("location: ../pages/botiga_view/cart.php?product_id=".$_POST["product_id_editCart"]);
        }
        $database->closeConnection();
    }
}

function checkUnits($product_id,$units){
    $database = new Database();
    $units_product = $database->executeQuery("SELECT units FROM products WHERE id=?",array($product_id));
    $database->closeConnection();
    if(count($units_product)>0 && $units_product[0]["units"]>=$units){
        return true;
    }
    return false;
}