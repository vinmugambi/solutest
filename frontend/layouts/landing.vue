<template>
    <div>
        <header>
            <Navbar :role="user?.role" @logout="logout" />
        </header>
        <main class="relative max-w-lg mx-auto pb-24 px-4">
            <slot />
        </main>
    </div>
</template>

<script setup lang="ts">
import type { User } from '~/types';

var endpoint = useRuntimeConfig().public.profileEndpoint
var logoutEndpoint = useRuntimeConfig().public.logoutEndpoint

var router = useRouter()
var user = computed(() => data.value ? data.value : null)

const {
    data,
    status
} = await useFetch<User>(endpoint, {
    credentials: "include",
    server: false
}).catch()


function logout() {
    $fetch(logoutEndpoint, {
        credentials: "include",
        method: "POST",
    })
        .then(() => {
            router.push("/auth?action=login");
        })
        .catch((e) => {
            console.error(e);
        });
}


</script>

<style>
h1,
h2,
h3,
h4 {
    @apply font-serif;
}
</style>