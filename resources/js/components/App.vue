<template>
    <main class="container">
        <Nav></Nav>

        <router-view class="p-6 " v-slot="{ Component }">
            <transition name="fade" mode="out-in" >
                <component :is="Component" />
            </transition>
        </router-view>
    </main>
</template>

<script setup>
import Nav from "@/pages/partials/Nav.vue";
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

</style>
