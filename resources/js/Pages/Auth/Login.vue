<script setup>

import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: null,
    password: null,
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
                    <label for="email" class="block mb-2 uppercase font-bold text-xs">email</label>
                    <input v-model="form.email" type="email" id="email" class="border w-full p-2 rounded">
                    <div v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</div>
                </div>

                <div class="mb-6">
                    <label for="password" class="block mb-2 uppercase font-bold text-xs">password</label>
                    <input v-model="form.password" type="password" id="password" class="border w-full p-2 rounded">
                </div>

                <button type="submit" class="bg-blue-500 py-2 px-4 text-white rounded"
                    :disabled="form.processing">Login</button>
            </form>
        </section>
    </main>
</template>