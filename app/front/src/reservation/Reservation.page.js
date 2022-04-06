import React, {useState, useEffect} from 'react';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import DatePicker from "react-datepicker";
import PopupDeleteEvent from "./popup_deleteEvent";
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
  const [show, setShow] = useState(false);


  const [newEvent, setNewEvent] = useState({id: 16, title: '', start: '', end: ''});
  const [allEvents, setAllEvents] = useState(events);

  const [deleteEvent, setDeleteEvents] = useState();
  // or globalizeLocalizer
  const localizer = momentLocalizer(moment);

  const slotSelected = (slotInfo) => {
    alert(`start ${slotInfo.start.toLocaleString()}`);
    setView('day');
  }

  const eventSelected = (event) => {
    console.log('event:', event);
    setShow(true);
    setDeleteEvents(event);
  }

  function handleAddEvent(){
    setAllEvents([...allEvents, newEvent]);
  }

  function handleDeleteEvent(id){
   console.log(allEvents);
    allEvents.map((event, index) => {
      if(event.id === id){
        allEvents.splice(index, 1);
        console.log('click', allEvents)
        setShow(false);
      }
    });
  }

  return(
    <>
      <div className="calendar-container">
        <div class="c-calendar_form" >
          <input type="text" name="title" value={newEvent.title} onChange={(e) => setNewEvent({...newEvent, title: e.target.value})} />
          <DatePicker value={newEvent.start} onChange={(start) =>  setNewEvent({...newEvent, start})}/>
          <DatePicker value={newEvent.end} onChange={(end) =>  setNewEvent({...newEvent, end})}/>
          <button type="button" onClick={handleAddEvent}>Add Events</button>
        </div>
        <Calendar selectable localizer={localizer} events={allEvents} defaultView={view} startAccessor="start" endAccessor="end"
        onSelectSlot={(slotInfo) => slotSelected(slotInfo)}
        onSelectEvent={(event) => eventSelected(event)} style={{height: 500}}/>
      </div>

      { show === true ? <PopupDeleteEvent event={deleteEvent} setShow={setShow} handleDeleteEvent={handleDeleteEvent}/> : null }
    </>
  )
}
