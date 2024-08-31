<script setup lang="ts">
import type { Tour } from '~/types';

var endpoint = useRuntimeConfig().public.toursEndpoint
const { status, data: tours } = useFetch<Tour[]>(endpoint, {
    lazy: true
})
</script>

<template>
    <NuxtLayout name="landing">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-semibold font-serif">
                Make the most out of <br> the weekend
            </h1>
            <p class="text-lg text-gray-800">
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
        <div class="fixed bottom-0 left-0 right-0 z-10 flex justify-center mb-4">
            <div class="flex gap-1 p-0.5 backdrop-blur-lg  rounded-2xl border rounded-2xl ">
                <UButton variant="ghost" to="/auth?action=login" color="primary">Login</UButton>
                <UButton variant="ghost" to="/auth?action=register" color="primary">Register</UButton>
            </div>
        </div>
    </NuxtLayout>
</template>
