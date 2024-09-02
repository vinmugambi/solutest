<script setup lang="ts">
import { useApiRoutes } from '~/composables/useApiRoutes';
import { useFormSubmit } from '~/composables/useFormSubmit';
import { type Booking, type Tour } from '~/types';


var endpoint = useApiRoutes().toursEndpoint

const route = useRoute()
const router = useRouter()
const headers = useRequestHeaders(['cookie'])


const tourId = route.params.id
var url = endpoint + `/${tourId}`


const { data: tour, status } = useFetch<Tour>(url, {
    headers
})


const seats = ref("1");
const amount = computed(() => {
    const tickets = toNumberOrOne(seats.value)
    return (tour?.value?.price ? tickets * tour.value.price : 0).toFixed(0);
});


function toNumberOrOne(val: any) {
    var num = Number(val)
    return isNaN(num) ? 1 : num;
}

const {
    errorMessage,
    status: submitStatus,
    data,
    submitForm,
    validationErrors,
} = useFormSubmit<Booking>(endpoint + `/${tourId}/book`);


function book() {
    submitForm({ seats: toNumberOrOne(seats.value) })
}

watch(submitStatus, (newStatus) => {
    if (newStatus === 'success' && data.value?.id) {
        router.push(`/bookings/${data.value.id}/pay`)
    }
});

</script>

<template>
    <NuxtLayout v-slot="{ user }">
        <h1 v-if="['error', 'success'].includes(status)" class="text-4xl mb-4 font-semibold">{{ "Book tour"
            ?? "Tour not found" }}
        </h1>
        <div class="border inline-flex rounded-xl">

            <TourListItem :tour="tour" :hide-actions="true" />
        </div>

        <div class="py-8 flex gap-2 items-center">
            <p class="font-semibold">Number of tickets</p>
            <UInput class="w-36" type="number" v-model="seats" />
        </div>

        <div class="flex gap-4 my-4">
            <UButton :disabled="['pending', 'success'].includes(submitStatus)" @click="book">Confirm booking</UButton>

            <div class="">
                <span class="font-mono text-sm uppercase">ksh </span>
                <span class="text-3xl font-medium font-mono"> {{ amount }}</span>
            </div>
        </div>


        <div class="text-sm">
            <div v-if="status === 'error'" class="text-red-500 mt-2">
                {{ errorMessage }}
            </div>

            <div v-if="validationErrors.length" class="text-red-500 mt-2">
                <ul>
                    <li v-for="error in validationErrors" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>
    </NuxtLayout>
</template>