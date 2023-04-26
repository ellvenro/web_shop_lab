<?php
include "src/source.php";
?>

<html>
  <head>
    <title>Каталог</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="css/styles_modal.css">
  </head>
  <body>

    <?php
    //Форма регистрации/авторизации
    modal($induction);
    //Заголовок
    head();
    ?>

    <!--Контент-->
    <form method="post" style=overflow:hidden>
      <!--Фильтр-->
      <div class=filter>
        <h1>Фильтр</h1>

          <fieldset>
            <legend>Тип</legend>
              <?php
                //Если кнопка сброса фильтра, отчистить _POST
                if (isset($_POST["button_reset"]))
                {
                  unset($_POST);
                }
                if (isset($_POST["btn_busket"])) {
                  if (isset($_POST["Корзина"])) {
                    //$_SESSION["Корзина"] = $_POST["Корзина"];
                    foreach ($_POST["Корзина"] as $key => $value) {
                      mysqli_query($induction, "INSERT INTO `корзинабуф`(`КодТ`) VALUES (" . $value . ")");
                    }
                  }
                }
                //Заполнение типов - чекбоксы
                types($induction);
              ?>
          </fieldset>
          <fieldset>
            <legend>Производитель</legend>
              <?php
                //Заполнение производителей - чекбоксы
                manufacturers($induction);
              ?>
          </fieldset>
          <button type="submit" class="btn_filt" name=btn_busket>В корзину</button>
          <button type="submit" class="btn_filt" name=button_filter>Применить</button>
          <button type="submit" class="btn_filt" name=button_reset>Сбросить</button>
      </div>

      <!--Каталог-->
      <div class=catalog>
        <h1>Каталог</h1>
        <div id=content>
          <?php
            //Если нажата кнопка фильтра
            if (isset($_POST["button_filter"]))
            {
              $result = filter($induction);
            }
            else
            {
              $result = mysqli_query($induction, "SELECT КодТ, Название, Стоимость, Фото FROM Товары");
            }
            //Вывод каталога
            while ($srting = mysqli_fetch_assoc($result))
            {
              echo "<article class=block>";
              echo "<div class=cont_imgs style=background-image:url('/img/" . $srting["Фото"] . "')></div>";
              echo "<div class=cont_text>" . $srting["Стоимость"] . "  ₽<br>";
              echo "<a title='Информация о товаре' href='product.php?Товар=" . $srting["КодТ"]  . "'>" . $srting["Название"] . "</a></div>";
              echo "<div class=cont_count>";
              $str = "";
              $resultk = mysqli_query($induction, "SELECT * FROM КорзинаБуф");
              while ($srtingk = mysqli_fetch_assoc($resultk)) {
                if ($srtingk["КодТ"] == $srting["КодТ"]) {
                  $str = " checked='checked'";
                  break;
                }
              }
              echo "<input type='checkbox'" . $str . " name='Корзина[]' value=" . $srting["КодТ"] . "> В корзину<br/>";
              echo "</div></article>";
            }
          ?>
        </div>
      </div>
    </form>

    <footer>
      <a href="https://github.com/ellvenro">© 2023 ellvenro</a>
    </footer>

    <script type="text/javascript" src="js\scripts.js"></script>

  </body>
</html>
