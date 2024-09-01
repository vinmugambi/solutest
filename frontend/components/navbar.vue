<template>
    <div class="flex py-2 justify-between px-2 max-w-3xl mx-auto border-b">
        <template v-if="role">
            <UButton :to="homeLink" :prefetch="false" variant="soft">Home</UButton>
            <UButton @click="logout" variant="soft">logout</UButton>
        </template>
        <template v-else>
            <a href="/">
                <Logo />
            </a>
            <UButton to="/auth?action=login">
                login
            </UButton>

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