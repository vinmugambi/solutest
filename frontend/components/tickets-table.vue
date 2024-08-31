<template>

    <div class="">


        <div v-if="error">
            Something went wrong
            {{ error }}
        </div>
        <div>
            <div class="flex p-3 justify-between">
                <h2 class="text-3xl font-semibold">Tickets</h2>
                <UInput v-model="q" placeholder="Filter tickets" />


            </div>

            <UTable :columns="columns" :rows="rows" :loading="status == 'pending'" />

            <div class="flex justify-between p-3">

                <UPagination v-if="filteredRows?.length" v-model="page" :page-count="pageCount"
                    :total="filteredRows?.length || 0" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Ticket } from '~/types';
var event = useRequestEvent()

const query = defineProps({
    limit: Number,
    order_by: String,
    page_size: Number,
})

var endpoint = useRuntimeConfig().public.ticketsEndpoint


const {
    data,
    error,
    status,
} = await useFetch<Ticket[]>(endpoint, {
    credentials: "include",
    query, server: false

})

var items = data?.value?.map(item => ({
    number: item.ticket_number,
    tour: item.id,
    booking: item.booking_id
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
        key: 'booking',
        label: 'Booking',
        sortable: true
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
