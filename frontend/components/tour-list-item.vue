<template>
    <NuxtLink v-if="tour?.id" :to="`/tours/${tour.id}`" class="block">
        <div class="py-4 rounded-xl hover:text-gray-900 hover:bg-gray-100 px-3">


            <div class="block">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-serif  font-semibold text-gray-800">{{ tour.name }}</h2>
                </div>
                <div class="flex justify-between">
                    <div class="text-sm italic">{{ tour.destination.name }}</div>
                    <div class="text-sm ">{{ formatDate(tour.start_time) }}</div>
                </div>
                <p class="text-gray-600 truncate box-border">{{ tour.description }}
                </p>



                <div class="flex gap-2 text-xs text-gray-500">
                    <div class="text-gray-600">{{ tour.capacity - tour.slots }}</div> already booked
                    <div class="text-gray-600">{{ tour.slots }}</div> slots available
                </div>
                <div class="flex gap-2 items-center">
                    <div>
                        <div class="font-mono text-sm uppercase">ksh </div>
                        <div class="text-lg font-medium font-mono"> {{ tour.price.toFixed(0) }}</div>

                    </div>

                    <UButton v-if="!hideActions" :to="`/tours/${tour.id}/book`" variant="soft">Book
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