export default {
    state:{
        authInfo:{},
        access_token : localStorage.getItem('access_token') || null
    },
    getters: {
        logedIn(state){
            return state.access_token !== null
        }
    },
    mutations: {
        retrieveToken(state, token){
            state.access_token = token
        },
        authInfo(state, data){
            state.authInfo = data
        },
        destroyAccess_token(state){

            state.access_token = null
        }
    },
    actions: {
        submit(context, data){
            return new Promise((resolve, reject) => {
                axios.post('http://127.0.0.1:8000/api/login', data).then(response => {
                    const access_token = response.data.access_token
                    const authInfo     = response.data
                    localStorage.setItem('access_token', access_token)
                    context.commit("retrieveToken", access_token)
                    context.commit("authInfo", authInfo)
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },
        LogOut(context){
            if(context.getters.logedIn){
                return new Promise((resolve, reject) => {
                    axios.post(`http://127.0.0.1:8000/api/log-out`, {}, {
                        headers: {
                            Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                        }
                    }).then(response => {
                        localStorage.removeItem('access_token')
                        context.commit("destroyAccess_token")
                        resolve(response)
                    }).catch(error => {
                        localStorage.removeItem('access_token')
                        context.commit("destroyAccess_token")
                        reject(error)
                    })
                })
            }
        },
        forgotPass(context, data){
            return new Promise((resolve, reject) => {
                axios.post(`http://127.0.0.1:8000/api/forgot-password`, data).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },
        updatePassword(context, data){
            return new Promise((resolve, reject) => {
                axios.post(`http://127.0.0.1:8000/api/update-password`, data).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },
        register(contex, data){
              return new Promise((resolve, reject) => {
                axios.post(`http://127.0.0.1:8000/api/register`, data).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        }
    }
}
