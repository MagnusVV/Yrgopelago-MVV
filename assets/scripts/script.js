// THE BOOKING FORM --- --- --->

//  date-FIELDS:

// Set min and max value on arrival and departure date-FIELDS. Inspired by: https://stackoverflow.com/questions/61010768/set-html5-date-field-min-value-based-on-another-html5-date-value

const arrivalDate = document.getElementById('arrivalDate');

const departureDate = document.getElementById('departureDate');

// Function that converts date variable to UTC-format, adds or remove one day, and converts it back to ISO-format. Inspired by: https://stackoverflow.com/questions/60289487/how-do-i-get-the-next-days-date-in-js-in-yyyy-mm-dd-format
function addOrSubstractDays(date, int) {
  const modifyDate = new Date(date);
  modifyDate.setUTCDate(modifyDate.getUTCDate() + int);
  const dayResult = modifyDate.toISOString().substring(0, 10);

  return dayResult;
}

// onchange-handlers where selected dates are checked and possible min- and max-dates are adjusted accordingly:

// Add +1, so departureDate always will be at least one day after arrivalDate.
arrivalDate.onchange = function setMinDepartureDate() {
  const firstDate = arrivalDate.value;

  departureDate.setAttribute('min', addOrSubstractDays(firstDate, 1));
};

// Substracts 1, so arrivalDate always will be at least one day before departureDate.
departureDate.onchange = function setMinArrivalDate() {
  const secondDate = departureDate.value;

  arrivalDate.setAttribute('max', addOrSubstractDays(secondDate, -1));
};

// total-cost-FIELD at the bottom of the form:

const totalCost = document.getElementById('totalCost');

totalCost.setAttribute('value', 1);

// room-SELECTION:

const roomSelector = document.getElementById('roomSelection');

// this is just the default start value (room cost)
let roomCost = parseInt(roomSelector.value);

// getting the running value (room cost) from the selector, and adding it to total cost
roomSelector.onchange = () => {
  for (let i = 0; i < roomSelector.length; i++) {
    if (roomSelector[i].selected) {
      totalCost.value = roomSelector[i].value;
    }
  }
};

// extras-SELECTION:

const extrasCheckBoxes = document.querySelectorAll('#extras');

// adding/substracting cost for Extras, and adding it to total cost. Inspired by: http://www.madirish.net/11

extrasCheckBoxes.forEach((checkBox) => {
  checkBox.addEventListener('change', () => {
    let sumAdded = 0;
    extrasCheckBoxes.forEach((checkBox) => {
      if (checkBox.checked == true) {
        sumAdded = sumAdded + parseInt(checkBox.value);
      }
    });

    console.log(sumAdded);
  });
});

// <--- --- ---
