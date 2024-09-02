<!-- components/RegisterForm.vue -->
<template>
    <UForm :schema="registerSchema" :state="registerForm" class="space-y-4" @submit="onSubmit">
        <div class="mt-8">
            <p class="pb-4 text-xl font-serif font-semibold leading-6 text-gray-900 dark:text-white">
                Welcome
            </p>

            <UFormGroup label="Name" name="name" class="mb-3">
                <UInput v-model="registerForm.name" placeholder="What do we call you?" />
            </UFormGroup>

            <UFormGroup label="Email" name="email" class="mb-3">
                <UInput v-model="registerForm.email" type="email" />
            </UFormGroup>

            <UFormGroup label="Password" name="password" class="mb-6">
                <UInput v-model="registerForm.password" type="password" />
            </UFormGroup>

            <UButton type="submit" class="mb-3">
                Register
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
import type { FormSubmitEvent } from '#ui/types';
import { defineEmits, reactive, watch } from 'vue';
import { object, string, type InferType } from 'yup';
import { useApiRoutes } from '~/composables/useApiRoutes';
import { useFormSubmit } from '~/composables/useFormSubmit';

const emit = defineEmits(['registerSuccess']);

const registerSchema = object({
    email: string().email('Invalid email').required('Required'),
    name: string().min(2, "Must be 2 or more characters long").max(60, "Name is too long").required('Required'),
    password: string()
        .min(8, 'Must be at least 8 characters')
        .required('Required')
});

type RegisterSchema = InferType<typeof registerSchema>;

const registerForm = reactive({ email: '', password: '', name: '' });

const registerEndpoint = useApiRoutes().registerEndpoint;

const {
    errorMessage: errorMessage,
    status: status,
    submitForm: submitRegisterForm,
    validationErrors: validationErrors,
} = useFormSubmit(registerEndpoint);

async function onSubmit(event: FormSubmitEvent<RegisterSchema>) {
    await submitRegisterForm({ ...event.data, password_confirmation: event.data.password });
}

watch(status, (newStatus) => {
    if (newStatus === 'success') {
        emit('registerSuccess');
    }
});
</script>