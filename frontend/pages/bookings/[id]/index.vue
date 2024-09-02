<script setup lang="ts">
import { useApiRoutes } from '~/composables/useApiRoutes';
import type { Booking } from '~/types';


var endpoint = useApiRoutes().bookingsEndpoint

const route = useRoute()
const headers = useRequestHeaders(['cookie'])

const id = route.params.id
var url = endpoint + `/${id}`


const { data: booking, status } = useFetch<Booking>(url, {
    headers,
    credentials: "include"
})

</script>

<template>
    <NuxtLayout name="landing" v-slot="{ user }">
        <div class="mt-4">

            <h1 v-if="['error', 'success'].includes(status)" class="text-4xl mb-4 font-semibold">Booking {{ booking?.id
                ?? "not found" }}
            </h1>

            <BookingItem v-if="booking?.id && user?.role" :booking="booking" :user="user"></BookingItem>
        </div>
    </NuxtLayout>
</template>