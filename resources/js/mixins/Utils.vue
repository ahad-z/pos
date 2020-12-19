<script>
	export default {
		
		methods: {
			getUserData(colName = 'id') {
				let user = JSON.parse(localStorage.getItem('loggedinUser'));
				if (user) {
					return user[colName]
				}

				return null
			}
		},
	}
</script>