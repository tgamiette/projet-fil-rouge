import React from 'react';
import { Component } from 'react';
import { Button } from 'react-bootstrap';
import './App.css';
import { DefaultLayout } from './layout/DefaultLayout';
import { Entry } from './page/entry/Entry.page';
import { Reservation } from './page/reservation/Reservation.page';

function App() {
  return (
    <div className="App">
      <Reservation />
    </div>
  );
}

export default App;
