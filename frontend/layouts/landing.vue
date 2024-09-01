<template>
    <div>
        <header>
            <Navbar :role="data?.role" @logout="logout" />
        </header>
        <main class="relative max-w-lg mx-auto pb-16 px-4">
            <slot :user="data" />
        </main>
    </div>
</template>

<script setup lang="ts">
import type { User } from '~/types';

var endpoint = useRuntimeConfig().public.profileEndpoint
var logoutEndpoint = useRuntimeConfig().public.logoutEndpoint

var router = useRouter()
const headers = useRequestHeaders(['cookie'])

const {
    data,
} = await useFetch<User>(endpoint, {
    headers,
    credentials: "include"
}).catch()


function logout() {
    $fetch(logoutEndpoint, {
        method: "POST",
        headers
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