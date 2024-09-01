<!-- components/CreateDestinationForm.vue -->
<template>
    <div>

        <UButton color="gray" label="new destination" @click="isOpen = true" />

        <UModal v-model="isOpen" prevent-close>


            <UForm :schema="createDestinationSchema" :state="createDestinationForm" class="space-y-4 p-6"
                @submit="onSubmit">
                <div class="">
                    <p class="pb-4 text-xl font-serif font-semibold leading-6 text-gray-900 dark:text-white">
                        New destination
                    </p>

                    <UFormGroup label="Name" name="name" class="mb-3">
                        <UInput v-model="createDestinationForm.name" placeholder="Enter destination name" />
                    </UFormGroup>

                    <UFormGroup label="Description" name="description" class="mb-6">
                        <UInput v-model="createDestinationForm.description"
                            placeholder="Enter destination description" />
                    </UFormGroup>

                    <div class="flex gap-4">
                        <UButton type="submit">
                            Create Destination
                        </UButton>
                        <UButton color="gray" @click="isOpen = false">Cancel</UButton>

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
                </div>
            </UForm>
        </UModal>
    </div>
</template>

<script setup lang="ts">
import { useRuntimeConfig } from '#imports';
import type { FormSubmitEvent } from '#ui/types';
import { defineEmits, reactive, watch } from 'vue';
import { object, string, type InferType } from 'yup';
import { useFormSubmit } from '~/hooks/useFormSubmit';

const emit = defineEmits(['destinationCreated']);

var isOpen = ref(false)
const createDestinationSchema = object({
    name: string().max(255, "Name is too long").required('Name is required'),
    description: string().required('Description is required'),
});

type CreateDestinationSchema = InferType<typeof createDestinationSchema>;

const createDestinationForm = reactive<CreateDestinationSchema>({
    name: '',
    description: '',
});

const endpoint = useRuntimeConfig().public.destinationsEndpoint

const {
    errorMessage,
    status,
    submitForm,
    validationErrors,
} = useFormSubmit(endpoint);

async function onSubmit(event: FormSubmitEvent<CreateDestinationSchema>) {
    await submitForm(event.data);
}

const toast = useToast()

watch(status, (newStatus) => {
    if (newStatus === 'success') {
        isOpen.value = false;
        toast.add({ title: "Destination has been created" })
        emit('destinationCreated');
    }
});
</script>
