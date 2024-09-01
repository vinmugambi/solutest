<template>
    <div class="flex py-2 justify-between px-4 border-b">
        <template v-if="role">
            <UButton :to="homeLink" :prefetch="false" variant="link">Home</UButton>
            <UButton @click="logout" variant="link">logout</UButton>
        </template>
        <template v-else>
            <NuxtLink :to="homeLink">
                <Logo />
            </NuxtLink>
            <UButton to="/auth?action=login" color="primary">Login</UButton>
        </template>
    </div>
</template>


<script setup lang="ts">


var props = defineProps({
    role: String,
})
var emit = defineEmits(["logout"])

function logout() {
    emit("logout")
}



var homeLink = computed(() => props?.role ? '/dashboard' : "/")
</script>