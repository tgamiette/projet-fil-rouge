const DOMAIN_API = "http://localhost:8000/api";

function axios_api_json(method, suffix_url) {
    let auth;
    if(loggedIn()){
      auth = getToken();
    }

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTIwNDQwNDgsImV4cCI6MTY1NTA0NDA0OCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFkbWluQGdtYWlsLmNvbSJ9.j8p-2RSmCDJ7izvgd6zgETSUwcFfDGIbNbCjCtESU2P6OO_rMeeI43NRldvHFTqd57glUqjdAnbUjRL39Q2VV8SUAsNnJIxuW3oY1QCp2KzHXptmJWlBiuuMPOuKvrjGU9a-Z8Zw7-Skc6J0qG1g5RqcPxuqJcr6CZuJAngSLHwTpUM3WylLB269ljDfeLu0MFaF2etXKFGo3wHno7vzgKGMc4Nm9ZL4ajloTniIiSr4rFvYHUMXGuxCwiqYIb1kqEf8c0V9f8X9B9LTgcvltmBLHGru6bjui687WEDEKsaLEyUnjHU9Kix8wwgUpsNXdmnOoEMAp00BscoiEArMEw");
    myHeaders.append("Content-Type", "application/json");

    var raw = JSON.stringify({});

    var requestOptions = {
      method: 'GET',
      headers: myHeaders,
      redirect: 'follow'
    };

    fetch(DOMAIN_API + suffix_url, requestOptions)
    .then(response => response.text())
    .then(result => console.log(result))
    .catch(error => console.log('error', error));
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

export function unsetToken() {
  const token = getToken();
  localStorage.removeItem('token', token);
  window.location.href = `http://localhost:3001/login`;
}

function setToken(idToken) {
   localStorage.setItem('token', idToken);
}

export function getToken() {
  return localStorage.getItem('token');
}

export function loggedIn() {
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
