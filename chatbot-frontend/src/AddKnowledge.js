import React, { useState } from 'react';
import api from './api';

const AddKnowledge = () => {
  const [formData, setFormData] = useState({
    question: '',
    answer: '',
    language: 'en', // Idioma predeterminado
    category_id: '',
    subcategory_id: '',
  });

  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    api.post('/knowledges', formData)
      .then((response) => {
        setMessage('Knowledge creado con éxito');
        setFormData({
          question: '',
          answer: '',
          language: 'en',
          category_id: '',
          subcategory_id: '',
        });
      })
      .catch((error) => {
        console.error('Error al crear Knowledge:', error);
        setMessage('Error al crear Knowledge.');
      });
  };

  return (
    <div>
      <h2>Agregar Knowledge</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Pregunta:</label>
          <input
            type="text"
            name="question"
            value={formData.question}
            onChange={handleChange}
            required
          />
        </div>
        <div>
          <label>Respuesta:</label>
          <textarea
            name="answer"
            value={formData.answer}
            onChange={handleChange}
            required
          />
        </div>
        <div>
          <label>Idioma:</label>
          <select
            name="language"
            value={formData.language}
            onChange={handleChange}
          >
            <option value="en">Inglés</option>
            <option value="es">Español</option>
            <option value="fr">Francés</option>
          </select>
        </div>
        <div>
          <label>Categoría (ID):</label>
          <input
            type="number"
            name="category_id"
            value={formData.category_id}
            onChange={handleChange}
          />
        </div>
        <div>
          <label>Subcategoría (ID):</label>
          <input
            type="number"
            name="subcategory_id"
            value={formData.subcategory_id}
            onChange={handleChange}
          />
        </div>
        <button type="submit">Agregar</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
};

export default AddKnowledge;