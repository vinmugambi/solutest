<template>
    <NuxtLayout>
        <div>
            <ToursTable :limit="100" />
        </div>
        <div class="border-t border-dashed pt-4">
            <BookingsTable :limit="100" />
        </div>

        <div class="border-t border-dashed pt-4">
            <TicketsTable :limit="100" />
        </div>
    </NuxtLayout>
</template>
<script setup lang="ts">

definePageMeta({
    middleware: "only-allow-admin"
})
</script>
