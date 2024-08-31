<!-- components/LoginForm.vue -->
<template>
    <UForm :schema="loginSchema" :state="loginForm" class="space-y-4" @submit="onSubmit">
        <div class="mt-8">
            <p class="pb-4 text-xl font-serif font-semibold leading-6 text-gray-900 dark:text-white">
                Login
            </p>

            <UFormGroup label="Email" name="email" type="email" class="mb-3">
                <UInput v-model="loginForm.email" type="email" />
            </UFormGroup>

            <UFormGroup label="Password" name="password" class="mb-6">
                <UInput v-model="loginForm.password" type="password" />
            </UFormGroup>

            <UButton type="submit" class="mb-4" color="black">
                Login
            </UButton>

            <div>
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

const emit = defineEmits(['loginSuccess']);

const loginSchema = object({
    email: string().email('Invalid email').required('Required'),
    password: string()
        .min(8, 'Must be at least 8 characters')
        .required('Required')
});

type LoginSchema = InferType<typeof loginSchema>;

const loginForm = reactive({ email: '', password: '' });

const loginEndpoint = useRuntimeConfig().public.loginEndpoint;
const event = useRequestEvent();

const {
    errorMessage: errorMessage,
    status: status,
    submitForm: submitLoginForm,
    validationErrors: validationErrors,
} = useFormSubmit(loginEndpoint, true, event);

async function onSubmit(event: FormSubmitEvent<LoginSchema>) {
    await submitLoginForm(event.data);
}

watch(status, (newStatus) => {
    if (newStatus === 'success') {
        emit('loginSuccess');
    }
});
</script>