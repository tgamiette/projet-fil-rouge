import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './Main/App';
import reportWebVitals from './reportWebVitals';
import Router from './Router/router'
import { Provider} from 'react-redux';
import store from './redux/store';
import { persistStore } from 'redux-persist';
import { PersistGate } from 'redux-persist/integration/react';
//...
let persistor = persistStore(store);

persistStore(store, {}, () => {
  ReactDOM.render((
    <Provider store={store}>
      <PersistGate persistor={persistor}>
        <Router />
      </PersistGate>
    </Provider>
  ), document.getElementById('root'));
})

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
