import {http, httpFile} from "./http_service";
import store from "../store";

export function register(user) {
    return http().post('/auth/register', user);
}

export function login(user) {
    return http().post('/auth/login', user)
        .then(response => {
            if(response.status ===200) {
                setToken(response.data)
            }

            return response.data;
        });
}

function setToken(user) {
    localStorage.setItem('turkai-token', JSON.stringify(user));
    store.dispatch('authenticate', user.user);
}

export function isLoggedIn() {
    const token = localStorage.getItem('turkai-token');
    return token != null;
}

export function logout() {
    http().get('/auth/logout');
    localStorage.removeItem('turkai-token');
}

export  function getAccessToken() {
    const token = localStorage.getItem('turkai-token');
    if(!token) {
        return null;
    }
    const tokenData = JSON.parse(token);

    return tokenData.access_token;
}
