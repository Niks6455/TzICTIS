var startDateField = document.getElementById("start-date");
var endDateField = document.getElementById("end-date");
var fillButton = document.getElementById("fill-button");
var SubBut = document.getElementsByClassName("form__but__submit")
endDateField.addEventListener("change", validateDates);
fillButton.disabled = true;

function validateDates() {
  if (endDateField.value < startDateField.value) {
    fillButton.disabled = true;
    alert("Конец командировки не может быть раньше начала командировки");
  } else {
    fillButton.disabled = false;
  }
}

fillButton.addEventListener('click', function() { 
  SubBut.style.display = "block"
});