<script setup lang="ts">
import type { Booking } from '~/types';

var endpoint = useRuntimeConfig().public.bookingsEndpoint
const headers = useRequestHeaders(['cookie'])

const {
    data,
    error,
    status,
} = await useFetch<Booking[]>(endpoint + "/me", {
    headers,
    credentials: "include"
})
</script>

<template>
    <div v-if="data" class="flex flex-col gap-4">
        <div v-for="booking in data" class="border rounded-xl p-4 flex flex-wrap gap-8">
            <TourListItem :tour="booking.tour" :hide-actions="true" class="bg-neutral-100 rounded-xl" />
            <div class="p-4 flex-1">
                <div class="flex justify-between items-center">
                    <div class="text-gray-600 text-sm">
                        #{{ booking.id }}
                    </div>
                    <h4 class="font-bold text-right pb-2">Tickets</h4>

                </div>
                <ul>
                    <li v-for="ticket of booking.tickets" class="py-1 border-t text-right">
                        {{ ticket.ticket_number }}
                    </li>
                </ul>

            </div>
        </div>
    </div>
</template>
