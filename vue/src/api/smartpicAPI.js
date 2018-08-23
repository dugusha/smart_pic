import API from './api'
export default {
    getFrame (params, callback) {
        API.get('/smart-pic/get-frame', params, callback)
    },
    getById (params, callback) {
        API.get('/smart-pic/get-by-id', params, callback)
    },
    save (params, callback) {
        API.post('/smart-pic/save', params, callback)
    },
}
