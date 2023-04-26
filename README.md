# Лабораторные работы 4-6 по дисциплине "Проектирование информационных систем с применением web-технологий" (8 семестр)

## Разработка сайта с клиентской и административной частями

Разработан сайт для интернет-магазина компьютерной техники. Сайт имеет следующую структуру:

1. Главная страница "Каталог товаров"  
  1.1 Страница "Статистика"  
  1.2 Страница "Информация"  
  1.3 Страница "Карточка товара"  
  1.4 Страница "Личный кабинет"  
  1.5 Страница "Корзина товаров"  
  1.6 Страница администратора "Администратор"    
  - Страница "Заказы клиентов"  
  - Страница "Добавление типов и производителей"
  - Страница "Изменение списка товаров"


[Видео](https://drive.google.com/file/d/1aSr6bokISBejh0yYwcQL4GJjFUe7g2Wr/view?usp=sharing) с работой сайта.

## Функциональность сайта и основные моменты при реализации

Данные для сайта расположены в базе данных.

<p align="center">
  <img width=400 src="https://drive.google.com/uc?export=view&id=1__lZpmdl3Vn7QOA3Jy7TQejJ2hziT3Lz"/>
</p>

Подключение базы данных реализуется в отдельном файле _"database.php"_.

```php
$par1_ip = "127.0.0.1";
$par2_name = "root";
$par3_p = "";
$par4_db = "shop";
//Подключение к БД
$induction = mysqli_connect($par1_ip, $par2_name, $par3_p, $par4_db);
```

На страницах _"Каталог товаров"_, _"Статистика"_ и _"Информация"_ реализовано модальное окно для регистрации и авторизации. Реализация осуществлена с помощью функции, прописанной в отдельном файле _"source.php"_. В окне реализована [капча](https://github.com/itchief/captcha.git), также присутствует защита от SQL-инъекций, проверка на пустые поля.

Реализована работа с сессией для хранения идентификатора зарегистрированного пользователя и факта входа в личный кабинет для подсчета статистики. Подключение осуществляется в файле _"session.php"_.

```php
//Начало сессии
session_start();
...
//Работа с сессией
$_SESSION["Вход"] = "Да";
...
//Закрытие сессии при выходе из ЛК
session_destroy();
```

+ **Страница _"Каталог товаров"_**

Файл _"index.php"_. Вход осуществляется по ссылке из меню. Каталог товаров выводится из таблицы "Товары". На странице реализован фильтр по производителям и типам товаров, а также добавление в корзину нескольких товаров.

+ **Страница _"Статистика"_**

Файл _"statistics.php"_. Вход осуществляется по ссылке из меню. Содержит информацию о посещениях сайта, а также о проценте зарегистрированных пользователей. Соответствующая информация хранится в таблице "Статистика".

+ **Страница _"Информация"_**

Файл _"contacts.php"_. Вход осуществляется по ссылке из меню. На странице содержится описание компании, контактные данные и форма с применением почтового сервера.

+ **Страница _"Карточка товара"_**

Файл _"product.php"_. Вход осуществляется по на товар в любом месте сайта. Содержит полную информацию о выбранном товаре. Информация берется из таблицы "Товары". На странице имеется возможность добавления товара в корзину.

+ **Страница _"Личный кабинет"_**

Файл _"cabinet.php"_. Вход осуществляется по ссылке "Личный кабинет" после авторизации в модальной форме. Содержит информацию о клиенте, взятую из таблицы "Клиент". Имеется возможность изменять личные данные, просматривать и удалять историю покупок.

+ **Страница _"Корзина товаров"_**

Файл _"basket.php"_. Вход осуществляется по ссылке "Корзина". Содержит данные из временной таблицы "КорзинаБуф" со списком товаров, добавленных в корзину. Имеется возможность отчистки корзины и оформления заказа. Оформление заказа возможно только после входа в личный кабинет.

+ **Страница _"Администратор"_**

Файл _"admin.php"_. Вход осуществляется после авторизации в модальной форме под логином и паролем администратора. В фале реализовано сразу три страницы, переход осуществляется с помощью ссылок с GET-запросами. Страница _"Заказы клиентов"_ содержит перечень заказов из таблицы "Корзина" с сортировкой по дате или по фамилии клиента. Страница _"Добавление типов и производителей"_ содержит формы для добавлений в таблицы "Типы" и "Производители" соответственно. Страница _"Изменение списка товаров"_ позволяет осуществлять добавление, изменение или удаление данных из таблицы "Товары".

```html
<!--Навигация сайта администратора-->
<nav>
  <ul>
    <li><a id=btn_zakaz href="admin.php?Админ=Заказы">Заказы клиентов</a></li>
    <li><a id=btn_type href="admin.php?Админ=Добавление">Добавление типов и производителей</a></li>
    <li><a id=btn_product href="admin.php?Админ=Товары">Изменение списка товаров</a></li>
  </ul>
</nav>
```

```php
//Проверка GET-запроса
if ($_GET[Админ] == "Заказы")
  echo "<form class=main method='post' style=overflow:hidden>";
else
  echo "<form class=main method='post' style='overflow:hidden;display:none;'>"

```
