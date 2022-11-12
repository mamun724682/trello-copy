import axios from "axios";
import router from "@/router";

export const isLoggedIn = localStorage.getItem('isLoggedIn') == 'true'  ? true : false;
export const authUser = localStorage.getItem('authUser') ?? null;
export let errors = null;
export const login = async (credential) => {
    await axios.post('/api/v1/login', credential)
        .then(res => {
            // Set token and user
            localStorage.setItem('token', res.data.data.access_token);
            localStorage.setItem('authUser', JSON.stringify(res.data.data.auth_user));
            localStorage.setItem('isLoggedIn', true);

            // Redirect to
            router.push({name: 'Projects'});
        })
        .catch(({response}) => {
            if (response.data.data){
                errors = response.data.data
            }
        })
}
export const register = async (credential) => {
    await axios.post('/api/v1/register', credential)
        .then(res => {
            // Set token and user
            localStorage.setItem('token', res.data.data.access_token);
            localStorage.setItem('authUser', JSON.stringify(res.data.data.auth_user));
            localStorage.setItem('isLoggedIn', true);

            // Redirect to
            router.push({name: 'Projects'});
        })
        .catch(({response}) => {
            if (response.data.data){
                errors = response.data.data
            }
        })
}

export const getAuthUser = async () => {
    await axios.get('/api/v1/auth-user')
        .then(res => {
            // Set user
            localStorage.setItem('authUser', JSON.stringify(res.data.data.auth_user));
        })
        .catch(({response}) => {
            if (response.data.data){
                errors = response.data.data
            }
        })
}

export const logout = async () => {
    await axios.get('/api/v1/logout')
        .then(res => {
            localStorage.setItem('token', null);
            localStorage.setItem('authUser', null);
            localStorage.setItem('isLoggedIn', false);

            // Redirect to
            router.push({name: 'Login'});
        })
        .catch(({response}) => {
            if (response.data.data){
                errors = response.data.data
            }
        })
}
