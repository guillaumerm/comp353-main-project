<template>
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Employee Login</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-alert>

                </v-alert>
                <v-form>
                  <v-text-field prepend-icon="person" name="login" label="Login" type="text" v-model="identity"></v-text-field>
                  <v-text-field id="password" prepend-icon="lock" name="password" label="Password" type="password" v-model="password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :to="{name: 'client-login'}" flat>Are you a client?</v-btn>
                <v-btn color="primary" v-on:click="submit()">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
</template>

<script>
import AuthService from '@/services/AuthService.js'

export default {
    data: () => {
        return {
            identity: null,
            password: null
        }
    },
    methods: {
        submit(){
          AuthService.clientLogin({identity: this.identity, password: this.password}).then(
            (response) => {
              this.$store.dispatch('login');
            }
          ).catch(
            (error) => {
              console.log(error)
            }
          )
        }
    }
}
</script>

