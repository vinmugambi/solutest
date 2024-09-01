<template>

    <div class="">


        <div v-if="error">
            Something went wrong
            {{ error }}
        </div>
        <div>
            <div class="flex p-3 justify-between">
                <UInput v-if="query.filterable" v-model="q" placeholder="Filter bookings" />

            </div>

            <UTable :columns="columns" :rows="rows" :loading="status == 'pending'">

                <template #view-data="{ row }">
                    <NuxtLink class="text-primary font-medium hover:underline" :to="`/bookings/${row.id}`">
                        view
                    </NuxtLink>
                </template>
            </UTable>

            <div class="flex justify-between p-3">
                <UPagination v-if="query.pageable && filteredRows?.length" v-model="page" :page-count="pageCount"
                    :total="filteredRows?.length || 0" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Booking } from '~/types';

const query = defineProps({
    limit: Number,
    order_by: String,
    page_size: Number,
    filterable: Boolean,
    pageable: Boolean
})

var endpoint = useRuntimeConfig().public.bookingsEndpoint
const headers = useRequestHeaders(['cookie'])

const {
    data,
    error,
    status,
} = await useFetch<Booking[]>(endpoint, {
    query,
    headers,
    credentials: "include"
})

var items = data?.value?.map(item => ({
    id: item.id,
    tour: item.tour.name,
    tickets: item.tickets?.length || 0,
    booker: item.user.name,
}))

const columns = [
    {
        key: 'id',
        label: 'Reference',
    },

    {
        key: 'tour',
        label: 'Tour',
    },
    {
        key: 'booker',
        label: 'Booker',
    }, {
        key: 'tickets',
        label: 'Tickets',
        sortable: true,
    },
    {
        key: 'view'
    }
]

const q = ref('')

const filteredRows = computed(() => {
    if (!q.value) {
        return items
    }

    return items?.filter((tour) => {
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



</script>
