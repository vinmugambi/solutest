<script setup lang="ts">
import type { Tour } from '~/types';

var endpoint = useRuntimeConfig().public.toursEndpoint
const { data: tours } = useFetch<Tour[]>(endpoint, {
    lazy: true
})
</script>

<template>
    <div>
        <div v-for="tour in tours" class="py-2">
            <TourListItem :tour="tour" />
        </div>
    </div>
</template>
