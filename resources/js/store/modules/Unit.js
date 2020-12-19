export default {
    state:{
    	units:{}
    },
    getters: {
        allUnits(state){
        	return state.units
        }
    },
    mutations: {
       catchUnits(state, data){
       	 state.units = data
       }
    },
    actions: {
    	allUnits(context){
    		axios.get(`http://127.0.0.1:8000/api/units`,{
    			headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
    		}).then( response => {
    			context.commit("catchUnits", response.data)
    		})
    	},

    	addUnits(context, data){
    		return new Promise((resolve, reject) => { 
    			axios.post(`http://127.0.0.1:8000/api/units`, data , {
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

        deleteUnits(context, id){
            return new Promise((resolve, reject) => { 
                axios.delete('http://127.0.0.1:8000/api/units/'+id, {
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
        
        allUnitDelete(context, id){
            return new Promise((resolve, reject) => { 
                axios.post(`http://127.0.0.1:8000/api/units-all-delete`, {id}, {
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

        updateUnit(context, data){
            let {id} = data
            delete(data.id)
            let form = data
            let formData = form.formData
            return new Promise((resolve, reject) => { 
                axios.put(`http://127.0.0.1:8000/api/units/`+id, formData, {
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
