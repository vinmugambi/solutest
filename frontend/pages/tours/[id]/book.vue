<script setup lang="ts">
import { type Tour } from '~/types';

var endpoint = useRuntimeConfig().public.toursEndpoint

const route = useRoute()
const headers = useRequestHeaders(['cookie'])

const tourId = route.params.id
var url = endpoint + `/${tourId}`


const { data: tour } = useFetch<Tour>(url, {
    headers
})
const number_of_tickets = ref("1");

const amount = computed(() => {
    const tickets = Number(number_of_tickets.value) || 1;
    return (tour?.value?.price ? tickets * tour.value.price : 0).toFixed(0);
});

</script>

<template>
    <NuxtLayout v-slot="{ user }">
        <h1 class="text-4xl mb-4 font-semibold">Book tour</h1>
        <div class="border inline-flex rounded-xl">

            <TourListItem :tour="tour" :hide-actions="true" />
        </div>

        <div class="py-8 flex gap-2 items-center">
            <p class="font-semibold">Number of tickets</p>
            <UInput class="w-36" type="number" v-model="number_of_tickets" />
        </div>

        <div class="flex gap-4 mt-4">
            <UButton>Confirm booking</UButton>

            <div class="">
                <span class="font-mono text-sm uppercase">ksh </span>
                <span class="text-3xl font-medium font-mono"> {{ amount }}</span>
            </div>
        </div>
    </NuxtLayout>
</template>