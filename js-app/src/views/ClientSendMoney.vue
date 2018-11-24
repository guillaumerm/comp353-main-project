<template>
    <v-content>
        <v-container fluid fill-height>
                <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-12">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Send Money Fast</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-alert type="danager" v-if="error">
                            {{error}}
                        </v-alert>
                        <v-form>
                            <v-select prepend-icon="account_balance" :items="accounts" label="Originating Account" v-model="from_account_no" :item-text="accountText" :item-value="account_no"></v-select>
                            <v-text-field prepend-icon="attach_money" v-model="amount" type="number" label="Amount"></v-text-field>
                            <v-text-field prepend-icon="email" v-model="email" type="email" label="Recipient's email"></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" v-on:click="submit()">Send Money</v-btn>
                    </v-card-actions>
                    </v-card>
                </v-flex>
                </v-layout>
            </v-container>
    </v-content>
</template>

<script>
import ClientService from '@/services/ClientService.js'

export default {
    computed: {
        accounts() {
            return this.$store.getters.accounts
        }
    },
    data: () => {
        return {
            from_account_no: null,
            amount: null,
            email: null,
            error: null
        }
    },
    methods: {
        accountText: item => item.type + ' ' + item.account_no,
        submit() {
            this.error = null
            var transfer = {
                from_account_no: this.from_account_no,
                amount: this.amount,
                email: this.email
            }
            ClientService.clientSendMoney(transfer).then(
                (response) => {

                }
            ).catch(
                (error) => {
                    if(error.response.status == 400) {
                        this.error = error.response.data.error;
                    } else {
                        console.log(error)
                    }
                }
            )
        }
    }
}
</script>

