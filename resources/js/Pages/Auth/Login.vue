<script setup>

import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const form = useForm({
    email: '',
    password: '',
})

defineOptions({
    layout: null,
});

function submit() {
    form.post('/login', form)
}

</script>

<template>
    <Head title="Login" />

    <main class="grid place-items-center min-h-screen">
        <section class="bg-white p-8 rounded max-w-md mx-auto shadow-md min-w-60">
            <h1 class="text-3xl uppercase font-bold">Login</h1>

            <form @submit.prevent="submit" class="mt-8">
                <div class="mb-6">
                    <InputLabel for="email">Email</InputLabel>
                    <TextInput type="email" v-model="form.email" id="email" required />
                    <InputError class="mt-1" :message="form.errors.email"></InputError>
                </div>

                <div class="mb-6">
                    <InputLabel for="password">Password</InputLabel>
                    <TextInput type="password" v-model="form.password" id="password" required />
                </div>

                <button type="submit" class="bg-blue-500 py-2 px-4 text-white rounded"
                    :disabled="form.processing">Login</button>
            </form>
        </section>
    </main>
</template>