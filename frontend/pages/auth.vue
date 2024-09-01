<script setup lang="ts">
import { ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import LoginForm from '~/components/forms/login.vue';
import RegisterForm from '~/components/forms/register.vue';

definePageMeta({
    middleware: [
        "user-already-authenticated"
    ]
})

const items = [{
    slot: 'login',
    label: 'Login'
}, {
    slot: 'register',
    label: 'Register'
}];

const router = useRouter();
const route = useRoute();

const tabIndex = ref(route.query.action === "register" ? 1 : 0);


function onLoginSuccess() {
    router.push("/dashboard");
}

function onRegisterSuccess() {
    router.push("/auth?action=login");
    tabIndex.value = 0;
}

watch(() => route.query.action, (newAction) => {
    tabIndex.value = newAction === "register" ? 1 : 0;
});

</script>

<template>
    <NuxtLayout name="landing">
        <UTabs :items="items" class="w-full mt-16" :default-index="tabIndex" v-model="tabIndex">
            <template #login="{ item }">
                <LoginForm @loginSuccess="onLoginSuccess" />
            </template>
            <template #register="{ item }">
                <RegisterForm @registerSuccess="onRegisterSuccess" />
            </template>
        </UTabs>
    </NuxtLayout>
</template>
