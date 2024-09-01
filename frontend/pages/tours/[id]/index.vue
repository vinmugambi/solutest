<script setup lang="ts">
import type { Tour } from '~/types';


var endpoint = useRuntimeConfig().public.toursEndpoint

const route = useRoute()
const headers = useRequestHeaders(['cookie'])

const tourId = route.params.id
var url = endpoint + `/${tourId}`


const { data: tour, status } = useFetch<Tour>(url, {
    headers
})

</script>

<template>
    <NuxtLayout name="landing" v-slot="{ user }">
        <div>
            <SingleTour v-if="status == 'success'" :user="user" :tour="tour" />
        </div>
    </NuxtLayout>
</template>