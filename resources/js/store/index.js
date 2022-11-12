import axios from 'axios';
import {createStore} from 'vuex'
import sharedMutations from 'vuex-shared-mutations';


export default createStore({
    state() {
        return {
            user: null
        }
    },
    getters: {
        user(state) {
            return state.user;
        },
        id(state) {
            if (state.user) return state.user.id
            return null
        }
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        }
    },

    actions: {
        async login({dispatch}, payload) {
            try {
                await axios.post('/api/v1/login', payload).then((res) => {
                    localStorage.setItem('token', res.data.data.access_token)
                    return dispatch('getUser');
                }).catch((err) => {
                    throw err.response
                });
            } catch (e) {
                throw e
            }
        },

        async register({dispatch}, payload) {
            try {
                await axios.post('/api/v1/register', payload).then((res) => {
                    localStorage.setItem('token', res.data.data.access_token)
                    return dispatch('login', {'email': payload.email, 'password': payload.password})
                }).catch((err) => {
                    throw(err.response)
                })
            } catch (e) {
                throw (e)
            }
        },
        async logout({commit}) {
            await axios.get('/api/v1/logout').then((res) => {
                localStorage.setItem('token', null)
                commit('setUser', null);
            }).catch((err) => {

            })
        },
        async getUser({commit}) {
            axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
            await axios.get('/api/v1/auth-user').then(({data}) => {
                commit('setUser', data.data);
            }).catch(({response}) => {
                commit('setUser', null);
                // throw response
            })
        },
    },
    plugins: [sharedMutations({predicate: ['setUser']})],
})
