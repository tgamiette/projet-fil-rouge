import React, {useState, useEffect} from 'react';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import DatePicker from "react-datepicker";
import moment from 'moment';
import events from './events.js';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import "react-datepicker/dist/react-datepicker.css";
import './Reservation.css';

export const Reservation = () => {

 const [date, setDate] = useState(new Date());

 return(
   <>
    <h1>Calendars</h1>
    <div className="calendar-container">
      <MyCalendar date={date.toDateString()}/>
    </div>

    <div className="selected-date">
     <span>Selected date :{date.toDateString()}</span>
    </div>

    <div>{date.toDateString()}</div>
  </>
 )
}

const MyCalendar = (todaydate) => {

  const [view, setView] = useState('month');


  const [newEvent, setNewEvent] = useState({id: 16, title: '', start: '', end: ''});
  const [allEvents, setAllEvents] = useState(events);
  // or globalizeLocalizer
  const localizer = momentLocalizer(moment);

  const slotSelected = (slotInfo) => {
    alert(`start ${slotInfo.start.toLocaleString()}`);
    setView('day');
  }

  function handleAddEvent(){
    setAllEvents([...allEvents, newEvent]);
  }

  return(
    <div className="calendar-container">
      <div class="c-calendar_form" >
        <input type="text" name="title" value={newEvent.title} onChange={(e) => setNewEvent({...newEvent, title: e.target.value})} />
        <DatePicker value={newEvent.start} onChange={(start) =>  setNewEvent({...newEvent, start})}/>
        <DatePicker value={newEvent.end} onChange={(end) =>  setNewEvent({...newEvent, end})}/>
        <button type="button" onClick={handleAddEvent}>Add Events</button>
      </div>
      <Calendar selectable localizer={localizer} events={allEvents} defaultView={view} startAccessor="start" endAccessor="end"
      onSelectSlot={(slotInfo) => slotSelected(slotInfo)} style={{height: 500}}/>
    </div>
  )
}
