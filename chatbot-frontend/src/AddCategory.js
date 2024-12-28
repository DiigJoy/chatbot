import React, { useState } from 'react';
import api from './api';

const AddCategory = () => {
  const [formData, setFormData] = useState({
    name: '',
    description: '',
  });

  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    api.post('/categories', formData)
      .then((response) => {
        setMessage('Categoría creada con éxito');
        setFormData({
          name: '',
          description: '',
        });
      })
      .catch((error) => {
        console.error('Error al crear la categoría:', error);
        setMessage('Error al crear la categoría.');
      });
  };

  return (
    <div>
      <h2>Agregar Categoría</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Nombre:</label>
          <input
            type="text"
            name="name"
            value={formData.name}
            onChange={handleChange}
            required
          />
        </div>
        <div>
          <label>Descripción:</label>
          <textarea
            name="description"
            value={formData.description}
            onChange={handleChange}
          />
        </div>
        <button type="submit">Agregar Categoría</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
};

export default AddCategory;