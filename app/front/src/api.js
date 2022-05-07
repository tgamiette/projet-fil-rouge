const DOMAIN_API = "http://localhost:8000/api";

function axios_api_json(method, suffix_url) {
    const headers = {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    }
    if(loggedIn()){
      headers['Authorization'] = 'Bearer ' + getToken();
    }
    console.log(headers);
    return fetch(DOMAIN_API + suffix_url, {
      headers,
      method: method,
    }).then((response) => {
      console.log('res', response.json());
    })
    // .then((res) => {
    //   console.log('data', res);
    // })
    .catch((error) => console.error(error));
}

// Products
export function get_all_product() {
  return axios_api_json("GET", "/products/");
}

export function get_product(id) {
  return axios_api_json("GET", `/products/${id}`);
}

export function add_product(title : String, price: Int, quantity: Int, description: String, category: String) {
    const url = DOMAIN_API +"/products/"
    return fetch(url,{
        method:"POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            title: title,
            price: price,
            quantity: quantity,
            description: description,
            category: category
        })
    }).then((response) => {
        if(response.status===200){
            return response.json();
        }else{
            return false;
        }
    }).catch((error) => { console.error(error);return false;})
}


// Users
export function get_all_users() {
  return axios_api_json("GET", "/users");
}

export function get_user(id) {
  return axios_api_json("GET", `/user/${id}`);
}

export function add_user(email, password, name) {
    const url = DOMAIN_API +"/users"
    return fetch(url,{
        method:"POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password,
            name: name
        })
    }).then((response) => {
        if(response.status===200){
            return response.json();
        }else{
            return false;
        }
    }).catch((error) => { console.error(error);return false;})
}


export function logIn(email: String, password: String) {
    const url = DOMAIN_API +"/login_check"
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
    .then(res => {
      setToken(res.token);
      var token = getToken();
      if(token !== "undefined" && token !== undefined){
        window.location.href = `http://localhost:3001/producteurs`;
      }
    })
    .catch((error) => { console.error(error);return false;})
}

function setToken(idToken) {
   localStorage.setItem('token', idToken);
}

function getToken() {
  return localStorage.getItem('token');
}

function loggedIn() {
   const token = getToken();
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

//Customers
export function get_all_customers() {
  return axios_api_json("GET", "/customers");
}

export function get_customer(id) {
  return axios_api_json("GET", `/customers/${id}`);
}
