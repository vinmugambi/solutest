<template>

    <NuxtLayout v-slot="{ user }">
        <div v-if="user?.role == 'admin'">
            <div>
                <div class="flex justify-between px-4">
                    <h2 class="text-4xl font-bold">Latest tours</h2>
                    <div class="flex gap-2 items-end">
                        <UButton color="gray" to="/tours"> view all </UButton>
                        <FormsAddDestination />
                        <UButton to="/tours/create">new tour</UButton>
                    </div>

                </div>
                <ToursTable :limit="20" :page_size="3" />
            </div>
            <div class="border-t border-dashed pt-4">

                <div class="flex justify-between px-4">
                    <h2 class="text-4xl font-bold">Bookings</h2>
                    <div class="flex gap-2 items-end">
                        <UButton color="gray" to="/bookings"> view all </UButton>
                        <UButton color="gray" to="/tickets"> search ticket </UButton>
                    </div>

                </div>
                <BookingsTable :limit="20" :page_size="3" />
            </div>
        </div>
        <div v-if="user?.role == 'user'">
            <div>
                <h2 class="text-4xl pb-4 px-4">My bookings</h2>
                <MyBookings />
            </div>

            <div class="mt-8">
                <h2 class="text-4xl pb-4 px-4">Discover</h2>
                <TourList />
            </div>

        </div>
    </NuxtLayout>
</template>
