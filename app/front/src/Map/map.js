import React, { useRef, useEffect, useState, useMemo, useCallback  } from 'react';
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
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
import PRODUCTEURS from "./producteurs.json";
import './style/map.css';




export default function Maps(){

  const [viewport, setViewport] = useState({longitude: 2.2593178,latitude: 48.9242932, zoom: 20})
  const [popupInfo, setPopupInfo] = useState(null);



  const TOKEN = "pk.eyJ1IjoibWFtYTA1IiwiYSI6ImNsMzhvY2owZDAxczIzanIzcGVoNG40Z28ifQ.avQ6w6qf5IdFBhR9FwHPJg";

  Geocode.setApiKey("AIzaSyA5IRiB_nXYM292tyLH1syvdWMhB1o9gVQ");
  Geocode.setLanguage("fr");
  Geocode.setRegion("fr");
  Geocode.setLocationType("ROOFTOP");
  Geocode.enableDebug();

  function Pin({}) {
    return (
      <div className="c-pin">
        <span className="c-pin_circle"></span>
      </div>
   );
  }

  {/*function setAddress(city){
    let Data = () => {
      return Geocode.fromAddress(city).then((response) => {
        return response.results[0].geometry.location;
      });
    }

    let dataLocation = Data();

    return dataLocation
    .then((result) {
       result;// "Some User token"
    }).then((res) => {
      return res;
    })
  }*/}

  console.log(setAddress("Eiffel Tower"));

  const pins = useMemo(
    () =>
      PRODUCTEURS.map((item, index) => (
          <Marker
            key={`marker-${index}`}
            longitude={0}
            latitude={0}
            anchor="bottom"
            onClick={e => {
              // If we let the click event propagates to the map, it will immediately close the popup
              // with `closeOnClick: true`
              e.originalEvent.stopPropagation();
              setPopupInfo(item);
            }}
          >
            <Pin />
        </Marker>
      )),
    []
  );

  const geocoderContainerRef = useRef();
  const mapRef = useRef();

  const handleViewportChange = useCallback(
    (newViewport) => setViewport(newViewport),
    []
  );


  return(
    <div className="c-section">
      <div ref={geocoderContainerRef} style={{ position: "absolute", top: 20, left: 20, zIndex: 1 }} />
        <Map ref={mapRef} initialViewState={{longitude: 2.2593178, latitude: 48.9242932, zoom: 12}} onViewportChange={() => console.log("change")} style={{width: 1280, height: 700}} mapStyle="mapbox://styles/mapbox/streets-v9" mapboxAccessToken={TOKEN}>
            <GeolocateControl position="top-right" />
            <FullscreenControl position="top-right" />
            <NavigationControl position="top-right" />
            <ScaleControl />

            {/*<Geocoder
              mapRef={mapRef}
              containerRef={geocoderContainerRef}
              onViewportChange={handleViewportChange}
              mapboxApiAccessToken={TOKEN}
              position="top-left"
            />*/}

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
    </div>
  )
}
