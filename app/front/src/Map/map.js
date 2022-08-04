import React, {useRef, useEffect, useState, useMemo, useCallback} from 'react';
// import mapboxgl from 'mapbox-gl';
import { Link } from "react-router-dom";
import Map, {
  Marker,
  Popup,
  NavigationControl,
  FullscreenControl,
  ScaleControl,
  GeolocateControl
} from 'react-map-gl';
import Geocode from "react-geocode";
import Geocoder from "react-map-gl-geocoder";
import PRODUCTEURS from "./producteurs.json";
import {useWaitFor} from '../shared/hooks';
import {get_all_producteurs} from '../api';

import './style/map.css';
import 'mapbox-gl/dist/mapbox-gl.css';


export default function Maps(){

  const [viewport, setViewport] = useState({longitude: 2.2593178,latitude: 48.9242932, zoom: 13, transitionDuration: 1000})
  const [popupInfo, setPopupInfo] = useState(null);
  const [coord, setCoord] = useState([]);
  const [change, setChange] = useState(false);
  const [producteurs, setProducteurs] = useState([]);


  const TOKEN = "pk.eyJ1IjoibWFtYTA1IiwiYSI6ImNsMzhvY2owZDAxczIzanIzcGVoNG40Z28ifQ.avQ6w6qf5IdFBhR9FwHPJg";

  Geocode.setApiKey("AIzaSyA5IRiB_nXYM292tyLH1syvdWMhB1o9gVQ");
  Geocode.setLanguage("fr");
  Geocode.setRegion("fr");
  Geocode.setLocationType("ROOFTOP");
  Geocode.enableDebug();

  function Pin({}){
    return (
      <div className="c-pin">
        <span className="c-pin_circle"></span>
      </div>
   );
  }

 const setAddress = (city) => {
   return Geocode.fromAddress(city).then(
     (response) => {
       const { lat, lng } = response.results[0].geometry.location;
       return lng;
     }, (error) => {
       console.error(error);
     }
   );
 }

 useEffect(() => {
   setAddress();
   setCoord(coord);
 }, [change]);

 useWaitFor(
   () => get_all_producteurs(),[],(res) => {
     if(res !== undefined){
       setProducteurs(res['hydra:member']);
     }

   }
 );


   console.log('address', setAddress("Eiffel tower").then((res) => {
     return res;
   }).then(function(res) {
     return res // 2 - A synchronous value works
   }));

  const pins = useMemo(() =>
      PRODUCTEURS.map((item, index) => (
        <>
          <Marker
            key={`marker-${index}`}
            longitude={2.45}
            latitude={48.9242932}
            anchor="top"
            onClick={e => {
              // If we let the click event propagates to the map, it will immediately close the popup
              // with `closeOnClick: true`
              e.originalEvent.stopPropagation();
              setPopupInfo(item);
            }}
            >
            <Pin />
          </Marker>
      </>
    )),[]);

  const geocoderContainerRef = useRef();
  const mapRef = useRef();

  const handleViewportChange = useCallback((newViewport) => {
      setViewport(newViewport)
      console.log(newViewport);
    },[]);

  const handleGeocoderViewportChange = useCallback(
    (newViewport) => {
      const geocoderDefaultOverrides = { transitionDuration: 1000};

      return handleViewportChange({
        ...newViewport,
        ...geocoderDefaultOverrides
      });
    },
    []
  );


  return(
    <div className="c-container_map">
      <div className="c-section">
        <div ref={geocoderContainerRef} style={{ position: "absolute", top: 20, left: 20, zIndex: 1 }}></div>
          {
            <Map ref={mapRef} {...viewport} initialViewState={{longitude: 2.2593178, latitude: 48.9242932, zoom: 12}} onViewportChange={handleViewportChange} style={{width: 1280, height: 800}} mapStyle="mapbox://styles/mapbox/streets-v9" mapboxAccessToken={TOKEN}>
              <GeolocateControl position="top-right" />
              <FullscreenControl position="top-right" />
              <NavigationControl position="top-right" />
              <ScaleControl />
              <Geocoder
                mapRef={mapRef}
                containerRef={geocoderContainerRef}
                onViewportChange={handleGeocoderViewportChange}
                mapboxApiAccessToken={TOKEN}
                position="top-right"
              />

              {pins}
              {popupInfo && (
                <Popup
                  anchor="top"
                  longitude={Number(viewport.longitude)}
                  latitude={Number(viewport.latitude)}
                  onClose={() => setPopupInfo(null)}
                >
                  <img width="100%" src={popupInfo.img} />
                  <div className="c-popup_infos">
                    {popupInfo.ville} | {popupInfo.address}
                    <Link to={`/producteur/${popupInfo.id}`} className="c-btn">En savoir plus</Link>
                  </div>

                </Popup>
              )}
         </Map>
       }
      </div>

      <div className="c-producteurs_div">
        {
          producteurs.map((item, index) => {
            console.log(item);
            return(
              <>
                {
                  item["roles"][0] === "ROLE_SELLER" ?
                    <div>
                      <span className="c-producteur_img">
                        <img src="https://icons-for-free.com/download-icon-man+person+profile+user+worker+icon-1320190557331309792_512.png" alt="" />
                      </span>
                      <p>{item.fullName}</p>
                      <Link to={`/producteur/${item['id']}`} className="c-btn">Découvrir</Link>
                    </div>
                    :
                    null
                }
              </>
            )

          })
        }
      </div>
    </div>
  )
}
