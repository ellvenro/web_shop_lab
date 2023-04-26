
var modal = document.getElementsByClassName("modal");
var btn = document.getElementById("myBtn");

var btn_reg = document.getElementById("button_reg");
var button_avt = document.getElementById("button_avt");
var btn_reg_2 = document.getElementById("button_reg_2");

var none = document.getElementsByClassName("opacity");

// Нажатие ссылки для открытия формы
btn.onclick = function() {
  modal[0].style.display = "block";
}

// Нажатие на страницу
window.onclick = function(event) {
  if (event.target == modal[0]) {
    modal[0].style.display = "none";
    button_avt.style.opacity = "1";
    btn_reg.style.opacity = "1";
    btn_reg_2.style.opacity = "0";
    for (var i = 0; i < none.length; i++)
      none[i].classList.add("none");
    document.getElementById("table").style.margin="-15% 5% 0 5%";
  }
}

//Нажатие кнопки регистрации
btn_reg.onclick = function() {
  for (var i = 0; i < none.length; i++)
    none[i].classList.remove("none");
  button_avt.style.opacity = "0";
  btn_reg.style.opacity = "0";
  btn_reg_2.style.opacity = "1";
  document.getElementById("table").style.margin="0 5% 0 5%";
}

var pole = document.getElementsByClassName("pole");
console.log(pole);
for (var i = 0; i < pole.length; i++) {
  console.log(pole[i]);
  pole[i].onblur = function() {
    if (this.value == "")
      this.classList.add("input_null");
    else
      this.classList.remove("input_null");
  }
}
