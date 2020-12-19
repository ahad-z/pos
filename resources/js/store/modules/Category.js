export default {
    state:{
    	categories:{}
    },
    getters: {
        allCategories(state){
        	return state.categories
        }
    },
    mutations: {
       catchCategories(state, data){
       	 state.categories = data
       }
    },
    actions: {
    	allCategories(context){
    		axios.get(`http://127.0.0.1:8000/api/categories`,{
    			headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
    		}).then( response => {
    			context.commit("catchCategories", response.data)
    		})
    	},

    	addCategories(context, data){
    		return new Promise((resolve, reject) => { 
    			axios.post(`http://127.0.0.1:8000/api/categories`, data , {
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

        deleteCategories(context, id){
            return new Promise((resolve, reject) => { 
                axios.delete('http://127.0.0.1:8000/api/categories/'+id, {
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
        
        AllCatDelete(context, id){
            return new Promise((resolve, reject) => { 
                axios.post(`http://127.0.0.1:8000/api/categories-all-delete`, {id}, {
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

        updateCat(context, data){
            let {id} = data
            delete(data.id)
            let form = data
            let formData = form.formData
            return new Promise((resolve, reject) => { 
                axios.put(`http://127.0.0.1:8000/api/categories/`+id, formData, {
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
