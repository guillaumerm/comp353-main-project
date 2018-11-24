import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import EmployeeLgoin from './views/EmployeeLogin.vue'
import ClientLogin from './views/ClientLogin.vue'
import ClientRegister from './views/ClientRegister.vue'
import ClientAccounts from './views/ClientAccounts.vue'
import ClientSendMoney from './views/ClientSendMoney.vue'
import ClientTransferMoney from './views/ClientTransferMoney.vue'
import store from './store'

Vue.use(Router)

function requireClientAuth (to, from, next) {
  if (!store.getters.loggedIn) {
    next('/client/login')
  } else {
    next();
  }
}

function noAuthAllowed (to, from, next) {
  if(store.getters.loggedIn) {
    next('/')
  } else {
    next();
  }
}

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/client/login',
      name: 'client-login',
      component: ClientLogin,
      beforeEnter: noAuthAllowed
    },
    {
      path: '/client/register',
      name: 'client-register',
      component: ClientRegister,
      beforeEnter: noAuthAllowed
    },
    {
      path: '/client/send-money',
      name: 'client-send-money',
      component: ClientSendMoney,
      beforeEnter: requireClientAuth
    },
    {
      path: '/client/transfer-money',
      name: 'client-transfer-money',
      component: ClientTransferMoney,
      beforeEnter: requireClientAuth
    },
    {
      path: '/employee/login',
      name: 'employee-login',
      component: EmployeeLgoin,
      beforeEnter: noAuthAllowed
    },
    {
      path: '/client/accounts',
      name: 'client-accounts',
      component: ClientAccounts,
      beforeEnter: requireClientAuth
    }
  ]
})
