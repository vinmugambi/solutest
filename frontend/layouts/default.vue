<template>
    <div>
        <header>
            <Navbar :role="data?.role" @logout="logout" />

        </header>
        <div v-if="!data?.role && ['success', 'error'].includes(status)" class="flex flex-col items-center py-16">
            <h1 class="text-3xl font-semibold pb-4">Not authorized</h1>
            <div class="flex gap-2 justify-center">
                <UButton to="/auth">Login</UButton>
            </div>
        </div>
        <main v-else class="relative max-w-3xl mx-auto py-8 px-4">
            <slot :user="data" />
        </main>
    </div>
</template>

<script setup lang="ts">
import type { User } from '~/types';


var endpoint = useRuntimeConfig().public.profileEndpoint
var logoutEndpoint = useRuntimeConfig().public.logoutEndpoint

const headers = useRequestHeaders(['cookie'])
var router = useRouter()

const {
    data,
    status
} = await useFetch<User>(endpoint, {
    headers,
    credentials: "include"
}).catch()

console.log(data.value, headers)


function logout() {
    $fetch(logoutEndpoint, {
        method: "POST",
        credentials: "include"
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