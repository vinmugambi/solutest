<!-- components/CreateTourForm.vue -->
<template>
    <UForm :schema="createTourSchema" :state="createTourForm" class="space-y-4" @submit="onSubmit">
        <div class="mt-8">
            <p class="pb-8 text-4xl font-serif font-semibold leading-6 text-gray-900 dark:text-white">
                New Tour
            </p>

            <div class="flex gap-2 items-end mb-3">

                <UFormGroup label="Destination" name="destination_id" class="flex-1">
                    <USelect v-model="createTourForm.destination_id" option-attribute="name" value-attribute="id"
                        :options="props.destinations ?? []" />
                </UFormGroup>

                <!-- <FormsAddDestination /> -->

            </div>


            <UFormGroup label="Name" name="name" class="mb-3">
                <UInput v-model="createTourForm.name" placeholder="Enter tour name" />
            </UFormGroup>

            <UFormGroup label="Description" name="description" class="mb-3">
                <UInput v-model="createTourForm.description" placeholder="Enter tour description" />
            </UFormGroup>

            <UFormGroup label="Price" name="price" class="mb-3">
                <UInput v-model="createTourForm.price" placeholder="Enter price" type="number" />
            </UFormGroup>

            <UFormGroup label="Slots" name="slots" class="mb-3">
                <UInput v-model="createTourForm.slots" placeholder="Enter available slots" type="number" />
            </UFormGroup>

            <UFormGroup label="Start Time" name="start_time" class="mb-6">
                <UInput v-model="createTourForm.start_time" placeholder="Enter start time" type="datetime-local" />
            </UFormGroup>

            <UButton type="submit" class="my-8">
                Create Tour
            </UButton>

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
        </div>
    </UForm>
</template>

<script setup lang="ts">
import { useRuntimeConfig } from '#imports';
import type { FormSubmitEvent } from '#ui/types';
import { defineEmits, reactive, watch } from 'vue';
import { date, number, object, string, type InferType } from 'yup';
import { useFormSubmit } from '~/hooks/useFormSubmit';
import type { Destination } from '~/types';

const emit = defineEmits(['tourCreated']);
const props = defineProps<{
    destinations: Destination[] | null
}>()
const router = useRouter();
const toast = useToast();

const createTourSchema = object({
    destination_id: number().required('Destination ID is required'),
    name: string().max(255, "Name is too long").required('Required'),
    description: string().required('Required'),
    price: number().required('Price is required'),
    slots: number().integer().required('Slots are required'),
    start_time: date().min(new Date(), 'Start time must be in the future').required('Required')
});


type CreateTourSchema = InferType<typeof createTourSchema>;

const createTourForm = reactive({
    destination_id: '',
    name: '',
    description: '',
    price: '',
    slots: '',
    start_time: ''
});

const endpoint = useRuntimeConfig().public.toursEndpoint;

const {
    errorMessage,
    status,
    submitForm,
    validationErrors,
} = useFormSubmit(endpoint);

async function onSubmit(event: FormSubmitEvent<CreateTourSchema>) {
    await submitForm(event.data);
}

watch(status, (newStatus) => {
    if (newStatus === 'success') {
        router.push("/dashboard")
        toast.add({ title: "Tour has been saved" })
        emit('tourCreated');
    }
});
</script>
