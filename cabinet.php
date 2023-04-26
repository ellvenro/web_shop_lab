<?php
include "src/source.php";
?>

<html>
  <head>
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="css\styles_cabinet.css">
  </head>
  <body>
    <?php
    head();
    if (isset($_POST[button_red])) {
      mysqli_query($induction, "UPDATE клиенты SET Фамилия='$_POST[newsurname]', Имя='$_POST[newname]', Телефон='$_POST[newtel]' WHERE КодК=" . $_SESSION["Клиент"]);
    }
    if (isset($_POST[button_remove])) {
      mysqli_query($induction, "DELETE FROM `корзина` WHERE КодК=" . $_SESSION["Клиент"]);
    }
    $result = mysqli_query($induction, "SELECT Имя, Фамилия, Телефон, Дата FROM Клиенты WHERE КодК=" . $_SESSION["Клиент"]);
    $srting = mysqli_fetch_assoc($result);
    ?>

    <!--Личная информация-->
    <h1>Личные данные</h1>
    <div class="information">
      <form method="post" style=text-align:right>
        <table class="prof">
          <tr>
            <td class="line"><p><b>ФАМИЛИЯ:</b> <?php echo $srting["Фамилия"]; ?></td>
            <td class="opacity none"><input type="text" name="newsurname" value="<?php echo $srting["Фамилия"]; ?>"></td>
          </tr>
          <tr>
            <td class="line"><p><b>ИМЯ:</b> <?php echo $srting["Имя"]; ?></td>
            <td class="opacity none"><input type="text" name="newname" value="<?php echo $srting["Имя"]; ?>"></td>
          </tr>
          <tr>
            <td class="line"><p><b>ТЕЛЕФОН:</b> <?php echo $srting["Телефон"]; ?></td>
            <td class="opacity none"><input type="text" name="newtel" value="<?php echo $srting["Телефон"]; ?>"></td>
          </tr>
          <tr>
            <td class="line"><p><b>ДАТА РЕГИСТРАЦИИ:</b> <?php echo date("d.m.Y", strtotime($srting["Дата"])); ?></td>
          </tr>
        </table>
        <div style=text-align:right>
          <button name="button_exit" style="font-size:1em">Выход</button>
          <button type="button" id="btn_red" style="font-size:1em">Редактировать</button>
          <button class="red none" name="button_red" style="font-size:1em">Редактировать</button>
        </div>
      </form>
      <?php
        if (isset($_POST[button_exit])) {
          session_unset();
          session_destroy();
          mysqli_query($induction, "DROP TABLE КорзинаБуф");
          $_SESSION["Пользователь"] = "Нет";
          header('Location:index.php');
        }
      ?>
    </div>

    <!--Покупки-->
    <h1>История покупок</h1>
    <div id=content>
      <?php
      $result = mysqli_query($induction, "SELECT Товары.Название, Товары.Стоимость, Товары.Фото, Корзина.Дата FROM Товары INNER JOIN Корзина ON Товары.КодТ = Корзина.КодТ WHERE Корзина.КодК=" . $_SESSION["Клиент"] . " ORDER BY Корзина.Дата");
      if (mysqli_num_rows($result) != 0) {
        while ($srting = mysqli_fetch_assoc($result))
        {
          echo "<article class=block>";
          echo "<div class=cont_imgs style=background-image:url('/img/" . $srting["Фото"] . "')></div>";
          echo "<div class=cont_text>Стоимость: " . $srting["Стоимость"] . "  ₽<br>";
          echo "Название: " . $srting["Название"] . "<br>Дата заказа: " . date("d.m.Y", strtotime($srting["Дата"])) . "</div>";
          echo "</article>";
        }
      }
      else {
        echo "<div><p>Покупок нет<br><br></div>";
      }
      ?>
      <form method="post" style="width:100%;">
        <div style=text-align:right>
          <button name="button_remove" style="font-size:1em">Удалить историю</button>
        </div>
      </form>
    </div>

    <footer>
      <a href="https://github.com/ellvenro">© 2023 ellvenro</a>
    </footer>
    <script type="text/javascript" src="js\scripts_cabinet.js"></script>
  </body>
</html>
