// src/components/Header.jsx
import React from 'react';
// import logo from '@/assets/images/brand/logo.png';

const Header = () => {
  return (
    <header className="header-full-width">
      <nav className="nav-white full-width nav-transparent">
        <div className="nav-header">
          <a href="/" className="brand">
            <img src={' '} alt="Delicious" />
          </a>
          <button className="toggle-bar">☰</button>
        </div>
        <ul className="menu">
          {['Home', 'About', 'Reservation', 'Gallery', 'Menu', 'Contact'].map((item) => (
            <li key={item}>
              <a href={`#${item.toLowerCase()}`}>{item}</a>
            </li>
          ))}
        </ul>
      </nav>
    </header>
  );
};

export default Header;
