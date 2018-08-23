import axios from 'axios'
import {Notification} from 'element-ui';


var instance = axios.create({
    headers: {'X-Requested-With': 'XMLHttpRequest'}
})
export default{
    get (url, params, callback) {
        url+="?param="
        for(let key in params){
            url+="&"+key+"="+params[key]
        }
        instance.get(url)
            .then((response) => {
                if (response.data.code==0) {
                    callback(response.data.data)
                } else {
                    Notification.error({
                        title:'错误',
                        message:response.data.msg
                    })
                }
            }).catch((response) => {
                Notification.error({
                    title:'错误',
                    message:'服务器错误'
                })
            })
    },
    post (url, params, callback) {
        instance.post(url, params)
            .then((response) => {
                if (response.data.code==0) {
                    callback(response.data.data)
                } else {
                    Notification.error({
                        title:'错误',
                        message:response.data.msg
                    })
                }
            }).catch((response) => {
                Notification.error({
                    title:'错误',
                    message:response
                })
            })
    },
    open (url, params) {
        url+="?param="
        for(let key in params){
            url+="&"+key+"="+params[key]
        }
        window.open(url);
    }
}
