const DOMAIN_API = "http://localhost:8000/api";

function axios_api_json(method, suffix_url) {
    const headers = {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    }
    const options = {
      method: method
    }
    if(this.loggedIn()){
      headers['Authorization'] = 'Bearer' + this.getToken();
    }
    return fetch(DOMAIN_API + suffix_url, {
      headers,
      ...options,
    }).then((response) => {
        return response.json();
    }).catch((error) => console.error(error));
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
    .then((response) => {
      return response.json()
    })
    .then((data) => {
      setToken(data.token);
    })
    .catch((error) => { console.error(error);return false;})
}

function setToken(idToken) {
   // Saves user token to localStorage
   localStorage.setItem('id_token', idToken);
}

function getToken() {
  return localStorage.getItem('id_token');
}

function loggedIn() {
   const token = this.getToken();
   return !!token && !this.isTokenExpired(token);
}

function isTokenExpired(token){
  try{
    const jwt = jwt(token);
    if(jwt.exp < Date.now() / 1000){
      return true;
    }else return false;
  }catch(error){
    return false;
  }
}

//Customers
export function get_all_customers() {
  return axios_api_json("GET", "/customers");
}

export function get_customer(id) {
  return axios_api_json("GET", `/customers/${id}`);
}
