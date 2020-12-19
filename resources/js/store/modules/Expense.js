export default {
    state:{
    	expenses:{}
    },
    getters: {
        allExpenses(state){
        	return state.expenses
        }
    },
    mutations: {
       catchExpenses(state, data){
       	 state.expenses = data
       }
    },
    actions: {
    	allExpenses(context){
    		axios.get(`http://127.0.0.1:8000/api/expenses`,{
    			headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
    		}).then( response => {
    			context.commit("catchExpenses", response.data)
    		})
    	},

    	addExpenses(context, data){
    		return new Promise((resolve, reject) => { 
    			axios.post(`http://127.0.0.1:8000/api/expenses`, data , {
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

        deleteExpense(context, id){
            return new Promise((resolve, reject) => { 
                axios.delete('http://127.0.0.1:8000/api/expenses/'+id, {
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
        
        allexpensesDelete(context, id){
            return new Promise((resolve, reject) => { 
                axios.post(`http://127.0.0.1:8000/api/expenses-all-delete`, {id}, {
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

        updateExpense(context, data){
            let {id} = data
            delete(data.id)
            let form = data
            let formData = form.formData
            return new Promise((resolve, reject) => { 
                axios.put(`http://127.0.0.1:8000/api/expenses/`+id, formData, {
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
