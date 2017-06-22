<template>
	<div>
		<div class="comment-list" v-for="comment in comments">
			<img :src="comment.user.avatar" width="40px" height="40px" class="avatar-feed">
			<a :href="'/profile/' + comment.user.slug">{{ comment.user.name }}</a>

			{{ comment.content }}

			<span class="pull-right text-info">
				<timeago :since="comment.created_at" :auto-update="10"></timeago>
			</span>
		</div>
		<form @submit.prevent="add_comment">
			<div class="form-group comment-box">
				<div class="input-group">
					<input type="text" class="form-control" v-model="content" placeholder="Write a comment...">
					<div class="input-group-addon" @click="add_comment">Send</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
	
	export default {

		mounted(){
			this.new_comment()
		},

		data(){
			return {
				content: ''
			}
		},

		props: ['id'],

		methods: {

			add_comment(){

				axios.post('/comment', {
						content: this.content,
						post_id: this.id
					})
					.then( (response) => {
						this.content = ''
						this.$store.commit('update_post_comments', {
							id: this.id,
							comment: response.data
						})
					})

			},

			new_comment(){

				Echo.private('comment.' + this.id)
					.listen('NewComment', (response) => {
						this.$store.commit('update_post_comments', {
							id: this.id,
							comment: response.comment
						})

						console.log(response)
					})

			}

		},

		computed: {
			comments(){
				var comments = [];

				this.post.comments.forEach( (comment) => {
					comments.push(comment)
				})

				return comments
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
	
	.comment-list {
		margin-bottom: 4px;
	}
	.comment-box {
	    margin-bottom: 0px;
	    margin-top: 15px;
	}

</style>