import {http, httpFile} from "./http_service";


export function loadProfile() {
    return http().get('/auth/profile');
}

export function updateProfile(id, data) {
    return http().post(`/auth/profile/${id}`,data)
}
