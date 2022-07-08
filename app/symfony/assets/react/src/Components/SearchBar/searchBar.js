import React, { useState, useEffect } from 'react'

export default function SearchBar({dataList, setFilterDisplay}){
  const [search, setSearch] = useState("");

  const handleChange = event => {
    setSearch(event);
  }

  useEffect(() => {
    setSearch(search);
    let oldList = dataList;

    if(search !== "" || search !== undefined || search){
      const search_ = parseAccent(search).toUpperCase();


      let newList = oldList.filter(c =>
        c['fullName'].normalize('NFD').replace(/[\u0300-\u036f]/g, '').toUpperCase().includes(search.toUpperCase())
      );
      setFilterDisplay(newList);
    }else{
      setFilterDisplay(dataList);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [search]);

  function parseAccent(e){
    return e.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
  }


  return (
    <>
      <div className="c-search">
        <input className="search" type="search" value={search} onChange={e => handleChange(e.target.value)} placeholder="Rechercher" />
      </div>
    </>
  )
}
