// src/App.jsx
import React from 'react';
import Header from './components/Header';
import Slider from './components/Slider';
import About from './components/About';
import ReservationForm from './components/ReservationForm';

const App = () => {
  return (
    <>
      <Header />
      <Slider />
      <About />
      <ReservationForm />
    </>
  );
};

export default App;
