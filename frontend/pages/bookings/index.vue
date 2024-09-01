<template>
    <NuxtLayout>
        <div>
            <h1 class="text-4xl font-bold p-4">Bookings</h1>
            <BookingsTable :filterable="true" :pageable="true" :limit="1000" :page_size="20" />
        </div>
    </NuxtLayout>
</template>
<script setup lang="ts">

definePageMeta({
    middleware: "only-allow-admin"
})
</script>
