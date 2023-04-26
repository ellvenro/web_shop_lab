<?php
include "src/database.php";
include "src/session.php";

//Заполнение типов
function types( $induction) {
  $result = mysqli_query($induction, "SELECT КодТТ, Тип FROM Типы ORDER BY Тип");
  $i = 0;
  while ($srting = mysqli_fetch_assoc($result))
  {
    $str = "";
    if (isset($_POST["Тип"]))
      foreach ($_POST["Тип"] as $key => $value) {
        if ($value == $srting["КодТТ"]) {
          $str = " checked='checked'";
          break;
        }
      }
    echo "<input type='checkbox'" . $str . " name='Тип[]' value=" . $srting["КодТТ"] . ">" . $srting["Тип"] . "<br/>";
    $i++;
  }
}

//Заполнение производителей
function manufacturers($induction){
  $result = mysqli_query($induction, "SELECT КодП, Производитель FROM Производители ORDER BY Производитель");
  $i = 0;
  while ($srting = mysqli_fetch_assoc($result))
  {
    $str = "";
    if (isset($_POST["Производитель"]))
      foreach ($_POST["Производитель"] as $key => $value) {
        if ($value == $srting["КодП"]) {
          $str = " checked='checked'";
          break;
        }
      }
    echo "<input type='checkbox'" . $str . "name='Производитель[]' value=" . $srting["КодП"] . ">" . $srting["Производитель"] . "<br/>";
    $i++;
  }
}

//Фильтр
function filter($induction){
  //Фильтр по типам
  $types = "";
  if (isset($_POST["Тип"])) {
    foreach ($_POST["Тип"] as $key => $value) {
      $types = $types . "КодТТ=" . $value . " OR ";
    }
    $types = substr($types, 0, -3 );
  }
  //Фильтр по производителям
  $manufacturer = "";
  if (isset($_POST["Производитель"])) {
    foreach ($_POST["Производитель"] as $key => $value) {
      $manufacturer = $manufacturer . "КодП=" . $value . " OR ";
    }
    $manufacturer = substr($manufacturer, 0, -3 );
  }
  if ($types == "" && $manufacturer == "")
    $result = mysqli_query($induction, "SELECT КодТ, Название, Стоимость, Фото FROM Товары");
  else if ($types == "")
    $result = mysqli_query($induction, "SELECT КодТ, Название, Стоимость, Фото FROM Товары WHERE (" . $manufacturer . ")");
  else if ($manufacturer == "")
    $result = mysqli_query($induction, "SELECT КодТ, Название, Стоимость, Фото FROM Товары WHERE (" . $types . ")");
  else
    $result = mysqli_query($induction, "SELECT КодТ, Название, Стоимость, Фото FROM Товары WHERE (" . $types . ") AND (" . $manufacturer . ")");
  return $result;
}

//Форма регистрации/авторизации
function modal($induction) {
  ?>
  <!-- Форма регистрации -->
  <div class="modal">
    <div class="modal-content">
      <form method="post">
        <table id=table>
          <!--Невидимые поля-->
          <tr class="opacity none">
            <td class="opacity none">Фамилия:</td>
            <!--<td><input type="text" name="surname" class="opacity none" maxlength="30"></td>-->
            <td><input type="text" name="surname" class="opacity none pole"></td>
          </tr>
          <tr class="opacity none">
            <td class="opacity none">Имя:</td>
            <td><input type="text" name="name" class="opacity none pole" maxlength="20"></td>
          </tr>
          <tr class="opacity none">
            <td class="opacity none">Телефон:</td>
            <td><input type="text" name="phone" class="opacity none pole" maxlength="20"></td>
          </tr>
          <!---->
          <tr>
            <td>Логин:</td>
            <td><input required type="text" name="login" class="pole" maxlength="20"></td>
          </tr>
          <tr>
            <td>Пароль:</td>
            <td><input required type="password" name="parol" class="pole" maxlength="20"></td>
          </tr>
          <tr>
            <td colspan="3">
                <img class="captcha__image" src="img/captcha.png" width="132" alt="captcha">
            </td>
          </tr>
          <tr>
            <td>
                Код:
            </td>
            <td>
                <input required type="text" name="Капча">
            </td>
          </tr>
          <tr>
            <td colspan="3" style="text-align:right">
              <button type="submit" name="button_avt" id="button_avt">Войти</button>
              <button type="button" id="button_reg">Зарегестрироваться</button>
              <button type="submit" name="button_reg_2" id="button_reg_2" style="opacity:0">Регистация</button>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <?php
  //Кнопка входа
  if (isset($_POST[button_avt])) {
    if ($_POST["Капча"] != $_SESSION["Капча"])
      echo "<script>alert('Подтвердите, что вы не робот');</script>";
    else {
      //Если введены данные
      if ($_POST["login"] != "" && $_POST["parol"] != "") {
        //Экранирование (защита от SQL-инъекций)
          $_POST["login"] = $induction->real_escape_string($_POST["login"]);
          $_POST["parol"] = $induction->real_escape_string($_POST["parol"]);

          //вход администратора
          if ($_POST["login"] == "admin" && $_POST["parol"] = "1234")
            header('Location:admin.php?Админ=Заказы');
          else {
            $result = mysqli_query($induction, "SELECT КодК FROM Клиенты WHERE Логин='" . $_POST["login"] . "' AND Пароль='" . $_POST["parol"] . "'");
            $srting = mysqli_fetch_assoc($result);
            if (isset($srting)) {
              $_SESSION["Клиент"] = $srting["КодК"];
              if ($_SESSION["Пользователь"] != "Да") {
                //обновление статистики входов
                mysqli_query($induction, "UPDATE `Статистика` SET `Пользователь` = `Пользователь` + 1");
                $_SESSION["Пользователь"] = "Да";
              }
            }
            else {
              echo "<script>alert('Неверное имя пользователя или пароль');</script>";
            }
          }
        }
      else {
        echo "<script>alert('Введите данные');</script>";
      }
    }
    captcha();
  }
  //Кнопка регистрации
  if (isset($_POST[button_reg_2])) {
    if ($_POST["Капча"] != $_SESSION["Капча"])
      echo "<script>alert('Подтвердите, что вы не робот');</script>";
    else {
    //Если введены данные
      if ($_POST["surname"] != "" && $_POST["name"] != "" && $_POST["phone"] != "" && $_POST["login"] != "" && $_POST["parol"] != "")
      {
        //Экранирование (защита от SQL-инъекций)
        $_POST["surname"] = $induction->real_escape_string($_POST["surname"]);
        $_POST["name"] = $induction->real_escape_string($_POST["name"]);
        $_POST["phone"] = $induction->real_escape_string($_POST["phone"]);
        $_POST["login"] = $induction->real_escape_string($_POST["login"]);
        $_POST["parol"] = $induction->real_escape_string($_POST["parol"]);

        $result = mysqli_query($induction, "SELECT КодК FROM Клиенты WHERE Логин='" . $_POST["login"] . "' AND Пароль='" . $_POST["parol"] . "'");
        $srting = mysqli_fetch_assoc($result);
        //Если логина и пароля не существует
        if (!isset($srting)) {
          mysqli_query($induction, "INSERT INTO `клиенты`(`КодК`, `Фамилия`, `Имя`, `Телефон`, `Дата`, `Логин`, `Пароль`)
          VALUES (NULL,'" . $_POST["surname"] . "','" . $_POST["name"] . "','" . $_POST["phone"] . "','" . date('y-m-j') . "','" . $_POST["login"] . "','" . $_POST["parol"] . "')");
        }
        else {
          echo "<script>alert('Логин или пароль уже существует');</script>";
        }
      }
      else {
        echo "<script>alert('Введите данные');</script>";
      }
    }
  }
  captcha();
}

//Заголовок
function head() {
  ?>
  <header>
    <div style=overflow:hidden>
      <div class=head>
        Computer store
      </div>
      <div class=reg>
        <?php
        if (isset($_SESSION["Клиент"]))
          echo "<a href='cabinet.php' style='border-right:1px solid var(--color-grey);padding-right:0.5em'>Личный кабинет</a>";
        else
          echo "<a id='myBtn' style='border-right:1px solid var(--color-grey);padding-right:0.5em'>Вход</a>";
        ?>
        <a href="basket.php">Корзина</a>
      </div>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Каталог</a></li>
        <li><a href="statistics.php">Статистика</a></li>
        <li><a href="contacts.php">Информация</a></li>
      </ul>
    </nav>
  </header>
  <?php
}

//Проверка на робота
function captcha() {
  //Символы, из которых будет составляться код капчи
  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
  //Количество символов в капче
  $length = 6;
  //Генерирация код
  $code = substr(str_shuffle($chars), 0, $length);

  $_SESSION['Капча'] =  $code;

  //Создание нового изображения из файла
  $image = imagecreatefrompng('img/bg.png');
  //Установка размера шрифта в пунктах
  $size = 36;
  //Создние цвета, который будет использоваться в изображении
  $color = imagecolorallocate($image, 120, 10, 10);
  //Установка пути к шрифту
  $font = __DIR__ . '/fonts//oswald.ttf';;
  //Задание угола в градусах
  $angle = rand(-10, 10);
  //Установка координат точки для первого символа текста
  $x = 56;
  $y = 64;
  //Нанесение текста на изображение
  imagefttext($image, $size, $angle, $x, $y, $color, $font, $code);
  //Запись изобрадения в файл
  imagepng($image, 'img/captcha.png');
  //Удаляем изображение
  imagedestroy($image);
}
?>
