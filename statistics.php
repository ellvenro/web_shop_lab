<?php
include "src/source.php";
?>

<html>
  <head>
    <title>Статистика</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_modal.css">
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="css\styles_statistics.css">
  </head>
  <body>

    <?php
    //Форма регистрации/авторизации
    modal($induction);
    //Заголовок
    head();
    ?>

    <!--Посещение сайта-->
    <h1>Посещение сайта</h1>
    <div id=content>
      <?php
      $result = mysqli_query($induction, "SELECT Вход, Пользователь FROM Статистика");
      $srting = mysqli_fetch_assoc($result);
      ?>
      <article class=block>
        <div>Посетителей:</div>
        <div class=number><?php echo $srting["Вход"];?></div>
      </article>
      <article class=block>
        <div>Зарегестированных пользователей:</div>
        <div class=number><?php echo (int)((int)$srting["Пользователь"] * 100 / (int)$srting["Вход"]);?> %</div>
      </article>
    </div>

    <footer>
      <a href="https://github.com/ellvenro">© 2023 ellvenro</a>
    </footer>

    <script type="text/javascript" src="js\scripts.js"></script>
  </body>
</html>
