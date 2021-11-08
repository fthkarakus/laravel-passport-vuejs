import Vue from 'vue';
import Router from 'vue-router';
import Dashboard from "./views/Dashboard";

import * as auth from "./services/auth_service";

Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'login',
        component: () => import ("./views/authentication/Login"),
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next();
            } else {
                next('/dashboard');
            }
        }
    },
    {
        path: '/dashboard',
        component: Dashboard,
        children: [
            {
                path: '/',
                name: 'welcome',
                component: () => import('./views/Welcome')
            },
            {
                path: '/profile',
                name: 'profile',
                component: () => import('./views/Profile')
            },
        ],
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login');
            } else {
                next();
            }
        }
    },
    {
        path: '/register',
        name: 'register',
        component: () =>  import ("./views/authentication/Register")
    },
    {
        path: '/login',
        name: 'login',
        component: () => import ("./views/authentication/Login"),
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next();
            } else {
                next('/dashboard');
            }
        }
    }
];

const router = new Router({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'active'
})

export default router;
