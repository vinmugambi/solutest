<template>
    <NuxtLayout>
        <div>
            <h1 class="text-4xl font-bold p-4">Tickets</h1>
            <TicketsTable :filterable="true" :pageable="true" :limit="1000" :page_size="20" />
        </div>
    </NuxtLayout>
</template>
<script setup lang="ts">

definePageMeta({
    middleware: "only-allow-admin"
})
</script>
