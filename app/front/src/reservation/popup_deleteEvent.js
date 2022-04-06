import React, {useState, useEffect} from 'react';
import './Reservation.css';

const PopupDeleteEvent = ({event, setShow, handleDeleteEvent}) => {


 return(
    <>
      <div class="c-popup_bg">
        <div class="c-popup_delete">
          <h2>Deleting event </h2>
          <div class="c-event-info" data-id={event.id}>
            <p>title : {event.title}</p>
            <p>Date : {event.start.toDateString()} - {event.end.toDateString()}</p>
          </div>
          <button className="c-btn delete" onClick={() => handleDeleteEvent(event.id)}>Delete</button>
          <button className="c-btn discard" onClick={() => setShow(false)}>Discard</button>
        </div>
      </div>
    </>
 )
}


export default PopupDeleteEvent;
