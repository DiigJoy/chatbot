import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // Cambia la URL al dominio de tu backend
  headers: {
    'Content-Type': 'application/json',
  },
});

export default api;