<script setup lang="ts">
import { useApiRoutes } from '~/composables/useApiRoutes';
import type { Tour } from '~/types';


var endpoint = useApiRoutes().toursEndpoint

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
            <h1 v-if="['error'].includes(status)" class="text-4xl mb-4 font-semibold">
                Tour not found
            </h1>
            <SingleTour v-if="status == 'success'" :user="user" :tour="tour" />
        </div>
    </NuxtLayout>
</template>