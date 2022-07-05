const DOMAIN_API = "http://localhost:8000/api";

function axios_api_json(method, suffix_url) {
    let auth;

    if(loggedIn()){
      auth = getCookie('user_token');
    }
    else{
      auth = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTcwMTIwNDQsImV4cCI6MzAwMDAxNjU3MDEyMDQ0LCJyb2xlcyI6WyJST0xFX0FETUlOIiwiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYWRtaW5AZ21haWwuY29tIn0.IDjGf6dIKbdjLOUJUITF7lL-c1b4zmWmXIrold7GolOOVbJwMmJo9FueN1Uovt5koyBz59SutNWTQBUExXO_GY5emBHxSEvZzj_0bZ7PmX2FrDYsa-b9HH0nFY4m63-2k8h28fqr42mSzy_m4rZTrUQ_IRjvCebNIDRaxHW74k6iMPD3aL-hgQsbfOKfYArrWpOqvdwTQx52xzBQZsk8qEHQp59Fx7pwp3-Y4FWioELPNpctC2_IBFGw6M_f2uMTfKYQGdQMcMvGvlAGy94dPcj7m3Q-DjbdnbQUr2EqF4-u_eXVrzyXPsU1XBnU3rD4O1hrH7v1vXkS8f-PVF91HQ";
    }

    console.log(auth);
    var myHeaders = new Headers();
    myHeaders.append("Authorization", `Bearer ${auth}`);
    myHeaders.append("Content-Type", "application/json");

    var raw = JSON.stringify({});

    var requestOptions = {
      method: 'GET',
      headers: myHeaders,
      redirect: 'follow'
    };

    return fetch(DOMAIN_API+suffix_url, requestOptions)
    .then(response => response.json())
    .then((result) => result)
    .catch(error => console.log('error', error));
}

// Products
export function get_all_product() {
  return axios_api_json("GET", "/products?page=3");
}

export function get_product(id) {
  return axios_api_json("GET", `/products/${id}`);
}

export function get_product_by_seller(id) {
  return axios_api_json("GET", `/products?seller=${id}`);
}

export function get_product_by_category(id) {
  return axios_api_json("GET", `/products?category=${id}`);
}

export function add_product(title : String, description: String, price: Int, quantity: Int, category: String, file: Arr, objective: Int) {
    const url = DOMAIN_API +"/products";
    let auth;

    if(loggedIn()){
      auth = getCookie('user_token');
    }

    const formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    formData.append('price', price);
    formData.append('quantity', quantity);
    formData.append("file", file, "cap.png");
    formData.append('category', category);
    formData.append('objective', objective);

    console.log(formData);


    return fetch(url,{
        method:"POST",
        headers: {
            'Authorization': `Bearer ${auth}`
        },
        body: formData,
        redirect: 'follow'
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
        if(result.status===200){
            window.location.href = `http://localhost:3001/account/produits`;
        }else{
            return false;
        }
    })
    .catch(error => console.log('error', error));
}

// Categories

export function get_all_categories() {
  return axios_api_json("GET", `/categories/`);
}

export function get_categorie(id) {
  return axios_api_json("GET", `/categories/${id}`);
}


// Producteurs
export function get_all_producteurs() {
  return axios_api_json("GET", "/users");
}

export function get_producteur(id) {
  return axios_api_json("GET", `/users/${id}`);
}

//Customers
export function get_all_customers() {
  return axios_api_json("GET", "/customers");
}

export function get_customer(id) {
  return axios_api_json("GET", `/customers/${id}`);
}


// Orders
export function get_all_orders_users() {
  return axios_api_json("GET", "/order_users");
}

export function get_order_user(id) {
  return axios_api_json("GET", `/order_users/${id}`);
}

export function set_order_user(){
  const url = DOMAIN_API +"/order_users";
  let auth;

  if(loggedIn()){
    auth = getCookie('user_token');
  }

  return fetch(url,{
      method:"POST",
      headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${auth}`
      },
      body: JSON.stringify({
        "products": {
          "40": 3,
          "45": 2
        }}
      )
  })
  .then((res) => res.json())
  .then((data) => data)
  .catch((error) => { console.error(error);return false;})
}

// Users
export function get_all_users() {
  return axios_api_json("GET", "/users");
}

export function get_user(id) {
  return axios_api_json("GET", `/users/${id}`);
}

export function add_user(email, password, name) {
    const url = DOMAIN_API +"/users"
    console.log('email', password);
    return fetch(url,{
        method:"POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password,
            fullName: name
        })
    })
    .then(response => response.json())
    // .then(res => console.log(res))
    .catch((error) => { console.error(error);return false;})
}


export function logIn(email: String, password: String) {

    const url = DOMAIN_API +"/login_check";
    return fetch(url,{
        method:"POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(response => response.json())
    .then(res => res)
    .catch((error) => { console.error(error);return false;})
}


export function setToken(idToken) {
  setCookie('user_token', idToken, 1);
}

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

export function eraseCookie(cname) {
    document.cookie = cname+'=; Max-Age=-99999999;';
}

export function getCookie(cname) {
    var nameEQ = cname + "=";
    var ca = document.cookie.split(';');

    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        return c.substring(nameEQ.length,c.length);
    }
    return null;
}

export function loggedIn() {
   const token = getCookie("user_token");
   return !!token && !isTokenExpired(token);
}

function isTokenExpired(token){
  try{
    const jwt = parseJwt(token);
    if(jwt.exp < Date.now() / 1000){
      return true;
    }else return false;
  }catch(error){
    return false;
  }
}

function parseJwt(token) {
   try {
     return JSON.parse(atob(token.split('.')[1]));
   } catch (e) {
     return null;
   }
 };
