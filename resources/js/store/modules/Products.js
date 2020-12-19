export default {
    state:{
    	products:{}
    },
    getters: {
        allproducts(state){
        	return state.products
        }
    },
    mutations: {
       catchProducts(state, data){
       	 state.products = data
       }
    },
    actions: {
    	allProducts(context,data){
            return new Promise((resolve, reject) => { 
        		axios.get(`http://127.0.0.1:8000/api/products`, {
                    params:data,
                    headers: {
                        Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                    }
                }).then( response => {
        			context.commit("catchProducts", response.data)
                    resolve(response)
        		}).catch(error => {
                    reject(error)
                })
           })
    	},

    	addProducts(context, data){
    		return new Promise((resolve, reject) => { 
    			axios.post(`http://127.0.0.1:8000/api/products`, data , {
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

        deleteProduct(context, id){
            return new Promise((resolve, reject) => { 
                axios.delete('http://127.0.0.1:8000/api/products/'+id, {
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
        
        allProductDelete(context, id){
            return new Promise((resolve, reject) => { 
                axios.post(`http://127.0.0.1:8000/api/products-all-delete`, {id}, {
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

        updateProduct(context, data){
            let {id} = data
            delete(data.id)
            let form = data
            let formData = form.formData
            return new Promise((resolve, reject) => { 
                axios.put(`http://127.0.0.1:8000/api/products/`+id, formData, {
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
