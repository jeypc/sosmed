<template>
	<li>
		<a href="/notifications">
			Notification
			<span class="badge" v-if="notification_count > 0">{{ notification_count }}</span>
		</a>

	</li>
</template>

<script>

	export default {

		mounted() {
			this.get_unread()
		},

		methods: {

			get_unread() {

				axios.get('/get_unread')
					 .then((response) => {
					 	response.data.forEach( (notification) => {
					 		this.$store.commit('add_notification', notification)
					 	})
					 })

			}

		},

		computed: {
			notification_count(){
				return this.$store.getters.notification_count
			}
		}

	}

</script>