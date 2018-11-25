<template>
    <v-content>
        <v-container fluid fill-height>
                <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-12">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Send Money Fast</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text v-if="!sucess">
                        <v-alert type="danager" :value="error">
                            {{error}}
                        </v-alert>
                        <v-form>
                            <v-select prepend-icon="account_balance" :items="accounts" label="Originating Account" v-model="from_account_no" :item-text="accountText" item-value="account_no"></v-select>
                            <v-text-field prepend-icon="attach_money" v-model="amount" type="number" label="Amount"></v-text-field>
                            <v-text-field prepend-icon="email" v-model="email" type="email" label="Recipient's email"></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-alert type="success" v-:value="sucess">
                            Your money was sent to {{email}}
                        </v-alert>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" v-on:click="submit()">Send Money</v-btn>
                    </v-card-actions>
                    </v-card>
                    <v-card class="elevation-12">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Funds Awaiting Transfer</v-toolbar-title>
                    </v-toolbar>
                    <v-select prepend-icon="account_balance" :items="accounts" label="Select Account" v-model="to_account_no" :item-text="accountText" item-value="account_no"></v-select>
                    <table>
                        <thead>
                            <th>Date sent</th>
                            <th>From</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                            <tr v-for="(awaitingFund, index) in awaitingFunds" :key="index">
                                <td>{{awaitingFund.date_sent}}</td>
                                <td>{{awaitingFund.first_name}} {{awaitingFund.last_name}}</td>
                                <td>{{awaitingFund.amount}}</td>
                                <td><v-btn block color="primary" v-on:click="acceptFunds(awaitingFund)" :disabled="!to_account_no">Accept Funds</v-btn></td>
                            </tr>
                        </tbody>
                    </table>
                    </v-card>
                </v-flex>
                </v-layout>
            </v-container>
    </v-content>
</template>

<script>
import ClientService from '@/services/ClientService.js'

export default {
    created() {
        this.$store.dispatch('fetchAwaitingFunds')
    },
    computed: {
        accounts() {
            return this.$store.getters.accounts
        },
        awaitingFunds() {
            return this.$store.getters.awaitingFunds
        }
    },
    data: () => {
        return {
            from_account_no: null,
            to_account_no: null,
            amount: null,
            email: null,
            error: null,
            success: false
        }
    },
    methods: {
        accountText: item => item.type + ' ' + item.account_no,
        acceptFunds(awaitingFund) {
            var payload = {
                fund_transfer_id: awaitingFund.fund_transfer_id,
                to_account_no: this.to_account_no
            }

            ClientService.clientReceiveFunds(payload).then(
                (response) => {
                    this.fundsAccepted
                }
            ).catch(
                (error) => {
                    console.error(error)
                }
            )
        },
        submit() {
            this.error = null
            var transfer = {
                from_account_no: this.from_account_no,
                amount: this.amount,
                email: this.email
            }
            ClientService.clientSendMoney(transfer).then(
                (response) => {
                    this.success = true
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

