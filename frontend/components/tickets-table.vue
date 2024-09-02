<template>
    <div class="">
        <div v-if="error">
            Something went wrong
            {{ error }}
        </div>
        <div>
            <div class="flex p-3 justify-between">
                <UInput v-if="query.filterable" v-model="q" placeholder="Filter tickets" />
            </div>

            <UTable :columns="columns" :rows="rows" :loading="status == 'pending'">
                <template #booking-data="{ row }">
                    <NuxtLink class="text-primary font-medium hover:underline" :to="`/bookings/${row.booking}`">
                        view booking
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
import { useApiRoutes } from '~/composables/useApiRoutes';
import type { Ticket } from '~/types';

const query = defineProps({
    limit: Number,
    order_by: String,
    page_size: Number,
    pageable: Boolean,
    filterable: Boolean
})

var endpoint = useApiRoutes().ticketsEndpoint
const headers = useRequestHeaders(['cookie'])

const {
    data,
    error,
    status,
} = await useFetch<Ticket[]>(endpoint, {

    query, headers, credentials: "include"

})

var items = data?.value?.map(item => ({
    number: item.ticket_number,
    tour: item.id,
    booking: item.booking_id,
    status: item.booking?.status ?? "pending"
}))

const columns = [
    {
        key: 'number',
        label: 'Number',
    },
    {
        key: 'tour',
        label: 'Tour',
    },
    {
        key: "status",
        label: "Status",
    },
    {
        key: 'booking',
    }]

const q = ref('')

const filteredRows = computed(() => {
    if (!q.value) {
        return items
    }

    return items?.filter((item) => {
        return Object.values(item).some((value) => {
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
