
import React from 'react';
import AddCategory from './AddCategory';
import AddSubcategory from './AddSubcategory';
import KnowledgeList from './KnowledgeList';
import AddKnowledge from './AddKnowledge';
const App = () => {
  return (
    <div>
      <h1>Gestión de Categorías y Subcategorías</h1>
      <AddCategory />
      <AddSubcategory />
      <KnowledgeList/>
      <AddKnowledge/>
    </div>
  );
};

export default App;
