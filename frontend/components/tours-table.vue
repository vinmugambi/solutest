<template>

    <div class="">


        <div v-if="error">
            Something went wrong
        </div>
        <div v-else-if="filteredRows?.length">
            <div class="flex p-3 justify-between">
                <h2 class="text-3xl font-semibold">Tours</h2>
                <UInput v-model="q" placeholder="Filter tours" />


            </div>

            <UTable :columns="columns" :rows="rows" :loading="status == 'pending'">
                <template #empty-state>
                    <div class="flex flex-col items-center justify-center py-6 gap-3">
                        <span class="italic text-sm">No one here!</span>
                        <UButton to="/tours/create" label="tour" />
                    </div>
                </template>
            </UTable>

            <div class="flex justify-between p-3">
                <UPagination v-model="page" :page-count="pageCount" :total="filteredRows?.length || 0" />
                <UButton to="tours/create" class="ml-auto">Add tour</UButton>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Tour } from '~/types';

const query = defineProps({
    limit: Number,
    destination_id: String,
    min_price: Number,
    max_price: Number,
    min_start_time: String,
    min_end_time: String,
    order_by: String,
    page_size: Number,
})

var endpoint = useRuntimeConfig().public.toursEndpoint

const { status, data, error } = useFetch<Tour[]>(endpoint, {
    lazy: true,
    query
})

const columns = [
    {
        key: 'name',
        label: 'Name',
    }, {
        key: 'destination',
        label: 'Destination',
        sortable: true
    }, {
        key: 'tickets',
        label: 'Tickets',
        sortable: true,
        direction: 'desc' as const
    }, {
        key: 'price',
        label: 'Price',
        sortable: true
    }]

const q = ref('')

const filteredRows = computed(() => {
    if (!q.value) {
        return tours
    }

    return tours?.filter((tour) => {
        return Object.values(tour).some((value) => {
            return String(value).toLowerCase().includes(q.value.toLowerCase())
        })
    })
})

const page = ref(1)
const pageCount = query.page_size || 5;

const rows = computed(() => {
    return filteredRows.value?.slice((page.value - 1) * pageCount, (page.value) * pageCount)
})

var tours = data?.value?.map(tour => ({
    name: tour.name,
    destination: tour.destination.name,
    tickets: `${tour.capacity - tour.slots} of ${tour.capacity}`,
    price: tour.price.toFixed(0),
}))

</script>
