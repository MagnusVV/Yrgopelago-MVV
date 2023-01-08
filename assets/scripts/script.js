// THE BOOKING FORM --- --- --->

//  ---
//  TOTAL-COST-FIELD at the bottom of form:

const totalCost = document.getElementById('totalCost');

totalCost.setAttribute('value', 0);

// object (with starting placeholder values) for summarising total cost in the end:
const totalCostParams = {
  roomCostSum: 1,
  noOfbookedDays: NaN,
  extrasCostSum: 0,
};

// function for summarising total cost in the end:
function countTotalCost() {
  let totalCost =
    totalCostParams.noOfbookedDays *
    (totalCostParams.roomCostSum + totalCostParams.extrasCostSum);

  if (isNaN(totalCost)) {
    totalCost = 0;
  }

  return totalCost;
}

//  ---
//  ROOM-SELECTION:

const roomSelector = document.getElementById('roomSelection');

// this is just the default start value (room cost)
let roomCost = parseInt(roomSelector.value);

// getting the running value (room cost) from the selector, and adding it to total cost

roomSelector.onchange = () => {
  for (let i = 0; i < roomSelector.length; i++) {
    if (roomSelector[i].selected) {
      roomCost = parseInt(roomSelector[i].value);

      totalCostParams.roomCostSum = roomCost;
      totalCost.value = countTotalCost();
    }
  }
};

//  ---
//  DATE-FIELDS (arrival and departure):

const arrivalDate = document.getElementById('arrivalDate');

const departureDate = document.getElementById('departureDate');

// Function that converts date variable to UTC-format, adds or remove one day, and converts it back to ISO-format. Inspired by: https://stackoverflow.com/questions/60289487/how-do-i-get-the-next-days-date-in-js-in-yyyy-mm-dd-format:
function addOrSubstractDays(date, int) {
  const modifyDate = new Date(date);

  modifyDate.setUTCDate(modifyDate.getUTCDate() + int);

  const dayResult = modifyDate.toISOString().substring(0, 10);

  return dayResult;
}

// Function that substracts arrivalDayNr from departureDateNr to get the result of number of days(nights) booked:
function noOfDaysBooked() {
  // min- / max- values on Date-elements are strings and need to be reconverted into date formats
  const arrivalDateFormat = new Date(arrivalDate.value);

  const arrivalDayNr = arrivalDateFormat.getDate();

  const departureDateFormat = new Date(departureDate.value);

  const departureDayNr = departureDateFormat.getDate();

  const noOfDaysBooked = departureDayNr - arrivalDayNr;

  return noOfDaysBooked;
}

// Set min and max value on arrival and departure date-FIELDS. Inspired by: https://stackoverflow.com/questions/61010768/set-html5-date-field-min-value-based-on-another-html5-date-value

// onchange-handlers where selected dates are checked and possible min- and max-dates are adjusted accordingly:

let firstDateChoiceEvent = 0;

// Add +1, so departureDate always will be at least one day after arrivalDate.
arrivalDate.onchange = function setMinDepartureDate() {
  const firstDate = arrivalDate.value;

  departureDate.setAttribute('min', addOrSubstractDays(firstDate, 1));

  let daysBooked = noOfDaysBooked();

  totalCostParams.noOfbookedDays = daysBooked;
  totalCost.value = countTotalCost();
};

// Substracts 1, so arrivalDate always will be at least one day before departureDate.
departureDate.onchange = function setMinArrivalDate() {
  const secondDate = departureDate.value;

  arrivalDate.setAttribute('max', addOrSubstractDays(secondDate, -1));

  let daysBooked = noOfDaysBooked();

  totalCostParams.noOfbookedDays = daysBooked;
  totalCost.value = countTotalCost();
};

//  ---
//  EXTRAS-SELECTION:

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

    totalCostParams.extrasCostSum = sumAdded;
    totalCost.value = countTotalCost();
  });
});

// <--- --- ---
