<?php
include "src/source.php";
?>

<html>
  <head>
    <title>Администратор</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="css/styles_admin.css">
  </head>
  <body>

    <header>
      <div style=overflow:hidden>
        <div class=head>
          Computer store
        </div>
        <div class=reg>
          <a href="index.php">На главную</a>
        </div>
      </div>
      <nav>
        <ul>
          <li><a id=btn_zakaz href="admin.php?Админ=Заказы">Заказы клиентов</a></li>
          <li><a id=btn_type href="admin.php?Админ=Добавление">Добавление типов и производителей</a></li>
          <li><a id=btn_product href="admin.php?Админ=Товары">Изменение списка товаров</a></li>
        </ul>
      </nav>
    </header>

    <?php
    if (isset($_POST[button_reset])) {
      unset($_POST);
    }
    ?>

    <!--Заказы клиентов-->
    <?php if ($_GET[Админ] == "Заказы")
      echo "<form class=main method='post' style=overflow:hidden>";
    else
      echo "<form class=main method='post' style='overflow:hidden;display:none;'>";
    ?>
      <!--Фильтр-->
      <div class=filter >
        <h1>Фильтр</h1>
          <select name="Клиент" style="margin-bottom:0.5em">
            <option value=0 disabled selected>(пусто)</option>
            <?php
            if ($_POST[Дата] != "") {
              $_POST[Клиент] = 0;
            }
            $result = mysqli_query($induction, "SELECT КодК, Фамилия, Имя FROM Клиенты ORDER BY Фамилия");
            while ($srting = mysqli_fetch_assoc($result)) {
              if ($_POST[Клиент] == $srting[КодК])
                echo "<option selected value=$srting[КодК]>$srting[Фамилия] $srting[Имя]</option>";
              else
                echo "<option value=$srting[КодК]>$srting[Фамилия] $srting[Имя]</option>";
            }
            ?>
          </select><br>
          <?php
          if ($_POST[Дата] != "")
            echo "<input type=date name=Дата value=$_POST[Дата]><br>";
          else
            echo "<input type=date name=Дата><br>";
          ?>
          <button type="submit" class="btn_filt" name=button_filter>Применить</button>
          <button type="submit" class="btn_filt" name=button_reset>Сбросить</button>
      </div>

      <!--Каталог заказов-->
      <div class=catalog>
        <h1>Заказы</h1>
        <div id=content>
          <table>
            <tr>
              <th>Клиент</th>
              <th>Товар</th>
              <th>Стоимость</th>
              <th>Дата</th>
            </tr>
            <?php
            if (isset($_POST[button_filter])) {
              if (isset($_POST[Клиент]))
              {
                $result = mysqli_query($induction, "SELECT Клиенты.Фамилия, Клиенты.Имя, Товары.Название, Товары.Стоимость, Корзина.Дата FROM Товары INNER JOIN (Клиенты INNER JOIN Корзина ON Клиенты.КодК = Корзина.КодК) ON Товары.КодТ = Корзина.КодТ WHERE Клиенты.КодК='$_POST[Клиент]'");
              }
              if ($_POST[Дата] != "") {
                $result = mysqli_query($induction, "SELECT Клиенты.Фамилия, Клиенты.Имя, Товары.Название, Товары.Стоимость, Корзина.Дата FROM Товары INNER JOIN (Клиенты INNER JOIN Корзина ON Клиенты.КодК = Корзина.КодК) ON Товары.КодТ = Корзина.КодТ WHERE Корзина.Дата='$_POST[Дата]'");
                $_POST[Клиент] = 0;
              }
            }
            else {
              $result = mysqli_query($induction, "SELECT Клиенты.Фамилия, Клиенты.Имя, Товары.Название, Товары.Стоимость, Корзина.Дата FROM Товары INNER JOIN (Клиенты INNER JOIN Корзина ON Клиенты.КодК = Корзина.КодК) ON Товары.КодТ = Корзина.КодТ");
            }
            $sum = 0;
            while ($srting = mysqli_fetch_assoc($result)) {
              echo "<tr><td>$srting[Фамилия] $srting[Имя]</td><td>$srting[Название]</td><td>$srting[Стоимость] ₽</td><td>" . date("d.m.Y", strtotime($srting["Дата"])) . "</td></tr>";
              $sum += (int)$srting[Стоимость];
            }
            ?>
            <tr>
              <td>Общая сумма:</td><td></td><td><?php echo $sum;?> ₽</td><td></td>
            </tr>
          </table>
        </div>
      </div>
    </form>

    <!--Добавление типов товаров и производителей-->
    <?php if ($_GET[Админ] == "Добавление")
      echo "<form class=main method='post' style=overflow:hidden>";
    else
      echo "<form class=main method='post' style='overflow:hidden;display:none;'>";
    ?>
      <h1>Добавление</h1>
      <table id=types>
        <tr>
          <td>Введите новый тип товаров:</td>
          <td><input type="text" name="type"><br></td>
        </tr>
        <tr>
          <td></td>
          <td><button type="submit" name="btn_type">Добавить тип</button></td>
        </tr>
        <tr>
          <td>Введите нового производителя:</td>
          <td><input type="text" name="manuf"></td>
        </tr>
        <tr>
          <td>Введите сайт производителя:</td>
          <td><input type="text" name="manuf_site"></td>
        </tr>
        <tr>
          <td></td>
          <td><button type="submit" name="btn_manuf">Добавить производителя</button></td>
        </tr>
      </table>
    </form>
    <?php
    if (isset($_POST[btn_type])) {
      mysqli_query($induction, "INSERT INTO `типы`(`КодТТ`, `Тип`) VALUES (NULL,'" . $_POST[type] . "')");
    }
    if (isset($_POST[btn_manuf])) {
      mysqli_query($induction, "INSERT INTO `производители`(`КодП`, `Производитель`, `Сайт`) VALUES (NULL,'" . $_POST[manuf] . "','" . $_POST[manuf_site] . "')");
    }
    ?>

    <!--Изменение товаров-->
    <?php
    if (isset($_POST[btn_product])) {
      if ($_POST[Новый_радио] == "Добавить") {
        $int1 = (int)$_POST[Новый_производитель];
        $int2 = (int)$_POST[Новый_тип];
        $int3 = (int)$_POST[Новая_стоимость];
        $q = "INSERT INTO Товары (КодТ, КодП, Название, КодТТ, Описание, Стоимость, Фото) VALUES (NULL, $int1, '$_POST[Новое_название]', $int2, '$_POST[Новое_описание]', $int3, '')";
        mysqli_query($induction, $q);
      }
      foreach ($_POST[Радио] as $key => $value) {
        if ($value == "Изменить") {
          mysqli_query($induction, "UPDATE `товары` SET `КодП`='" . $_POST[Производитель][$key] . "',`Название`='" . $_POST[Название][$key] . "',`КодТТ`='" . $_POST[Тип][$key] . "',`Описание`='" . $_POST[Описание][$key] . "',`Стоимость`='" . $_POST[Стоимость][$key] . "' WHERE КодТ=" . $key);
        }
        else if ($value == "Удалить") {
          $q = "DELETE FROM Товары WHERE КодТ=" . $key;
          mysqli_query($induction, $q);
        }
      }
    }
    ?>
    <?php if ($_GET[Админ] == "Товары")
      echo "<form class=main method='post' style=overflow:hidden>";
    else
      echo "<form class=main method='post' style='overflow:hidden;display:none;'>";
    ?>
      <h1>Каталог товаров</h1>
      <table id=product>
        <tr>
          <th>Название</th>
          <th>Описание</th>
          <th>Стоимость</th>
          <th>Производитель</th>
          <th>Тип</th>
          <th>Изменение</th>
        </tr>
        <?php
          $result = mysqli_query($induction, "SELECT Товары.КодТ, Производители.Производитель, Товары.Название, Типы.Тип, Товары.Описание, Товары.Стоимость FROM Производители INNER JOIN (Типы INNER JOIN Товары ON Типы.КодТТ = Товары.КодТТ) ON Производители.КодП = Товары.КодП ORDER BY Производители.Производитель");
          //Заполнение таблицы
          while ($srting = mysqli_fetch_assoc($result))
          {
            echo "<tr>";
            echo "<td><input name=Название[$srting[КодТ]] value='$srting[Название]' style=width:90%></td>";
            echo "<td><textarea rows=4 style='width:100%;resize:none' name=Описание[$srting[КодТ]]>$srting[Описание]</textarea></td>";
            echo "<td style=text-align:center><input type=number value=$srting[Стоимость] name=Стоимость[$srting[КодТ]]></td>";
            //Список производителей
            $result2 = mysqli_query($induction, "SELECT Производитель, КодП FROM Производители ORDER BY Производитель");
            echo "<td><select name=Производитель[$srting[КодТ]]>";
            while ($srting2 = mysqli_fetch_assoc($result2))
            {
              if ($srting2[Производитель] == $srting[Производитель])
                echo "<option selected value=$srting2[КодП]>$srting2[Производитель]</option>";
              else
                echo "<option value=$srting2[КодП]>$srting2[Производитель]</option>";
            }
            echo "</select></td>";
            //Список типов товаров
            $result2 = mysqli_query($induction, "SELECT Тип, КодТТ FROM Типы ORDER BY Тип");
            echo "<td><select name=Тип[$srting[КодТ]]>";
            while ($srting2 = mysqli_fetch_assoc($result2))
            {
              if ($srting2[Тип] == $srting[Тип])
                echo "<option selected value=$srting2[КодТТ]>$srting2[Тип]</option>";
              else
                echo "<option value=$srting2[КодТТ]>$srting2[Тип]</option>";
            }
            echo "</select></td><td><input type=radio name=Радио[$srting[КодТ]] checked value=Отмена> Отмена<br>
              <input type=radio name=Радио[$srting[КодТ]] value=Изменить> Изменить<br>
              <input type=radio name=Радио[$srting[КодТ]] value=Удалить> Удалить</td>";

            echo "</tr>";
          }
        ?>
        <tr>
          <td><input name=Новое_название></td>
          <td><textarea rows=4 style='width:100%;resize:none' name=Новое_описание></textarea></td>
          <td style=text-align:center><input type=number name=Новая_стоимость></td>
          <?php
          $result2 = mysqli_query($induction, "SELECT Производитель, КодП FROM Производители ORDER BY Производитель");
          echo "<td><select name=Новый_производитель>";
          echo "<option selected disabled value=Пусто>(пусто)</option>";
          while ($srting2 = mysqli_fetch_assoc($result2))
          {
              echo "<option value=$srting2[КодП]>$srting2[Производитель]</option>";
          }
          echo "</select></td>";
          $result2 = mysqli_query($induction, "SELECT Тип, КодТТ FROM Типы ORDER BY Тип");
          echo "<td><select name=Новый_тип>";
          echo "<option selected disabled value=Пусто>(пусто)</option>";
          while ($srting2 = mysqli_fetch_assoc($result2))
          {
              echo "<option value=$srting2[КодТТ]>$srting2[Тип]</option>";
          }
          echo "</select></td><td><input type=radio name=Новый_радио checked value=Отмена> Отмена<br>
            <input type=radio name=Новый_радио value=Добавить> Добавить</td>";
          ?>
        </tr>
        <tr>
          <td colspan="6" align=right><button type=submit name=btn_product>Применить изменения</button></td>
        </tr>
      </table>
    </form>

    <footer>
      <a href="https://github.com/ellvenro">© 2023 ellvenro</a>
    </footer>

    <script type="text/javascript" src="js\scripts.js"></script>
  </body>
</html>
