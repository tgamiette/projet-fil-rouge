import React, {useRef, useEffect, useState, useMemo, useCallback} from 'react';
// import mapboxgl from 'mapbox-gl';
import { Link } from "react-router-dom";
import Map, {
  FlyToInterpolator,
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
import './style/map.css';
import 'mapbox-gl/dist/mapbox-gl.css';


export default function Maps(){

  const [viewport, setViewport] = useState({longitude: 2.2593178,latitude: 48.9242932, zoom: 13, transitionDuration: 1000, transitionInterpolator: new FlyToInterpolator()})
  const [popupInfo, setPopupInfo] = useState(null);

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

  function setAddress(city){
    Geocode.fromAddress(city).then(
      (response) => {
        const { lat, lng } = response.results[0].geometry.location;
        console.log(lat, lng);
      },
      (error) => {
        console.error(error);
      }
    );
  }

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

  const handleViewportChange = useCallback((newViewport) => {
      setViewport(newViewport)
      console.log(newViewport);
    },[]);

  const handleGeocoderViewportChange = useCallback(
    (newViewport) => {
      const geocoderDefaultOverrides = { transitionDuration: 1000, transitionInterpolator: new FlyToInterpolator()};

      return handleViewportChange({
        ...newViewport,
        ...geocoderDefaultOverrides
      });
    },
    []
  );


  return(
    <div className="c-section">
      <div ref={geocoderContainerRef} style={{ position: "absolute", top: 20, left: 20, zIndex: 1 }}></div>
        <Map ref={mapRef} {...viewport} initialViewState={{longitude: 2.2593178, latitude: 48.9242932, zoom: 12}} onViewportChange={handleViewportChange} style={{width: 1280, height: 700}} mapStyle="mapbox://styles/mapbox/streets-v9" mapboxAccessToken={TOKEN}>
            <GeolocateControl position="top-right" />
            <FullscreenControl position="top-right" />
            <NavigationControl position="top-right" />
            <ScaleControl />

            <Geocoder
              mapRef={mapRef}
              containerRef={geocoderContainerRef}
              onViewportChange={handleGeocoderViewportChange}
              mapboxApiAccessToken={TOKEN}
              position="top-left"
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
    </div>
  )
}
