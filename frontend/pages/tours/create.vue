<script setup lang="ts">
import AddTour from '~/components/forms/add-tour.vue';
import type { Destination } from '~/types';

var endpoint = useRuntimeConfig().public.destinationsEndpoint;

var { data } = useFetch<Destination[]>(endpoint, {

})

</script>

<template>
    <NuxtLayout>
        <AddTour :destinations="data" />
    </NuxtLayout>
</template>