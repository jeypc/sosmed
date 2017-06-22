import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({

	state: {
		status: '',
		notifications: [],
		posts: [],
		auth_user: {}
	},

	getters: {
		all_notification(state){
			return state.notifications
		},

		notification_count(state){
			return state.notifications.length
		},

		all_post(state){
			return state.posts.sort(function(a, b) {
			    return a.id < b.id;
			});
		},

		status(state){
			return state.status
		}
	},

	mutations: {
		add_notification(state, newNotification){
			state.notifications.push(newNotification)
		},

		add_post(state, post) {
			state.posts.push(post)
		},

		auth_user_data(state, user) {
			state.auth_user = user
		},

		update_post_likes(state, payload) {
			var post = state.posts.find( (post) => {
				return post.id === payload.id
			})

			post.likes.push(payload.like)
		},

		update_post_comments(state, payload) {
			var post = state.posts.find( (post) => {
				return post.id === payload.id
			})

			post.comments.push(payload.comment)
		},

		unlike_post(state, payload) {
			var post = state.posts.find( (post) => {
				return post.id === payload.post_id
			})

			var like = post.likes.find( (like) => {
				return like.id === payload.like_id
			})

			var index = post.likes.indexOf(like)

			post.likes.splice(index, 1)
		},

		set_status(state, status) {
			state.status = status
		}
	}

})