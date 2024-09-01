<!-- components/CreateDestinationForm.vue -->
<template>
    <UForm :schema="createDestinationSchema" :state="createDestinationForm" class="space-y-4" @submit="onSubmit">
        <div class="mt-8">
            <p class="pb-4 text-xl font-serif font-semibold leading-6 text-gray-900 dark:text-white">
                New destination
            </p>

            <UFormGroup label="Name" name="name" class="mb-3">
                <UInput v-model="createDestinationForm.name" placeholder="Enter destination name" />
            </UFormGroup>

            <UFormGroup label="Description" name="description" class="mb-6">
                <UInput v-model="createDestinationForm.description" placeholder="Enter destination description" />
            </UFormGroup>

            <UButton type="submit" color="black" class="mb-3">
                Create Destination
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
import { object, string, type InferType } from 'yup';
import { useFormSubmit } from '~/hooks/useFormSubmit';

const emit = defineEmits(['destinationCreated']);

const createDestinationSchema = object({
    name: string().max(255, "Name is too long").required('Name is required'),
    description: string().required('Description is required'),
});

type CreateDestinationSchema = InferType<typeof createDestinationSchema>;

const createDestinationForm = reactive<CreateDestinationSchema>({
    name: '',
    description: '',
});

const createDestinationEndpoint = useRuntimeConfig().public.toursEndpoint;

const {
    errorMessage: errorMessage,
    status: status,
    submitForm: submitCreateDestinationForm,
    validationErrors: validationErrors,
} = useFormSubmit(createDestinationEndpoint);

async function onSubmit(event: FormSubmitEvent<CreateDestinationSchema>) {
    await submitCreateDestinationForm(event.data);
}

watch(status, (newStatus) => {
    if (newStatus === 'success') {
        emit('destinationCreated');
    }
});
</script>
