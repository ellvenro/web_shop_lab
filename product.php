<?php
include "src/source.php";
?>

<html>
  <head>
    <title>Товар</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="css/styles_product.css">
    <link rel="stylesheet" href="css/styles_modal.css">
  </head>
  <body>
    <?php
    //Форма регистрации/авторизации
    modal($induction);
    //Заголовок
    head();
    ?>

    <?php
      $result = mysqli_query($induction, "SELECT Товары.Название, Товары.Описание, Товары.Стоимость, Типы.Тип, Производители.Производитель, Производители.Сайт, Товары.Фото FROM Производители INNER JOIN (Типы INNER JOIN Товары ON Типы.КодТТ = Товары.КодТТ) ON Производители.КодП = Товары.КодП WHERE Товары.КодТ=" . $_GET["Товар"]);
      $srting = mysqli_fetch_assoc($result)
    ?>
    <h1><?php echo $srting["Название"]; ?></h1>
    <div class="block product">
      <div class="cont_imgs" id="product_imgs" style=background-image:url('/img/<?php echo $srting["Фото"]?>')></div>
      <div class="information product_inf">
        <p><b>ОПИСАНИЕ:</b> <?php echo $srting["Описание"]; ?>
        <hr>
        <p><b>СТОИМОСТЬ:</b> <?php echo $srting["Стоимость"]; ?> ₽
        <hr>
        <p><b>ТИП ТОВАРА:</b> <?php echo $srting["Тип"]; ?>
        <hr>
        <p><b>ПРОИЗВОДИТЕЛЬ:</b> <?php echo $srting["Производитель"]; ?>
        <hr>
        <p><b>САЙТ ПРОИЗВОДИТЕЛЯ: </b><a href=<?php echo $srting["Сайт"]; ?>><?php echo $srting["Сайт"]; ?></a>
      </div>
      <form method="post" class="button_basket">
        <button type="submit" name="button_basket">В корзину</button>
      </form>
      <?php
        if(isset($_POST[button_basket]))
        {
          mysqli_query($induction, "INSERT INTO `корзинабуф`(`КодТ`) VALUES (" . $_GET["Товар"] . ")");
        }
      ?>
    </div>

    <footer>
      <a href="https://github.com/ellvenro">© 2023 ellvenro</a>
    </footer>

    <script type="text/javascript" src="js\scripts.js"></script>

  </body>
</html>
