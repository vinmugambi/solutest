<template>
    <NuxtLink v-if="tour" :to="`/tours/${tour.id}`" class="rounded-xl hover:bg-gray-200">
        <div class="flex gap-4 max-w-lg py-6">

            <div class="flex-1 flex flex-col space-y-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-serif  font-semibold text-gray-800">{{ tour.name }}</h2>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm italic">{{ tour.destination.name }}</span>
                    <span class="text-sm ">{{ formatDate(tour.start_time) }}</span>

                </div>
                <p class="text-gray-600 w-96 truncate text-sm">{{ tour.description }}</p>

                <div class="flex gap-2 text-xs text-gray-500">
                    <span class="text-gray-600">{{ tour.capacity - tour.slots }}</span> already booked
                    <span class="text-gray-600">{{ tour.slots }}</span> slots available
                </div>
                <div class="flex gap-2 items-center">
                    <div>
                        <span class="font-mono text-sm uppercase">ksh </span>
                        <span class="text-lg font-medium font-mono"> {{ tour.price.toFixed(0) }}</span>

                    </div>

                    <UButton v-if="!hideActions" color="primary" :to="`/tours/${tour.id}/book`" variant="link">Book
                        <template #trailing>
                            <UIcon name="i-heroicons-arrow-right-20-solid" class="w-5 h-5" />
                        </template>
                    </UButton>
                </div>
            </div>

        </div>
    </NuxtLink>
</template>

<script setup lang="ts">
import { format } from 'date-fns';
import type { Tour } from '~/types';

const props = defineProps<{
    tour: Tour | null,
    hideActions?: Boolean
}>()


const formatDate = (date: string) => {
    return format(new Date(date), 'd MMM yyyy')
}
</script>