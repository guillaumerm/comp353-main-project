import Vue from 'vue'
import Vuex from 'vuex'
import ClientService from '@/services/ClientService.js'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loggedIn: false,
    accounts: null
  },
  getters: {
    loggedIn: state => state.loggedIn,
    accounts: state => state.accounts
  },
  mutations: {
    setLoggedIn(state, loggedIn){
      state.loggedIn = loggedIn
    },
    setAccounts(state, accounts){
      state.accounts = accounts
    }
  },
  actions: {
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
      this.dispatch('fetchAccounts')
    },
    logout() {
      this.commit('setLoggedIn', false)
      this.commit('setAccounts', null)
    }
  }
})
