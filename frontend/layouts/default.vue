<template>
    <div>
        <header>
            <Navbar :role="data?.role" @logout="logout" />

        </header>
        <div v-if="!data?.role && ['success', 'error'].includes(status)" class="flex flex-col items-center py-16">
            <h1 class="text-3xl font-semibold pb-4">Login to continue</h1>
            <div class="flex gap-2 justify-center">
                <UButton :to="`/auth?action=login&redirect=${currentPath}`">Login</UButton>
            </div>
        </div>
        <main v-else class="relative max-w-3xl mx-auto py-8 px-4">
            <slot :user="data" />
        </main>
    </div>
</template>

<script setup lang="ts">
const { data, status, error, logout, currentPath } = await useAuth(false);

</script>

<style>
h1,
h2,
h3,
h4 {
    @apply font-serif;
}
</style>