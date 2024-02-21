<script setup>

import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    email: '',
    password: '',
});

defineOptions({
    layout: null,
});

const submit = () => form.post('/login', form);

</script>

<template>
    <Head title="Login" />

    <main class="grid place-items-center min-h-screen dark:bg-gray-700">
        <section class="bg-white dark:bg-gray-800 dark:text-gray-200 p-8 rounded max-w-md mx-auto shadow-md min-w-60">
            <Link href="/" class="text-sm text-blue-500">&lAarr; Back</Link>
            <h1 class="text-3xl uppercase font-bold">Login</h1>

            <form @submit.prevent="submit" class="mt-8">
                <div class="mb-6">
                    <InputLabel for="email">Email</InputLabel>
                    <TextInput type="email" v-model="form.email" id="email" required />
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>

                <div class="mb-6">
                    <InputLabel for="password">Password</InputLabel>
                    <TextInput type="password" v-model="form.password" id="password" required />
                </div>

                <PrimaryButton type="submit" :disabled="form.processing" class="w-full">
                    Login
                </PrimaryButton>
            </form>
        </section>
    </main>
</template>