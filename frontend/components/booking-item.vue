<script setup lang="ts">
import { useFormSubmit } from '~/hooks/useFormSubmit';
import type { Booking, User } from '~/types';

var props = defineProps<{ user: User | null, booking: Booking | null }>()

var endpoint = useRuntimeConfig().public.bookingsEndpoint

var router = useRouter()


const {
    errorMessage,
    status,
    data,
    submitForm,
} = useFormSubmit<Booking>(endpoint + `/${props.booking?.id}/confirm`);


function confirmBooking() {
    submitForm({})
}

watch(status, (newStatus) => {
    if (newStatus === 'success' && data?.value?.id) {
        router.push(`/bookings/${props.booking?.id}`)
    }
});
</script>

<template>
    <div v-if="booking" class="border rounded-xl p-4 ">
        <div class="flex flex-wrap gap-8">
            <TourListItem :tour="booking.tour" :hide-actions="true" class="bg-neutral-50 flex-1 rounded-xl" />
            <div class="p-4 flex-1">
                <div class="flex justify-between items-center">
                    <div class="text-gray-600 text-sm">
                        #{{ booking.id }} {{ booking.status.toLocaleUpperCase() }}
                    </div>
                    <h4 class="font-bold text-right pb-2">Tickets</h4>

                </div>
                <ul>
                    <li v-for="ticket of booking.tickets" class="py-1 border-t text-right">
                        {{ ticket.ticket_number }}
                    </li>
                </ul>
            </div>
        </div>
        <div v-if="booking.status == 'pending' && user" class="p-3 bg-neutral-100 mt-2 rounded-xl">
            <div v-if="user.role == 'admin'" class="flex justify-between items-center">
                <p>
                    Check if the user has made payment and confirm booking
                </p>
                <UButton @click="confirmBooking">Confirm booking</UButton>
            </div>

            <div v-if="user.role == 'user'" class="flex justify-between items-center">
                <p>
                    Pay for this booking to confirm it
                </p>
                <UButton :to="`/bookings/${booking.id}/pay`">Pay ksh {{ (booking.tickets.length *
                    booking.tour.price).toFixed(0) }}</UButton>

            </div>
            <div v-if="status === 'error'" class="text-sm text-red-500 mt-2">
                {{ errorMessage }}
            </div>

        </div>
    </div>

</template>
