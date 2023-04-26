<?php
include "src/source.php";
?>

<html>
  <head>
    <title>Корзина</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_modal.css">
    <link rel="stylesheet" href="css/styles_basket.css">
  </head>
  <body>

    <?php
    //Форма регистрации/авторизации
    modal($induction);
    //Заголовок
    head();
    //Удаление из корзины
    if (isset($_POST[button_reset])) {
      mysqli_query($induction, "DROP TABLE КорзинаБуф");
      mysqli_query($induction, "CREATE TABLE корзинабуф (КодТ INT) ENGINE = MEMORY");
      unset($_SESSION[Корзина]);
      header('Location:index.php');
    }
    ?>
    <div style="min-height:65%">
    <table id=table_basket>
      <?php
      $sum = 0;
      $result = mysqli_query($induction, "SELECT * FROM КорзинаБуф");
      if (mysqli_num_rows($result) != 0) {
        while ($srting = mysqli_fetch_assoc($result)) {
          $result2 = mysqli_query($induction, "SELECT Название, Стоимость, Фото FROM Товары WHERE КодТ='" . $srting["КодТ"] . "'");
          while ($srting2 = mysqli_fetch_assoc($result2)) {
            ?>
            <tr>
              <td class="td_img">
                <img class="img_basket" src="img/<?php echo $srting2["Фото"]?>"></img>
              </td>
              <td>
                <a href="product.php?Товар=<?php echo $srting["КодТ"]?>"><?php echo $srting2["Название"]?></a>
                <br>
                <?php echo $srting2["Стоимость"]?> ₽
              </td>
            </tr>
            <?php
            $sum += (int)$srting2["Стоимость"];
          }
        }
      }
      else {
        echo "<tr colspan=2 class=tr_final style=text-align:center><td>Корзина пуста</td></tr>";
      }
      ?>
      <tr class="tr_final">
        <td colspan="2">
          Общая стоимость: <?php echo $sum; ?> ₽
        </td>
      </tr>
      <tr class="tr_final">
        <td colspan="2">
          <form method="post">
            <button type="submit" name=button_reset>Отчистить корзину</button>
            <?php
            if (isset($_SESSION[Клиент])){
              echo "<button name=button_order>Заказ</button>";
            }
            else {
              echo "<button name=button_order2 disabled=disabled title='Произведите вход в личный кабинет'>Заказ</button>";
            }
            if (isset($_POST[button_order])) {
              mysqli_query($induction, "INSERT INTO Корзина ( КодК, Дата, КодТ ) SELECT " . $_SESSION["Клиент"] . ", '" . date('y-m-j') . "', КорзинаБуф.КодТ FROM КорзинаБуф");
              mysqli_query($induction, "DROP TABLE КорзинаБуф");
              mysqli_query($induction, "CREATE TABLE корзинабуф (КодТ INT) ENGINE = MEMORY");
              header('Location:cabinet.php');
            }
            ?>
          </form>
        </td>
      </tr>
    </table>
    </div>
    <br>

    <footer>
      <a href="https://github.com/ellvenro">© 2023 ellvenro</a>
    </footer>

    <script type="text/javascript" src="js\scripts.js"></script>
  </body>
</html>
