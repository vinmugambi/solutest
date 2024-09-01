<script setup lang="ts">
var endpoint = useRuntimeConfig().public.toursEndpoint

const route = useRoute()
const headers = useRequestHeaders(['cookie'])

const tourId = route.params.id
var url = endpoint + `/${tourId}`
console.log("single tour", url)

var { data, status } = useFetch(endpoint + `/${tourId}`, {
    credentials: "include",
    headers
})

</script>

<template>
    <NuxtLayout v-slot="{ user }">
        {{ user }}
        -----
        {{ data }}----
        {{ status }}
    </NuxtLayout>
</template>