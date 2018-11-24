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
  }
}
