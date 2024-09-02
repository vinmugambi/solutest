<script setup lang="ts">
import { useApiRoutes } from '~/composables/useApiRoutes';
import { useFormSubmit } from '~/composables/useFormSubmit';
import type { Booking, User } from '~/types';

var props = defineProps<{ user: User | null, booking: Booking | null, paying?: boolean }>()

var endpoint = useApiRoutes().bookingsEndpoint

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
    <div v-if="booking" class="border rounded-3xl p-4 ">
        <div v-if="booking.status == 'pending' && user && !paying" class="p-3 bg-neutral-100 mb-2 rounded-xl">
            <div v-if="user.role == 'admin'" class="flex justify-between items-center gap-4">
                <p>
                    {{ status == 'success' ? 'Booking has been confirmed' : `Check if the user has made payment
                    andconfirm booking` }}
                </p>
                <UButton v-if="status !== 'success'" @click="confirmBooking">Confirm booking</UButton>
            </div>

            <div v-if="user.role == 'user'" class="">
                <div v-if="!paying" class="flex justify-between items-center gap-4">
                    <p>
                        Confirm this booking by making payment within 24 hours
                    </p>
                    <UButton :to="`/bookings/${booking.id}/pay`">Pay ksh {{ (booking.tickets.length *
                        booking.tour.price).toFixed(0) }}</UButton>
                </div>
            </div>
            <div v-if="status === 'error'" class="text-sm text-red-500 mt-2">
                {{ errorMessage }}
            </div>
        </div>
        <div class="flex flex-wrap gap-8">
            <div class="min-w-0">
                <TourListItem :tour="booking.tour" :hide-actions="true" class="bg-neutral-50  rounded-xl" />
            </div>
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

    </div>

</template>
