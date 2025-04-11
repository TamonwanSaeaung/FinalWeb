<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "seller") {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];
$conn->query("DELETE FROM products WHERE id = $id");

header("Location: dashboard_seller.php");
exit;
