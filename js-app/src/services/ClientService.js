import Api from '@/services/Api'

export default {
  clientSendMoney (payload) {
    return Api().post('/client/sendfund', payload)
  },
  clientTransferMoney (payload) {
    return Api().post('/client/transfermoney', payload)
  },
  clientAccounts (payload) {
      return Api().get('/client/accounts')
  },
  clientAwaitingFunds () {
    return Api().get('/client/awaitingFunds')
  },
  clientReceiveFunds(payload) {
    return Api().post('/client/receiveFunds', payload)
  },
  clientGetAccountTypes(){
    return Api().get('/account/types');
  },
  clientGetAccountOptions(accountTypeId) {
    return Api().get('/account/type/' + accountTypeId + '/options');
  },
  clientGetChargePlans(accountOptionId) {
    return Api().get('/account/option/' + accountOptionId + '/chargeplans');
  },
  clietGetCategories() {
    return Api().get('/client/categories')
  },
  clientDeleteAccount(clientDeleteAccount){
    return Api().get('/client/account/' + clientDeleteAccount)
  },
  clientAddAccount(payload) {
    return Api().post('/client/account', payload);
  },
  clientGetPayees() {
    return Api().get('/client/payees')
  },
  clientAddPayee(payload) {
    return Api().post('/client/payee', payload)
  },
  clientMakePayment(payload) {
    return Api().post('/client/payment', payload)
  },
  clientGetBranches() {
    return Api().get('/branches');
  },
  clientGetServices() {
    return Api().get('/services');
  }
}
