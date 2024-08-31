<template>
    <div class="flex py-2 justify-between px-4 border-b">
        <NuxtLink :to="homeLink">
            <Logo />
        </NuxtLink>
        <UButton @click="logout" variant="link">logout</UButton>
    </div>
    {{ user }}

</template>


<script setup>
import { useAuth } from '~/hooks/useAuth';


var { user, checkAuthorization, logout } = useAuth()

await callOnce(async () => {
    var user = user ?? await checkAuthorization()
    console.log(user, "navbar")
})

var homeLink = computed(() => user?.role == 'admin' ? '/dashboard'
    : user?.role == 'user' ? '/app' : "/")
</script>