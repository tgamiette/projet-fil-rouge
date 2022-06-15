import React,{useState, useEffect} from 'react';
import {useWaitFor} from '../shared/hooks';
import {get_all_categories, add_product} from '../api';
import SubNav from './nav';
import './style/account.css';

export default function FormmProduits({}){

  const [categories, setCategories] = useState([]);
  const [formInput, setFormInput] = useState({title: "", description: "", category:[], price: null, quantity: null, objective: ""})
  const [product, setProduct] = useState(false);

  useWaitFor(
    () => get_all_categories(),[],(res) => {
      console.log('res', res);
      if(res !== undefined){
        setCategories(res['hydra:member']);
        console.log(categories);
      }
    }
  );

  useEffect(() => {
    setFormInput(formInput);
  },[formInput] );

  useEffect(() => {
    add_product(product.title, product.description, parseInt(product.price), parseInt(product.quantity), product.category);
  }, [product]);

  const handleChange = ({target}) =>{
    setFormInput(prev => ({
        ...prev,
        [target.name]: target.value
    }));

  }

  const handleSubmit = (e) => {
    e.preventDefault();
    setProduct(formInput);

    const { title, body, image } = fields;

   var formData = new FormData();
   formData.append('title', title);
   formData.append('body', body);
   formData.append('image', image);

   console.log(title, body, image);

  }

  return(
    <div className="c-account">
     <SubNav />
    <div className="c-form">
        <h1>Ajout d'un produit</h1>
        <form onSubmit={handleSubmit}>
          <div className="c-form_wrapper">
            <label className="">Titre</label>
            <input type="text" name="title" onChange={handleChange} value={formInput.tilte}/>
          </div>
          <div className="c-form_wrapper">
            <label className="">Description</label>
            <textarea name="description" cols="" rows="" onChange={handleChange} value={formInput.description}></textarea>
          </div>

          <div className="c-form_wrapper">
            <label className="">Category</label>
            <select name="category" id="category" onChange={handleChange} selected={formInput.category[0]}>
            {
              categories.map((item, index) => {
                return(
                  <option value={item['@id']}>{item['title']}</option>
                )
              })
            }
          </select>
          </div>

          <div className="c-form_wrapper">
            <label className="">Image de votre produits</label>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg" data-max-size="2048"/>
          </div>

          <div className="c-form_wrapper">
            <label className="">Prix</label>
            <input type="number" name="price" onChange={handleChange} value={formInput.price}/>
          </div>

          <div className="c-form_wrapper">
            <label className="">Quantité</label>
            <input type="number" name="quantity" onChange={handleChange} value={formInput.quantity}/>
          </div>

          <div className="c-form_wrapper">
            <label className="">Objectif</label>
            <input type="number" name="objective" onChange={handleChange} value={formInput.objective}/>
          </div>

         <button className="c-btn is__form" type="submit">Ajouter</button>
        </form>
       </div>

      </div>
  )
}
