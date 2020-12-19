import moment from 'moment'

import Vue from  "vue"
/*window.moment = moment*/
Vue.prototype.moment = moment

Vue.filter('time',(a)=>{
    return moment(a).format("MMM Do YY"); 
})


Vue.filter('capitalize', (value) =>  {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})