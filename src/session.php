<?php
include "src/database.php";

session_start();

if (!isset($_SESSION["Вход"])) {
  //обновление статистики посетителей
  mysqli_query($induction, "UPDATE `Статистика` SET `Вход` = `Вход` + 1");
  $_SESSION["Вход"] = "Да";
}
//Таблица для хранения корзины
mysqli_query($induction, "CREATE TABLE корзинабуф (КодТ INT) ENGINE = MEMORY");
?>
