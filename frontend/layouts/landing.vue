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
const { data, status, error, logout, currentPath } = await useAuth();


</script>

<style>
h1,
h2,
h3,
h4 {
    @apply font-serif;
}
</style>