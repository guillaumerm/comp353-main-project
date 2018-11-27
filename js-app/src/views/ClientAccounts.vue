<template>
    <v-content>
        <v-container>
            <v-layout align-center justify-center>
                <v-flex xs12 sm10 md10>
                    <v-card>
                        <v-container>
                            <v-toolbar flat color="white">
                            <v-toolbar-title>My Accounts</v-toolbar-title>
                            <v-divider
                                class="mx-2"
                                inset
                                vertical
                            ></v-divider>
                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <v-btn slot="activator" color="primary" dark class="mb-2">
                                    <v-icon>add</v-icon>
                                    Open Account
                                </v-btn>
                                <v-card>
                                <v-card-title>
                                    <span class="headline">Adding Account</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12 sm6 md4>
                                            <v-select v-model="new_account.account_type_id" label="Account Type" :loading="!account_types" @change="fetchAccountOptions()" :items="account_types" item-text="type" item-value="account_type_id"></v-select>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-select v-model="new_account.account_option_id" label="Account Option" :loading="!account_options" @change="fetchChargePlans()" :items="account_options" item-text="description" item-value="account_option_id"></v-select>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-select v-model="new_account.charge_plan_no" label="Charge Plan" :loading="!charge_plans" :items="charge_plans" item-text="description" item-value="charge_plan_no"></v-select>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-select v-model="new_account.service_id" label="Service Type" :loading="!services" :items="services" item-text="description" item-value="service_id"></v-select>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-select v-model="new_account.branch_id" label="Account Location" :loading="!branches" :items="branches" :item-text="function(item){ return item.street+', ' + item.city +', ' + item.province}" item-value="branch_id"></v-select>
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
                            <v-data-table
                                :headers="headers"
                                :items="accounts"
                                :loading="accounts == null"
                                class="elevation-1"
                            >
                                <template slot="items" slot-scope="props">
                                <td>{{ props.item.account_no }}</td>
                                <td class="text-xs-right">{{ props.item.type }}</td>
                                <td class="text-xs-right">{{ props.item.description }}</td>
                                <td class="text-xs-right">{{ props.item.balance }}$</td>
                                <td class="text-xs-right">{{ props.item.plan_limit }}</td>
                                <td class="text-xs-right">{{ props.item.charge }}</td>
                                <td class="justify-center layout px-0">
                                    <v-tooltip right>
                                        <v-btn slot="activator" icon flat small @click="selectAccount(props.item)">
                                            <v-icon
                                                small
                                            >
                                                list_alt
                                            </v-icon>
                                        </v-btn>
                                        <spasn>
                                            Show Transactions
                                        </spasn>
                                    </v-tooltip>
                                    <v-tooltip right>
                                        <v-btn slot="activator" icon flat small @click="deleteAccount(props.item.account_no)">
                                            <v-icon
                                                small
                                            >
                                                delete
                                            </v-icon>
                                        </v-btn>
                                        <span>
                                            Delete Account
                                        </span>
                                    </v-tooltip>
                                    </td>
                                </template>
                                <template slot="no-data">
                                    <v-alert :value="true" color="error" icon="warning">
                                        Sorry, nothing to display here :(
                                    </v-alert>
                                </template>
                            </v-data-table>
                            <template v-if="showTransactions">
                                <v-toolbar flat color="white">
                                        <v-toolbar-title>Transactions for {{selected_account.account_no}}</v-toolbar-title>
                                        </v-toolbar>
                                        <v-data-table
                                            :headers="transactionHeaders"
                                            :items="selected_account.transactions"
                                            class="elevation-1"
                                        >
                                            <template slot="items" slot-scope="props">
                                            <td>{{ props.item.transaction_no }}</td>
                                            <td class="text-xs-right">{{ props.item.date }}</td>
                                            <td class="text-xs-right">{{ props.item.amount }}$</td>
                                            </template>
                                            <template slot="no-data">
                                                <v-alert :value="true" color="error" icon="warning">
                                                    Sorry, nothing to display here :(
                                                </v-alert>
                                            </template>
                                        </v-data-table>
                            </template>
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
            selected_account: null,
            dialog: false,
            showTransactions: false,
            account_types: null,
            account_options: null,
            charge_plans: null,
            branches: null,
            services: null,
            new_account: {
                account_type_id: null,
                account_option_id: null,
                charge_plan_no: null,
                service_id: null,
                branch_id: null
            },
            headers: [
                {
                    text: 'Account  #',
                    align: 'left',
                    sortable: false,
                    value: 'account_no'
                },
                { text: 'Type', value: 'type' },
                { text: 'Description', value: 'description'},
                { text: 'Balance', value: 'balance' },
                { text: 'Limit', value: 'plan_limit' },
                { text: 'Charge', value: 'charge'}
            ],
            transactionHeaders: [
                {
                    text: 'Transaction #',
                    align: 'left',
                    sortable: false,
                    value: 'transaction_no'
                },
                { text: 'Date', value: 'date' },
                { text: 'Amount', value: 'amount'}
            ]
        }
    },
    created() {
        this.$store.dispatch('fetchAccounts')
        ClientService.clientGetAccountTypes().then(
            (response) => {
                this.account_types = response.data
            }
        ).catch(
            (error) => {
                console.error(error)
            }
        )

        ClientService.clientGetBranches().then(
            (response) => {
                this.branches = response.data
            }
        ).catch(
            (error) => {
                console.error(error)
            }
        )

        ClientService.clientGetServices().then(
            (response) => {
                this.services = response.data
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
        }
    },
    methods: {
        selectAccount(account) {
            this.selected_account = account
            this.showTransactions = true
        },
        fetchAccountOptions() {
            ClientService.clientGetAccountOptions(this.new_account.account_type_id).then(
                (response) => {
                    this.account_options = response.data
                }
            ).catch(
                (error) => {
                    console.error(error)
                }
            )
        },
        fetchChargePlans() {
            ClientService.clientGetChargePlans(this.new_account.account_option_id).then(
                (response) => {
                    this.charge_plans = response.data
                }
            ).catch(
                (error) => {
                    console.error(error)
                }
            )
        },
        deleteAccount(account_no) {
            if(confirm("Are you sure you want to delete account # " + account_no)) {
                ClientService.clientDeleteAccount(account_no).then(
                    (response) => {
                        this.$store.dispatch('fetchAccounts')
                    }
                ).catch(
                    (error) => {
                        console.error(error)
                    }
                )
            }
        },
        save(){
            ClientService.clientAddAccount(this.new_account).then(
                (response) => {
                    this.$store.dispatch('fetchAccounts')
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
