var fillButton = document.getElementById('fill-button');
  var personFieldsContainer = document.getElementById('person-fields');
  var numberOfPeopleInput = document.getElementById('number-of-people');
  var form = document.getElementById("form__person")
  fillButton.addEventListener('click', function() {
    var numberOfPeople = parseInt(numberOfPeopleInput.value);
    fillButton.style.display = 'none';
    updatePersonFields(numberOfPeople);
    form.style.backgroundColor  = '#ffffff80';
  });

  numberOfPeopleInput.addEventListener('input', function() {
    var numberOfPeople = parseInt(numberOfPeopleInput.value);
    updatePersonFields(numberOfPeople);
  });

  function updatePersonFields(numberOfPeople) {
    // Удаление всех существующих полей
    while (personFieldsContainer.firstChild) {
      personFieldsContainer.firstChild.remove();
    }

    // Добавление новых полей
    for (var i = 0; i < numberOfPeople; i++) {
      var fieldset = document.createElement('fieldset');
      fieldset.innerHTML = `
        <legend>Данные для человека ${i + 1}</legend>
        <label for="name-${i}">ФИО:</label>
        <input type="text" id="name-${i}" name="name-${i}" required>

        <label for="position-${i}">Должность:</label>
        <input type="text" id="position-${i}" name="position-${i}" required>

        <label for="department-${i}">Кафедра:</label>
        <input type="text" id="department-${i}" name="department-${i}" required>

        <label for="email-${i}">Email-адрес:</label>
        <input type="email" id="email-${i}" name="email-${i}" required>

        <label for="phone-${i}">Номер телефона:</label>
        <input type="tel" id="phone-${i}" name="phone-${i}" required>
      `;

      personFieldsContainer.appendChild(fieldset);
    }
  }