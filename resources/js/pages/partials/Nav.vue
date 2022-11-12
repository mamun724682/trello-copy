<template>
    <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
        <router-link v-if="!user" :to="{name: 'login'}">
            <img class="me-3" src="https://getbootstrap.com/docs/5.2/assets/brand/bootstrap-logo-white.svg" alt=""
                 width="48" height="38">
        </router-link>
        <router-link v-else :to="{name: 'dashboard'}">
            <img class="me-3" src="https://getbootstrap.com/docs/5.2/assets/brand/bootstrap-logo-white.svg" alt=""
                 width="48" height="38">
        </router-link>
        <div class="lh-1">
            <nav v-if="user" class="nav" aria-label="Secondary navigation">
                <router-link :to="{name: 'projects'}" class="nav-link text-white">Projects</router-link>
                <router-link :to="{name: 'api_users'}" class="nav-link text-white">Api Users</router-link>
                <a href="javascript:void(0)" @click="logout" class="nav-link text-white">Logout</a>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        user() {
            return this.$store.getters.user;
        }
    },
    methods: {
        async logout() {
            await this.$store.dispatch('logout');
            this.$router.push({name: 'login'});
        }
    }
}
</script>

<style>
.router-link-exact-active {
    color: black !important;
}
</style>
