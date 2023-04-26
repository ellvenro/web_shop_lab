var none = document.getElementsByClassName("opacity");
var red = document.getElementsByClassName("red");
var btn_red = document.getElementById("btn_red");

//Нажатие кнопки редактирования профиля
btn_red.onclick = function() {
  for (var i = 0; i < none.length; i++)
    none[i].classList.remove("none");
  btn_red.classList.add("none");
  red[0].classList.remove("none");
}
