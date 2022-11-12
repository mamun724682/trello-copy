<template>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Please sign up</h6>

        <Errors v-if="errors" :content="errors" @close="errors=null"/>

        <form @submit.prevent="handleRegister">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="form_data.name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" v-model="form_data.email" class="form-control" id="exampleInputEmail1"
                       aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" v-model="form_data.password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                <input type="password" v-model="form_data.password_confirmation" class="form-control"
                       id="exampleInputPassword2">
            </div>
            <button type="submit" class="btn btn-primary" :disabled="busy" v-text="busy ? 'Loading...' : 'Submit'"></button>
            <div class="mt-2">
                <router-link :to="{name: 'login'}">Or Sign In</router-link>
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
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: null,
            busy: false,

        }
    },

    methods: {
        async handleRegister() {
            this.busy = true;
            this.errors = null
            this.success = ''
            try {
                await this.$store.dispatch('register', this.form_data);
                this.$router.push({name: 'dashboard'})
            } catch (e) {
                // e.data.errors
                this.errors = e.data
            }
            this.busy = false;
        }
    }
}
</script>

<style scoped>

</style>
