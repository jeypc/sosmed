<template>
	<div>
		
	</div>
</template>

<script>
	
	export default {

		mounted(){
			this.get_auth_user_data()
		},

		methods: {
			get_auth_user_data() {
				axios.get('/get_auth_user_data')
				     .then( (response) => {
				     	this.$store.commit('auth_user_data', response.data)
				     })
			}
		}

	}

</script>