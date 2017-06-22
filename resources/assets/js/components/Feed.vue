<template>
	<div>	
		<div class="panel panel-default" v-for="post in posts">
			<div class="panel-heading">
				<img :src="post.user.avatar" width="40px" height="40px" class="avatar-feed">
				<a :href="'/profile/' + post.user.slug">{{ post.user.name }}</a>
				<span class="pull-right text-info">
					<timeago :since="post.created_at" :auto-update="10"></timeago>
				</span>
			</div>
			<div class="panel-body">
				<p>
					{{ post.content }}
				</p>
				
				<like :id="post.id"></like>
				
			</div>

			<div class="panel-footer">
				<comment :id="post.id"></comment>
			</div>
		</div>

		<div class="ajax-load text-center" v-if="loader">
			<p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
		</div>

	</div>
</template>

<script>
	
	import Like from './Like.vue'
	import Comment from './Comment.vue'

	export default {

		mounted() {
			this.get_feed()
			this.listen()

			var self = this;
			$(window).scroll(function() {
			    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
			        self.pagination.current_page++;
			        self.load_more_post(self.pagination.current_page);
			    }
			});

		},

		data(){
			return {
				loader: false,
				pagination: {
					current_page: 1,
					last_page: 0
				}
			}
		},

		components: {
			Like,
			Comment
		},

		props: ['id'],

		methods: {

			get_feed() {
				if (typeof this.id === 'undefined') {
					axios.get('/feed')
					 	 .then( (response) => {
					 	 	
					 	 	this.pagination.last_page = response.data.last_page;

						 	response.data.data.forEach( (post) => {
						 			
							 	var p = this.posts.find( (p) => {
									return p.id === post.id
								})

							 	if(!p)
						 			this.$store.commit('add_post', post)
						 	})
						 })
				} else {
					axios.get('/feed/' + this.id )
					 	 .then( (response) => {

					 	 	this.pagination.last_page = response.data.last_page;

						 	response.data.data.forEach( (post) => {
						 		var p = this.posts.find( (p) => {
									return p.id === post.id
								})

							 	if(!p)
						 			this.$store.commit('add_post', post)
						 })

					})
				}
			},

			load_more_post(page) {
				if (page <= this.pagination.last_page){

					this.loader = true

					if (typeof this.id === 'undefined') {
						axios.get('/feed?page=' + page)
						 	 .then( (response) => {
						 	 	
						 	 	this.loader = false
						 	 	this.pagination.current_page = response.data.current_page
						 	 	this.pagination.last_page = response.data.last_page

						 	 	response.data.data.forEach( (post) => {
								 	var p = this.posts.find( (p) => {
										return p.id === post.id
									})

								 	if(!p)
							 			this.$store.commit('add_post', post)
							 	})
							 })
					} else {
						axios.get('/feed/' + this.id + '?page=' + page)
						 	 .then( (response) => {
						 	 	
						 	 	this.loader = false
						 	 	this.pagination.current_page = response.data.current_page
						 	 	this.pagination.last_page = response.data.last_page

						 	 	response.data.data.forEach( (post) => {
								 	var p = this.posts.find( (p) => {
										return p.id === post.id
									})

								 	if(!p)
							 			this.$store.commit('add_post', post)
							 	})
							})
					}
				}
			},

			listen(){

				Echo.private('post')
					.listen('NewPost', (response) => {
						axios.get('/check_is_friends/' + response.post.user_id)
							 .then( (status) => {
							 	if (status.data == '1') {
							 		this.$store.commit('add_post', response.post)
							 	}
							 })
					})

			}

		},

		computed: {

			posts() {
				return this.$store.getters.all_post
			},

		}

	}
 
</script>