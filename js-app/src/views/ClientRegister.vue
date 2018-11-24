<template>
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>

            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Register As A New Client</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                          <v-alert
                            :value="true"
                            type="error"
                            v-if="errors.length > 0"
                            >
                            <ul>
                            <li v-for="(error, index) in errors" :key="index">{{error.message}}</li>
                            </ul>
                            </v-alert>
                          <v-alert
                            :value="true"
                            type="success"
                            v-if="success"
                            >
                                Thank you for registering!
                            </v-alert>
                  <v-form>
                <v-stepper v-model="step" v-if="!success">
                    <v-stepper-header>
                    <v-stepper-step :complete="step > 1" step="1">Personal Information</v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step :complete="step > 2" step="2">Address </v-stepper-step>
                    </v-stepper-header>

                    <v-stepper-items>
                        <v-stepper-content step="1">
                                <v-text-field prepend-icon="person" name="first_name" label="First Name" type="text" v-model="first_name" required></v-text-field>
                                <v-text-field prepend-icon="person" name="last_name" label="Last Name" type="text" v-model="last_name" required></v-text-field>
                                <v-text-field prepend-icon="email" name="email" label="Email" type="email" v-model="email" required></v-text-field>
                                <v-select :items="GENDERS" label="Gender" v-model="gender" required></v-select>
                                <v-select :items="CLIENT_TYPE" label="Client Type" v-model="client_category_id" required></v-select>
                                <v-text-field prepend-icon="phone" name="phone_number" label="Phone Number" type="number" minlength="8" maxlength="8" v-model="phone_number" required></v-text-field>
                                    <v-menu
                                        ref="menu"
                                        :close-on-content-click="false"
                                        v-model="menu"
                                        :nudge-right="40"
                                        :return-value.sync="dob"
                                        lazy
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        min-width="290px"
                                    >
                                        <v-text-field
                                        slot="activator"
                                        v-model="dob"
                                        label="Date of Birth"
                                        prepend-icon="event"
                                        readonly
                                        ></v-text-field>
                                        <v-date-picker v-model="dob" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                        <v-btn flat color="primary" @click="$refs.menu.save(dob)">OK</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                <v-text-field id="password" prepend-icon="lock" name="password" label="Password" type="password" v-model="password"></v-text-field>
                            <v-btn
                            color="primary"
                            @click="step = 2"
                            block
                            >
                            Continue
                            </v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <v-text-field prepend-icon="place" name="street" label="Street" type="text" v-model="street"></v-text-field>
                            <v-text-field name="apt" label="Apt./Local" type="text" v-model="apt"></v-text-field>
                            <v-text-field name="city" label="City" type="text" v-model="city"></v-text-field>
                            <v-select :items="PROVINCES" label="Province" v-model="province"></v-select>
                            <v-text-field name="postal_code" label="Postal Code" type="text" v-model="postal_code"></v-text-field>
                            <v-btn @click="step = 1" block>Go Back</v-btn>
                            <v-btn
                            color="primary"
                            @click="register()"
                            block
                            >
                            Register
                            </v-btn>
                        </v-stepper-content>
                    </v-stepper-items>
                </v-stepper>
                  </v-form>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
</template>

<script>
import AuthService from '@/services/AuthService.js'
export default {
    name: 'client-register',
    data: ()=>{
        return {
            GENDERS: [ 'M', 'F', 'U' ],
            PROVINCES: [ 'AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'NT', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT' ],
            CLIENT_TYPE: [ { text: 'Personal', value: 1 } ],
            first_name: null,
            last_name: null,
            email: null,
            phone_number: null,
            client_category_id: null,
            gender: null,
            dob: null,
            password: null,
            street: null,
            apt: null,
            city: null,
            postal_code: null,
            province: null,
            menu: false,
            step: 0,
            success: false,
            errors: []
        }
    },
    methods: {
        register() {
            var payload = {
                first_name: this.first_name,
                last_name: this.last_name,
                email: this.email,
                gender: this.gender,
                phone_number: this.phone_number,
                dob: this.dob,
                password: this.password,
                street: this.street,
                city: this.city,
                postal_code: this.postal_code,
                province: this.province,
                client_category_id: this.client_category_id
            }

            if(this.apt != null) {
                payload.apt = this.apt;
            }
            AuthService.clientRegister(payload).then(
                (response) => {
                    this.sucess = true;
                    this.$store.dispatch('login');
                }
            ).catch(
                (error) => {
                    if (error.response.status == 400) {
                        var i = 0;
                        for(i = 0; i < error.response.data.errors.length; i++){
                            this.$set(this.errors, i, error.response.data.errors[i]);
                        }
                    }
                }
            );
        }
    }
}
</script>

