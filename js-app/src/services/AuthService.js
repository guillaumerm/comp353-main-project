import Api from '@/services/Api'

export default {
  clientLogin (payload) {
    return Api().post('/client/login', payload)
  },
  clientLogout () {
    return Api().get('/client/logout')
  },
  clientRegister (payload) {
    return Api().post('/client/register', payload)
  },
  clientSendMoney (payload) {
    return Api().post('/client/sendfund', payload)
  },
  employeeLogin (payload) {
    return Api().get('/employee/login', payload)
  }
}
