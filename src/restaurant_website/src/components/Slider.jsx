// src/components/Slider.jsx
import React from 'react';
// import slider1 from '@/assets/images/slider-1.jpg';
// import slider2 from '@/assets/images/slider-2.jpg';

const Slider = () => {
    const slides = [
        { image: '' , title: 'Delicious', subtitle: 'Fine Food + Drinks' },
        { image: '' , title: 'Savor the Taste', subtitle: 'Authentic & Fresh' },
    ];

    return (
        <section id="home" className="slider-section">
            {slides.map((slide, index) => (
                <div key={index} className="slide" style={{ backgroundImage: `url(${slide.image})` }}>
                    <h1>{slide.title}</h1>
                    <p>{slide.subtitle}</p>
                </div>
            ))}
        </section>
    );
};

export default Slider;
