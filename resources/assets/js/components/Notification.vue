<template>

</template>

<script>
	
	export default {

		mounted() {
			this.listen()
		},
		
		props: ['id'],

		methods: {

			listen() {

				Echo.private('App.User.' + this.id)
					.notification( (notification) => {
						console.log(notification)
						if (notification.status == 'friends') {
							this.$store.commit('set_status', 'friends')
						}
						
						if (notification.status == 'like') {
							this.$store.commit('update_post_likes', {
						 		id: notification.like.post_id,
						 		like: notification.like
						 	})
						}

						noty(notification.name + notification.message)
						document.getElementById('notif_sound').play()

						this.$store.commit('add_notification', notification)

					})

			}

		}

	}

</script>