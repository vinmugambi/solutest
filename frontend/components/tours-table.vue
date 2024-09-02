<template>

    <div class="">


        <div v-if="error">
            Something went wrong
            {{ error }}
        </div>
        <div>
            <div class="flex px-4 py-2 gap-4">
                <UInput v-if="query.filterable" v-model="q" placeholder="Search" />
                <slot>
                </slot>
            </div>

            <UTable :columns="columns" :rows="rows" :loading="status == 'pending'">

                <template #view-data="{ row }">
                    <NuxtLink class="text-primary font-medium hover:underline" :to="`/tours/${row.id}`">
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
import { useApiRoutes } from '~/composables/useApiRoutes';
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
    pageable: {
        type: Boolean,
        default: false
    },
    filterable: {
        type: Boolean,
        default: false
    }
})

var endpoint = useApiRoutes().toursEndpoint
const headers = useRequestHeaders(['cookie'])

const {
    data,
    error,
    status,
} = await useFetch<Tour[]>(endpoint, {

    query,
    headers,
})

var items = data?.value?.map(item => ({
    id: item.id,
    name: item.name,
    booked: `${item.capacity - item.slots} of ${item.capacity}`,
    destination: item.destination.name,
    view: ""
}))

const columns = [
    {
        key: 'name',
        label: 'Name',
    },
    {
        key: 'booked',
        label: 'Booked',
    },
    {
        key: 'destination',
        label: 'Destination',
        sortable: true,
    }, {
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
