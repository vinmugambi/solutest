<template>
    <div>
        <div v-if="authStatus == 'pending'">
            <h1>Loading...</h1>
        </div>
        <div v-if="authStatus == 'error'">
            <h1>Something went wrong. Reload page</h1>
        </div>


        <div v-if="authStatus == 'success' && user?.role == 'admin'">
            <UButton @click="logout" color="gray">logout</UButton>

            <h2>Create a Tour</h2>
            <form @submit.prevent="createTour">
                <div>
                    <label for="name">Name:</label>
                    <input v-model="tourForm.name" id="name" type="text" />
                </div>
                <!-- Add other form fields -->
                <button type="submit">Create Tour</button>
            </form>

            tours -{{ tours }}
            bookings - {{ bookings }}

            <!-- <NuxtTable :data="tours" :columns="tourColumns" v-if="tours.length" />
            <NuxtTable :data="bookings" :columns="bookingColumns" v-if="bookings.length" /> -->
        </div>

        <div v-else>
            <div class="flex flex-col justify-center items-center h-72">
                <!-- <Logo /> -->
                <h1 class="text-3xl my-4">Not authorized</h1>
                <div v-if="user" class="flex gap-2 justify-center">
                    <UButton to="/app">back home</UButton>
                    <UButton @click="logout" color="gray">logout</UButton>
                </div>
                <div v-else>
                    <UButton to="/auth?action=login">login</UButton>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useAuth } from '~/hooks/useAuth';
import { useBookings } from '~/hooks/useBookings';
import { useTours } from '~/hooks/useTours';

const { user, checkAuthorization, logout, status: authStatus } = useAuth()

onMounted(() => {
    checkAuthorization()
})

// Tour creation logic
const tourForm = reactive({
    name: '',
    // Other fields
});


const tourColumns = [
    { key: 'name', label: 'Name' },
    // Other columns
];

const bookingColumns = [
    { key: 'id', label: 'Booking ID' },
    // Other columns
];

const tours = ref([]);
const bookings = ref([]);

onMounted(async () => {

    const { tours: fetchedTours } = await useTours({
        limit: 5,
    });
    console.log(tours)
    tours.value = fetchedTours.value;

    const { bookings: fetchedBookings } = await useBookings();
    bookings.value = fetchedBookings.value;

});

const createTour = async () => {
    if (!authError) {
        try {
            // Handle tour creation logic
        } catch (error) {
            console.error('Failed to create tour:', error);
        }
    }
};
</script>

<style>
.error-message {
    color: red;
    font-weight: bold;
}
</style>