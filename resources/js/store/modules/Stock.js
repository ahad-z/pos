export default {
    state:{
    	stocks:{}
    },
    getters: {
        allStocks(state){
        	return state.stocks
        }
    },
    mutations: {
       catchStocks(state, data){
       	 state.stocks = data
       }
    },
    actions: {
    	allStocks(context){
    		axios.get(`http://127.0.0.1:8000/api/stocks`,{
    			headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
    		}).then( response => {
    			context.commit("catchStocks", response.data)
    		})
    	},

    	addStock(context, data){
    		return new Promise((resolve, reject) => { 
    			axios.post(`http://127.0.0.1:8000/api/stocks`, data , {
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

        deleteStock(context, id){
            return new Promise((resolve, reject) => { 
                axios.delete('http://127.0.0.1:8000/api/stocks/'+id, {
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
        
        allStockDelete(context, id){
            return new Promise((resolve, reject) => { 
                axios.post(`http://127.0.0.1:8000/api/stocks-all-delete`, {id}, {
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

        updateStock(context, data){
            let {id} = data
            delete(data.id)
            let form = data
            let formData = form.formData
            return new Promise((resolve, reject) => { 
                axios.put(`http://127.0.0.1:8000/api/stocks/`+id, formData, {
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
