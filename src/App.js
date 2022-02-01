import { Component } from 'react';
import { Button } from 'react-bootstrap';
import './App.css';
import { DefaultLayout } from './layout/DefaultLayout';
import { Entry } from './page/entry/Entry.page';

function App() {
  return (
    <div className="App">

      <Entry />
    </div>
  );
}

export default App;
