<template>
	<div>
		<div class="panel panel-default">
	        <div class="panel-body">
	            <textarea rows="5" class="form-control" v-model="content" placeholder="What's on your mind..."></textarea>
	        	<br>
	            <button class="btn btn-success pull-right" :disabled="not_working" @click="create_post">Post</button>
	        </div>
	    </div>
	</div>
</template>

<script>
	
export default {

	mounted() {

	},

	data() {

		return {
			content: '',
			not_working: true
		}

	},

	methods: {

		create_post(){

			axios.post('/create/post', { content: this.content })
				 .then( (response) => {
				 	this.content = ''
				 	this.$store.commit('add_post', response.data)
				 })

		}

	},

	watch: {

		content() {
			if (this.content.length > 0)
				this.not_working = false
			else
				this.not_working = true
		}

	}

}

</script>