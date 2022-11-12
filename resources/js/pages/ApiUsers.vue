<template>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">User List from API</h6>
        <div v-if="!busy">
            <div class="d-flex text-muted pt-3" v-for="user in users" :key="user.id.value">
                <img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" :src="user.picture.thumbnail" :alt="user.name.first">

                <p class="pb-3 mb-0 small lh-sm border-bottom">
                    <strong class="d-block text-gray-dark">@{{ user.name.first+' '+user.name.last }}</strong>
                    {{ user.email }}
                </p>
            </div>
        </div>
        <div v-else class="text-center">Loading...</div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ApiUsers",
    data() {
        return {
            users: null,
            busy: false
        }
    },
    mounted() {
        this.getApiUsers()
    },
    methods: {
        async getApiUsers() {
            try {
                this.busy = true
                await axios.get('/api/v1/api-users').then(({data}) => {
                    this.users = data.data.results
                }).catch((err) => {
                    throw err.response
                });
                this.busy = false
            } catch (e) {
                throw e
            }
        }
    },
}
</script>

<style scoped>

</style>
