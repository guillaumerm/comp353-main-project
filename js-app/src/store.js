import Vue from 'vue'
import Vuex from 'vuex'
import ClientService from '@/services/ClientService.js'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loggedIn: false,
    employeeLoggedIn: false,
    accounts: null,
    awaitingFunds: null
  },
  getters: {
    loggedIn: state => state.loggedIn,
    accounts: state => state.accounts,
    awaitingFunds: state => state.awaitingFunds
  },
  mutations: {
    setLoggedIn(state, loggedIn){
      state.loggedIn = loggedIn
    },
    setEmployeeLoggedIn(state, loggedIn){
      state.employeeLoggedIn = loggedIn
    },
    setAccounts(state, accounts){
      state.accounts = accounts
    },
    setAwaitingFunds(state, awaitingFunds) {
      state.awaitingFunds = awaitingFunds
    }
  },
  actions: {
    fetchAwaitingFunds() {
      ClientService.clientAwaitingFunds().then(
        (response) => {
          this.commit('setAwaitingFunds', response.data)
        }
      ).catch(
        (error) => {
          this.commit('setAwaitingFunds', null)
          console.log(error)
        }
      )
    },
    fetchAccounts() {
      ClientService.clientAccounts().then(
        (response) => {
          this.commit('setAccounts', response.data)
        }
      ).catch(
        (error) => {
          this.commit('setAccounts', null)
          console.error(error)
        }
      )
    },
    login() {
      this.commit('setLoggedIn', true)
    },
    login() {
      this.commit('setEmployeeLoggedIn', true)
    },
    logout() {
      this.commit('setLoggedIn', false)
      this.commit('setAccounts', null)
    }
  }
})
