<template>
    <v-content>
        <v-container>
            <v-layout align-center justify-center>
                <v-flex xs12 sm10 md10>
                    <v-card>
                        <v-container>
                            <v-toolbar flat color="white">
                            <v-toolbar-title>Make Payment</v-toolbar-title>
                            <v-divider
                                class="mx-2"
                                inset
                                vertical
                            ></v-divider>
                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <v-btn slot="activator" color="primary" dark class="mb-2">
                                    <v-icon>add</v-icon>
                                    Add Payee
                                </v-btn>
                                <v-card>
                                <v-card-title>
                                    <span class="headline">Adding Payee</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12 sm6 md4>
                                           <v-text-field v-model="new_payee.name" label="Payee's Name"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-text-field v-model="new_payee.account_no" label="Payee's Account #"></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" flat @click="dialog = !dialog">Cancel</v-btn>
                                    <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
                                </v-card-actions>
                                </v-card>
                            </v-dialog>
                            </v-toolbar>
                            <v-alert :value="success" type="success">
                                Payment is being process
                            </v-alert>
                            <table border="1px solid black">
                                <thead>
                                    <th>Payee</th>
                                    <th>From Account</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(payee, index) in payees" :key="index">
                                        <td>
                                            <strong>Payee's Name:</strong>{{ payee.name }}<br>
                                            <em>Payee's Account:</em>{{ payee.account_no }}
                                        </td>
                                        <td>
                                            <v-select prepend-icon="account_balance" :items="accounts" label="Destination Account" v-model="payee.from_account_no" :item-text="accountText" item-value="account_no"></v-select>
                                        </td>
                                        <td class="text-xs-right">
                                            <v-text-field type="date" v-model="payee.date" outline></v-text-field>                                  
                                        </td>
                                        <td class="text-xs-right"><v-text-field type="number" label="Amount" v-model="payee.amount"></v-text-field></td>
                                </tr>
                            </tbody>
                            <tfooter>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="makePayment()">Make Payments</v-btn>
                            </tfooter>
                            </table>
                        </v-container>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
import ClientService from '@/services/ClientService.js'
export default {
    name: 'client-accounts',
    data: () => {
        return {
            payees: null,
            dialog: false,
            success: false,
            new_payee: {
                account_no: null,
                name: null
            }
        }
    },
    created() {
        ClientService.clientGetPayees().then(
            (response) => {
                this.payees = response.data
            }
        ).catch(
            (error) => {
                console.error(error)
            }
        )
    },
    computed: {
        accounts() {
            return this.$store.getters.accounts
        },
        calculateTotal() {
            var sum = 0;
            
            if(payees == null) {
                return sum
            }

            for(var i = 0; i < payees.length; i++) {
                sum += amonut
            }

            return sum
        }
    },
    methods: {
        accountText: item => item.type + ' ' + item.account_no,
        fetchPayees() {
            ClientService.clientGetAccountTypes().then(
            (response) => {
                this.account_types = response.data
            }
            ).catch(
                (error) => {
                    console.error(error)
                }
            )
        },
        makePayment() {
            ClientService.clientMakePayment(this.payees).then(
                (response) => {
                    this.success = true;
                    setTimeout(function(){
                        this.success = false
                    }, 3000)
                }
            ).catch(
                (error) => {
                    console.error(error)
                }
            )
        },
        save() {
            ClientService.clientAddPayee(this.new_payee).then(
                (response) => {
                    this.fetchPayees()
                }
            ).catch(
                (error) => {
                    console.error(error)
                }
            )
        }
    }
}
</script>
