<template>
	
	<div>

		<hr class="hr-btn-like">

		<button class="btn btn-info btn-xs" v-if="!auth_user_like_post" @click="like()">
			Like
		</button>
		<button class="btn btn-danger btn-xs" v-else @click="unlike()">
			Unlike
		</button>

	</div>

</template>

<script>
	
	export default {

		mounted(){

		},

		props: ['id'],

		methods: {
			like(){
				axios.get('/like/' + this.id)
					 .then( (response) => {
					 	this.$store.commit('update_post_likes', {
					 		id: this.id,
					 		like: response.data
					 	})
					 })
			},

			unlike(){
				axios.get('/unlike/' + this.id)
					 .then( (response) => {
					 	this.$store.commit('unlike_post', {
					 		post_id: this.id,
					 		like_id: response.data
					 	})
					 })
			}
		},

		computed: {
			likers(){
				var likers = [];

				this.post.likes.forEach( (like) => {
					likers.push(like.user.id)
				})

				return likers
			},

			auth_user_like_post(){
				var check_index = this.likers.indexOf(
					this.$store.state.auth_user.id
				)

				if (check_index === -1)
					return false
				else
					return true 
			},

			post(){
				return this.$store.state.posts.find( (post) =>{
					return post.id === this.id
				})
			}
		}

	}

</script>

<style>
	.avatar-feed {
		border-radius: 50%
	}
	.hr-btn-like {
		margin-top: 0px;
    	margin-bottom: 10px;
	}
</style>