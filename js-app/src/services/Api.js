import axios from 'axios'

export default () => {
  return axios.create({
    baseURL: `https://dec353.encs.concordia.ca/api`,
    withCredentials: true
  })
}