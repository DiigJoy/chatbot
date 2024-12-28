import React, { useEffect, useState } from 'react';
import api from './api';

const KnowledgeList = () => {
  const [knowledges, setKnowledges] = useState([]);

  useEffect(() => {
    // Hacer solicitud GET a la API
    api.get('/knowledges')
      .then((response) => {
        setKnowledges(response.data); // Guardar datos en el estado
      })
      .catch((error) => {
        console.error('Error fetching knowledges:', error);
      });
  }, []);

  return (
    <div>
      <h1>Knowledge List</h1>
      <ul>
        {knowledges.map((knowledge) => (
          <li key={knowledge.id}>
            {knowledge.question}: {knowledge.answer}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default KnowledgeList;