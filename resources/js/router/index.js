import { createRouter, createWebHistory } from 'vue-router'
import Login from "../pages/Login.vue";
import Register from "@/pages/Register.vue";

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router
