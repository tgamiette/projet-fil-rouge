import React, {useState, useEffect} from 'react';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import DatePicker from "react-datepicker";
import PopupDeleteEvent from "./popup_deleteEvent";
import moment from 'moment';
import events from './events.js';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import "react-datepicker/dist/react-datepicker.css";
import './style/calendrier.css';

export default function Reservation(){

 const [date, setDate] = useState(new Date());

 return(
   <div className="c-container_calendar">
    <h1>Prochaines livraisons</h1>
    <div className="calendar-container">
      <MyCalendar date={date.toDateString()}/>
    </div>
  </div>
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

        <Calendar selectable localizer={localizer} events={allEvents} defaultView={view} startAccessor="start" endAccessor="end"
        onSelectSlot={(slotInfo) => slotSelected(slotInfo)}
        onSelectEvent={(event) => eventSelected(event)} style={{height: 500}}/>
      </div>

      { show === true ? <PopupDeleteEvent event={deleteEvent} setShow={setShow} handleDeleteEvent={handleDeleteEvent}/> : null }
    </>
  )
}
