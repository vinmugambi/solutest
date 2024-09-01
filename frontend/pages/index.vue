<script setup lang="ts">
import type { Tour } from '~/types';

var endpoint = useRuntimeConfig().public.toursEndpoint
const { status, data: tours } = useFetch<Tour[]>(endpoint, {
    lazy: true
})
</script>

<template>
    <NuxtLayout name="landing">
        <div class="text-center py-8">
            <h1 class="text-4xl mb-4 font-semibold font-serif">
                Make the most out of <br> the weekend
            </h1>
            <p class="text-xl text-gray-800">
                Travel, meet people, try something new
            </p>
        </div>
        <div v-if="status === 'pending'">
            Loading ...
        </div>
        <div v-else class="">
            <div v-for="tour in tours">
                <TourListItem :tour="tour" />
            </div>
        </div>
    </NuxtLayout>
</template>
