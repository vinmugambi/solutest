<script setup lang="ts">
import type { Booking, User } from '~/types';
import BookingItem from './booking-item.vue';

var endpoint = useRuntimeConfig().public.bookingsEndpoint
const headers = useRequestHeaders(['cookie'])

defineProps<{ user: User | null }>()

const {
    data,
} = await useFetch<Booking[]>(endpoint + "/me", {
    headers,
    credentials: "include"
})




</script>

<template>
    <div v-if="data" class="flex flex-col gap-4">
        <BookingItem v-for="booking in data" :user="user" :booking="booking" />
    </div>

</template>
