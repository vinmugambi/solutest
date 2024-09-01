<!-- components/CreateTourForm.vue -->
<template>
    <UForm :schema="createTourSchema" :state="createTourForm" class="space-y-4" @submit="onSubmit">
        <div class="mt-8">
            <p class="pb-8 text-xl font-serif font-semibold leading-6 text-gray-900 dark:text-white">
                New Tour
            </p>

            <div class="flex gap-2 items-end mb-3">

                <UFormGroup label="Destination" name="destination_id" class="flex-1">
                    <USelect v-model="createTourForm.destination_id" option-attribute="name"
                        :options="[{ name: 'Nairobi', value: 1 }]" />
                </UFormGroup>

                <FormsAddDestination />

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
import { number, object, string, type InferType } from 'yup';
import { useFormSubmit } from '~/hooks/useFormSubmit';

const emit = defineEmits(['tourCreated']);

const createTourSchema = object({
    destination_id: number().required('Destination ID is required'),
    name: string().max(255, "Name is too long").required('Required'),
    description: string().required('Required'),
    destination_name: string().nullable(),
    destination_description: string().nullable(),
    price: number().required('Price is required'),
    slots: number().integer().required('Slots are required'),
});

const date = ref(new Date())

type CreateTourSchema = InferType<typeof createTourSchema>;

const createTourForm = reactive({
    destination_id: '',
    name: '',
    description: '',
    destination_name: '',
    destination_description: '',
    price: '',
    slots: '',
    start_time: ''
});

const createTourEndpoint = useRuntimeConfig().public.toursEndpoint;
const event = useRequestEvent();

const {
    errorMessage: errorMessage,
    status: status,
    submitForm: submitCreateTourForm,
    validationErrors: validationErrors,
} = useFormSubmit(createTourEndpoint);

async function onSubmit(event: FormSubmitEvent<CreateTourSchema>) {
    await submitCreateTourForm(event.data);
}

watch(status, (newStatus) => {
    if (newStatus === 'success') {
        emit('tourCreated');
    }
});
</script>
