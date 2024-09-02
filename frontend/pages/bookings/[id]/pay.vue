<script setup lang="ts">
import type { Booking } from '~/types';


var endpoint = useRuntimeConfig().public.bookingsEndpoint

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

            <BookingItem :paying="true" v-if="booking?.id && user?.role" :booking="booking" :user="user"></BookingItem>

            <div v-if="booking">
                <h1 class="font-bold text-4xl my-6">Pay for booking using Mpesa</h1>
                <div>
                    <ul class="flex flex-col gap-2 text-xl">
                        <li>
                            Paybill (business number): <span class="font-bold">
                                4118201
                            </span>
                        </li>
                        <li>
                            Account: <span class="font-bold">{{ booking.id }}</span>
                        </li>
                        <li>
                            Amount: ksh <span class="font-bold">{{ (booking.tour.price *
                                booking.tickets.length).toFixed(0) }}</span>
                        </li>
                    </ul>

                    <div class="font-serif mt-4 text-gray-700 p-4 bg-gray-50 rounded-xl">
                        We will confirm your booking once we receive the payment
                    </div>
                </div>
            </div>
        </div>
    </NuxtLayout>
</template>