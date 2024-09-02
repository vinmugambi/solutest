<script setup lang="ts">
import AddTour from '~/components/forms/add-tour.vue';
import { useApiRoutes } from '~/composables/useApiRoutes';
import type { Destination } from '~/types';

var endpoint = useApiRoutes().destinationsEndpoint;

var { data } = useFetch<Destination[]>(endpoint, {

})

</script>

<template>
    <NuxtLayout>
        <AddTour :destinations="data" />
    </NuxtLayout>
</template>