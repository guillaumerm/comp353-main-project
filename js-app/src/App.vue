<template>
  <v-app id="app">
    <v-toolbar app>
      <v-toolbar-title class="headline text-uppercase">
        <span>DATA</span>
        <span class="font-weight-light">BANK</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <template v-if="loggedIn">
        <v-btn flat :to="{name: 'client-accounts'}">
          <v-icon>account_balance</v-icon>
          Accounts
        </v-btn>
        <v-btn flat :to="{name: 'client-send-money'}">
          <v-icon>attach_money</v-icon>
          Send money
        </v-btn>
        <v-btn flat :to="{name: 'client-make-payments'}">
          <v-icon>contact_mail</v-icon>
          Make payment
        </v-btn>
        <v-btn flat :to="{name: 'client-transfer-money'}">
          <v-icon>transform</v-icon>
          Transfer money
        </v-btn>
        <v-btn flat v-on:click="logout()">
          Logout
        </v-btn>
      </template>
      <template v-else-if="employeeLoggedIn">
        <v-btn flat :to="{name: 'employee-info'}">
          Employee Info
        </v-btn>
        <v-btn flat v-on:click="logout()">
          Logout
        </v-btn>
      </template>
      <template v-else>
         <v-btn :to="{name: 'client-login'}">
            Login
          </v-btn>
          OR
          <v-btn color="primary" :to="{name: 'client-register' }">
            Rgister
          </v-btn>
      </template>
    </v-toolbar>

    <v-content>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>
import AuthService from '@/services/AuthService.js'

export default {
  name: 'App',
  data () {
    return {
      //
    }
  },
  computed: {
    loggedIn(){
      return this.$store.getters.loggedIn;
    },
    employeeLoggedIn(){
      return this.$store.getters.employeeLoggedIn
    }
  },
  methods: {
    logout() {
      AuthService.clientLogout().then(
        (response) => {
          this.$store.dispatch('logout')
          this.$router.push('/');
        }
      ).catch(
        (error) => {
          console.err(error)
        }
      )
    }
  }
}
</script>

<style>
#app{
  background-image: url("./assets/globe.jpg");
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>

