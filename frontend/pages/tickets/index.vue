<template>
    <NuxtLayout>
        <div>
            <TicketsTable :limit="1000" :page_size="20" />
        </div>
    </NuxtLayout>
</template>
<script setup lang="ts">

definePageMeta({
    middleware: "only-allow-admin"
})
</script>
