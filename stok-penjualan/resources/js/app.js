import './bootstrap';
import '../css/app.css';

import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './App1';

const container = document.getElementById('app');

if (container) {
    createRoot(container).render(<App />);
}
