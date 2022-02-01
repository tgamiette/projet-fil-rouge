import React, {useState, useEffect} from 'react';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import moment from 'moment';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import events from './events.js'

export const Reservation = () => {

 const [date, setDate] = useState(new Date());

 return(
   <>
    <h1>Calendars</h1>
    <div className="calendar-container">
      <MyCalendar />
    </div>

    <div className="selected-date">
     <span>Selected date :{date.toDateString()}</span>
    </div>
  </>
 )
}

const MyCalendar = props => {
  // or globalizeLocalizer
  const localizer = momentLocalizer(moment);
  return(
    <div className="calendar-container">
      <Calendar localizer={localizer} events={events} startAccessor="start" endAccessor="end"/>
    </div>
  )
}
