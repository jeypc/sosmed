<template>
    <div>
        <p class="text-center" v-if="loading">
            Loading...
        </p>
        <p class="text-center" v-if="!loading">
            <button class="btn btn-success" v-if="status == 0" @click="add_friend">Add Friend</button>
            <button class="btn btn-success" v-if="status == 'pending'" @click="accept_friend">Accept Friend</button>
            <span class="text-success" v-if="status == 'waiting'">Waiting for response</span>
            <span class="text-success" v-if="status == 'friends'">Friends</span>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/check_realationship_status/' + this.profile_user_id)
                 .then((response) => {
                    this.$store.commit('set_status', response.data.status)
                    this.loading = false
                 });
        },

        props: ['profile_user_id'],

        data() {
            return {
                loading: true
            }
        },

        methods: {
            add_friend() {
                this.loading = true
                axios.get('/add_friend/' + this.profile_user_id)
                     .then((response) => {
                        console.log(response)
                        if (response.data == 1)
                            this.$store.commit('set_status', 'waiting')
                            noty('Friend request send.')
                            this.loading = false
                     });
            },

            accept_friend() {
                this.loading = true
                axios.get('/accept_friend/' + this.profile_user_id)
                     .then((response) => {
                        console.log(response)
                        if (response.data == 1)
                            this.$store.commit('set_status', 'friends')
                            noty('You are now friend.')
                            this.loading = false
                     });
            }
        },

        computed: {
            status(){
                return this.$store.state.status
            }
        }
    }
</script>
