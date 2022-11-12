import Login from "@/pages/auth/Login.vue";
import Register from "@/pages/auth/Register.vue";
import Dashboard from "@/pages/Dashboard.vue";
import Projects from "@/pages/Projects.vue";
import NotFound from "@/pages/NotFound.vue";
import ApiUsers from "@/pages/ApiUsers.vue";

export default [
    {
        path: '/',
        component: Login,
        name: 'login',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/register',
        component: Register,
        name: 'register',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/projects',
        component: Projects,
        name: 'projects',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/projects',
        component: Projects,
        name: 'projects',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/api-users',
        component: ApiUsers,
        name: 'api_users',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notfound',
        component: NotFound,
        meta: {
            guard: 'guest'
        }
    }
];
