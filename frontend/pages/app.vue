<template>
    <NuxtLayout>

    </NuxtLayout>
</template>

<script setup>


definePageMeta({
    middleware: [
        "only-allow-authenticated"
    ]
})

</script>