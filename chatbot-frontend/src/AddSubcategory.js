import React, { useState, useEffect } from 'react';
import api from './api';

const AddSubcategory = () => {
  const [formData, setFormData] = useState({
    name: '',
    description: '',
    category_id: '',
  });

  const [categories, setCategories] = useState([]);
  const [message, setMessage] = useState('');

  useEffect(() => {
    // Obtener todas las categorías disponibles
    api.get('/categories')
      .then((response) => {
        setCategories(response.data);
      })
      .catch((error) => {
        console.error('Error al obtener las categorías:', error);
      });
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    api.post('/subcategories', formData)
      .then((response) => {
        setMessage('Subcategoría creada con éxito');
        setFormData({
          name: '',
          description: '',
          category_id: '',
        });
      })
      .catch((error) => {
        console.error('Error al crear la subcategoría:', error);
        setMessage('Error al crear la subcategoría.');
      });
  };

  return (
    <div>
      <h2>Agregar Subcategoría</h2>
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
        <div>
          <label>Categoría:</label>
          <select
            name="category_id"
            value={formData.category_id}
            onChange={handleChange}
            required
          >
            <option value="">Seleccionar una categoría</option>
            {categories.map((category) => (
              <option key={category.id} value={category.id}>
                {category.name}
              </option>
            ))}
          </select>
        </div>
        <button type="submit">Agregar Subcategoría</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
};

export default AddSubcategory;