import React, {useState, useEffect} from 'react';
import Calendar from 'react-calendar';
import 'react-calendar/dist/Calendar.css';

export const Reservation = () => {

 const [date, setDate] = useState(new Date());

 return(
   <>
    <h1>Calendars</h1>
    <div className="calendar-container">
      <Calendar onChange={setDate} value={date}/>
    </div>

    <div className="selected-date">
     <span>Selected date :{date.toDateString()}</span>
    </div>
  </>
 )
}
