<script setup>

import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: null,
    email: null,
    password: null,
})

function submit() {
    form.post('/users', form)
}

</script>

<template>
    <Head title="New User" />

    <h1 class="font-bold">New User</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto pt-8">
        <div class="mb-6">
            <label for="name" class="block mb-2 uppercase font-bold text-xs">Name</label>
            <input v-model="form.name" type="text" id="name" class="border w-full p-2 rounded">
            <div v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</div>
        </div>

        <div class="mb-6">
            <label for="email" class="block mb-2 uppercase font-bold text-xs">email</label>
            <input v-model="form.email" type="email" id="email" class="border w-full p-2 rounded">
            <div v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</div>
        </div>

        <div class="mb-6">
            <label for="password" class="block mb-2 uppercase font-bold text-xs">password</label>
            <input v-model="form.password" type="password" id="password" class="border w-full p-2 rounded">
            <div v-if="form.errors.password" class="mt-1 text-xs text-red-500">{{ form.errors.password }}</div>
        </div>

        <button type="submit" class="bg-blue-500 py-2 px-4 text-white rounded" :disabled="form.processing">Submit</button>
    </form>
</template>