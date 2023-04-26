<?php
include "src/source.php";
?>

<html>
  <head>
    <title>Информация</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_contacts.css">
    <link rel="stylesheet" href="css/styles_modal.css">
  </head>
  <body>

    <?php
    //Форма регистрации/авторизации
    modal($induction);
    //Заголовок
    head();
    ?>

    <h1>О компании</h1>

    <div style=overflow:hidden>
      <div class=img>
        <img src="/img/logo.png" width="100%"></img>
      </div>
      <div class=pod>
        <p>Компьютерный магазин осуществляет продажу компьютерной техники различных производителей. В магазине могут продаваться различные типы компьютерной техники, такие как настольные компьютеры, ноутбуки, как игровые, так и офисные, планшеты и др. Магазин работает с различными производителями, осуществляет продажу товаров, ориентированных на разные ценовые сегменты. В магазине работают сотрудники, обеспечивающие непосредственную работу с клиентами.
      </div>
    </div>

    <h1>Контакты</h1>
    <div class="information">
      <p><b>TЕЛЕФОН:</b> +7(913) 829-6753
      <hr>
      <p><b>АДРЕС:</b> г. Санкт-Петербург, ул. Ленина, д. 10
      <hr>
      <p><b>E-MAIL:</b> new@yandex.ru
      <hr>
      <p><b>РЕЖИМ РАБОТЫ:</b>
      <p>Пн - Пт: с 10.00 до 19.00 без обеда
      <p>Сб, Вс: Выходные дни
    </div>

    <form action="mailto:lidiya.ellie@yandex.ru" method="post" id=form_action>
      <fieldset>
        <legend>Отправить письмо</legend>
        Введите почту: <input type="email"></input><br>
        <textarea name="textarea" id="textarea"></textarea><br><br>
        <div style="text-align:right"><button type="submit">Отправить</button></div>
      </fieldset>
    </form>

    <footer>
      <a href="https://github.com/ellvenro">© 2023 ellvenro</a>
    </footer>

    <script type="text/javascript" src="js\scripts.js"></script>
  </body>
</html>
