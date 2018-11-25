import Api from '@/services/Api'

export default {
  employeeGetSchedule () {
    return Api().get('/employee/schedule')
  },
  employeeGetPays () {
      return Api().get('/employee/pays')
  },
  employeeGetFinancialReport () {
      return Api().get('/finance/report')
  }
}