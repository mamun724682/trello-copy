<template>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h4 class="border-bottom pb-2 mb-0 text-center">Welcome, {{ user?.name }}</h4>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    computed: {
        user() {
            return this.$store.getters.user;
        }
    },
}
</script>

<style scoped>

</style>
