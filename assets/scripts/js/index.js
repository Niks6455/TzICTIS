var personFieldsContainer = document.getElementById('person-fields');
var numberOfPeopleInput = document.getElementById('number-of-people');
var form = document.getElementById("form__person");
var startDateField = document.getElementById("start-date");
var endDateField = document.getElementById("end-date");
var fillButton = document.getElementById("fill-button");
var form__but = document.getElementById("form__but");
var change = false;

fillButton.style.opacity = "0.6";
form__but.style.display = "none";
form.style.display = "none";
fillButton.disabled = true;
endDateField.addEventListener("change", validateDates);

//выбран ли файл
document.getElementById('file').addEventListener('change', function(){
  if( this.value ){
    change = true;
  } 
});

//валидация дат
function validateDates() {
  if (endDateField.value < startDateField.value) {
    fillButton.disabled = true;
    alert("Конец командировки не может быть раньше начала командировки");
  }
  else {
    fillButton.disabled = false;
    fillButton.style.opacity = "1";
  }
}

//первое добавление
fillButton.addEventListener('click', function() {
  form__but.style.display = "block";
  form.style.display = "block";
  var numberOfPeople = parseInt(numberOfPeopleInput.value); 
  updatePersonFields(numberOfPeople); 
  fillButton.style.display = "none";
});

// Обработчик события при изменении значения в поле "Input"
numberOfPeopleInput.addEventListener('change', function() {
  var numberOfPeople = parseInt(numberOfPeopleInput.value); 
  updatePersonFields(numberOfPeople);
});

// Функция для обновления полей в зависимости от количества людей
function updatePersonFields(numberOfPeople) {
  while (personFieldsContainer.firstChild) {
    personFieldsContainer.firstChild.remove();
  }

// Добавление новых полей
for (var i = 0; i < numberOfPeople; i++) {
  var fieldset = document.createElement('fieldset');
  fieldset.style.marginBottom = "10px";
  fieldset.innerHTML = `
    <legend>Данные для человека ${i + 1}</legend>
    <div style="display:flex; width:100%; justify-content:start" >
      <div style="margin-right:25px">
        <label for="name-${i}">ФИО:</label>
        <input style="padding-left:5px; font-size:16px; width:200px; height:25px; border:none; border-radius:5px" type="text" id="name-${i}" name="name-${i}" required>
      </div>
      <div style="margin-right:25px">
        <label for="position-${i}">Должность:</label>
        <input  style="padding-left:5px; font-size:16px; width:200px; height:25px; border:none; border-radius:5px" type="text" id="position-${i}" name="position-${i}" required>
      </div>
      <div style="margin-right:25px">
        <label for="department-${i}">Кафедра:</label>
        <input  style="padding-left:5px; font-size:16px; width:200px; height:25px; border:none; border-radius:5px; " type="text" id="department-${i}" name="department-${i}" required>
      </div>
    </div>

    <div style="display:flex; width:100%; justify-content:start; margin-top:10px">
    <div style="margin-right:25px">
      <label for="email-${i}">Email-адрес:</label>
      <input style="padding-left:5px; font-size:16px; width:200px; height:25px; border:none; border-radius:5px" class="person__input" type="email" id="email-${i}" name="email-${i}" required>
    </div>
    <div >
      <label for="phone-${i}">Номер телефона:</label>
      <input style="padding-left:5px; font-size:16px; width:200px; height:25px; border:none; border-radius:5px" class="person__input" type="tel" id="phone-${i}" name="phone-${i}" required>
    </div>
    </div>  
  `;
  personFieldsContainer.appendChild(fieldset);
  }
}

//проверка на наличие файла 
form__but.addEventListener('click', function() {
  if(!change){
    alert("Прикрепите файл!");
  }
});