export default function Produits({}){

  return(

    <div>
      <div className="c-produit_add">
        <form>
          <input type="number" name="quantity" value="" min="1" max="100" placeholder="Quantité"/>
          <input type="" name="" value="" />
          <select>
            <option>kg</option>
          </select>
          <input type="" name="" value="" />
          <input type="" name="" value="" />

        </form>

      </div>

      <div className="c-produits_infos">
        <div>
          <h2>title</h2>
          <div>
            <div className="c-produit_img">
              <div className="">
                <img src="#" alt="" />
              </div>
              <span>80kg restant</span>
              <span>100kg disponible</span>
            </div>
            <div className="c-produit_infos">
              <span>prix € le kilos</span>
              <span>Vendu par producteur</span>
              <p>description</p>
              <button type="button" className="c-btn">Voir le producteur</button>
            </div>
          </div>
        </div>

        <div className="c-produit_other">
          <h2>Nos autres produits</h2>

        </div>
      </div>
    </div>
  )
}
