<template>
    <NuxtLayout>
        <h1 class="text-4xl font-bold p-4">Tours</h1>
        <div>
            <ToursTable :filterable="true" :pageable="true" :limit="1000" :page_size="10" />
        </div>
    </NuxtLayout>
</template>
<script setup lang="ts">

definePageMeta({
    middleware: "only-allow-admin"
})
</script>
