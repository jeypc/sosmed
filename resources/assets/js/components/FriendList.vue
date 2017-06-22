<template>
	<div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				Friend
			</div>
			<div class="panel-body">
				<p class="friend-avatar" v-for="friend in friends">
					<a :href="'/profile/' + friend.slug">
						<img :src="friend.avatar" width="70px" height="70px" :title="friend.name">
					</a>
				</p>
			</div>
		</div>
	</div>
</template>

<script>
	
	export default {

		mounted() {
			this.get_friend()
		},

		data() {
			return {
				friends: []
			}
		},

		props: ['id'],

		methods: {
			get_friend() {
				axios.get('/profile/friend/' + this.id)
					 .then( (response) => {
					 	response.data.forEach( (friend) => {
					 		this.friends.push(friend)
					 	})
					 })
			}
		}

	}

</script>

<style>

	.friend-avatar {
		display: inline-block;
	}

</style>