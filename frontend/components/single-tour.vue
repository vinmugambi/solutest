<script setup lang="ts">
import { formatDate } from 'date-fns/format';
import type { Tour, User } from '~/types';

var { user, tour } = defineProps<{
    tour: Tour | null,
    user: User | null
}>()

var isAdmin = user?.role == 'admin'
</script>

<template>
    <div v-if="tour?.name" class="flex gap-4 max-w-lg py-6">

        <div class="flex-1 flex flex-col space-y-2">
            <div class="flex items-center justify-between">
                <h1 class="text-4xl font-serif  font-semibold text-gray-800">{{ tour.name }}</h1>
            </div>
            <div class="flex justify-between">
                <span class=" ">{{ (tour.start_time) }}</span>
            </div>
            <section class="">
                <h3 class="text-lg font-semibold"> Experience {{ tour.destination.name }}</h3>
                <p class="text-gray-600">{{ tour.destination.description }}</p>
            </section>
            <section class="flex gap-2 items-center border-y py-4">
                <div class="flex gap-2 text-xs text-gray-500">
                    <span class="text-gray-800">{{ tour.slots }} of {{ tour.capacity }}</span>slots
                    available
                </div>

                <div class="ml-auto">
                    <span class="font-mono text-sm uppercase">ksh </span>
                    <span class="text-3xl font-medium font-mono"> {{ tour.price.toFixed(0) }}</span>

                </div>


                <UButton v-if="tour.has_booked" to="/dashboard">
                    View booking
                </UButton>



                <UButton v-else-if="!isAdmin" :to="`/tours/${tour.id}/book`" color="primary">Book now
                    <template #trailing>
                        <UIcon name="i-heroicons-arrow-right-20-solid" class="w-5 h-5" />
                    </template>
                </UButton>
            </section>
            <section>
                <h3 class="text-lg font-semibold">Overview</h3>

                <p class="text-gray-700 text-lg">{{ tour.description }}</p>
            </section>

            <div class="border-t" v-if="isAdmin && tour.bookings">
                <ul>
                    <li v-for="booking of tour.bookings" class="py-2 border-b">

                        <div>{{ booking.tickets.length }} tickets</div>
                        <ol>
                            <li v-for="ticket of booking.tickets" class="flex gap-4 py-1">
                                <div>{{ ticket.ticket_number }}</div>
                                <div>{{ formatDate(ticket.created_at, 'dd MM yyyy hh') }}</div>
                            </li>

                        </ol>

                    </li>

                </ul>

            </div>
        </div>
    </div>
</template>