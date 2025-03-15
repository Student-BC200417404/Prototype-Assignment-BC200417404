// src/components/ReservationForm.jsx
import React, { useState } from 'react';

const ReservationForm = () => {
    const [form, setForm] = useState({
        name: '',
        email: '',
        date: '',
        people: 1,
    });

    const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('Reservation Data:', form);
    };

    return (
        <form onSubmit={handleSubmit}>
            <input name="name" type="text" placeholder="Name" onChange={handleChange} />
            <input name="email" type="email" placeholder="Email" onChange={handleChange} />
            <input name="date" type="date" onChange={handleChange} />
            <input name="people" type="number" placeholder="People" onChange={handleChange} />
            <button type="submit">Reserve Now</button>
        </form>
    );
};

export default ReservationForm;
