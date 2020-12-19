export default {
    state:{
    	orders:{}
    },
    getters: {
        allOrder(state){
        	return state.orders.data
        }
    },
    mutations: {
       catchOrder(state, data){
       	 state.orders = data
       }
    },
    actions: {
    	allOrder(context,data=null){
            return new Promise((resolve, reject) => { 
        		axios.get(`http://127.0.0.1:8000/api/orders`, { 
                    params: data, 
        			headers: {
                        Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                    }
        		}).then( response => {
        			context.commit("catchOrder", response.data)
                    resolve(response)
        		}).catch(error => {
                    reject(error)
                })

            })
    	},

    	addOrder(context, data){
    		return new Promise((resolve, reject) => { 
    			axios.post(`http://127.0.0.1:8000/api/orders`, data , {
	    			headers: {
	                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
	                }
	    		}).then( response => {
	    			resolve(response)
	    		}).catch(error => {
	    			reject(error)
	    		})
    		})
    	},

        deleteOrder(context, id){
            return new Promise((resolve, reject) => { 
                axios.delete('http://127.0.0.1:8000/api/orders/'+id, {
                    headers: {
                        Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                    }
                }).then( response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },
        
        /*allOrderDelete(context, id){
            return new Promise((resolve, reject) => { 
                axios.post(`http://127.0.0.1:8000/api/orders-all-delete`, {id}, {
                    headers: {
                        Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                    }
                }).then( response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })

        },*/

        updateOrder(context, data){
            let {id, orderInfo} = data
            return new Promise((resolve, reject) => { 
                axios.put(`http://127.0.0.1:8000/api/orders/`+id, orderInfo, {
                    headers: {
                        Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                    }
                }).then( response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        }
    }
}
