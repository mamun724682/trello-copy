<template>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Please sign in</h6>

        <Errors type="danger" v-if="errors" :content="errors" @close="errors=null"/>

        <form @submit.prevent="handleLogin">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" v-model="form_data.email" class="form-control" id="exampleInputEmail1"
                       aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" v-model="form_data.password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary" :disabled="busy" v-text="busy ? 'Loading...' : 'Submit'"></button>
            <div class="mt-2">
                <router-link to="/register">Or Sign Up</router-link>
            </div>
        </form>
    </div>
</template>

<script>
import Errors from "@/components/Errors.vue";

export default {
    components: {
        Errors
    },
    data() {
        return {
            form_data: {
                email: '',
                password: ''
            },
            errors: null,
            busy: false,
        }
    },
    methods: {
        async handleLogin() {
            this.busy = true;
            this.errors = null
            try {
                await this.$store.dispatch('login', this.form_data)
                this.$router.push({name: 'dashboard'})
            } catch (e) {
                this.errors = e.data
            }

            this.busy = false;
        }
    }
}
</script>

<style scoped>

</style>
