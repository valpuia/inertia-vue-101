<script setup>

import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
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
            <InputLabel for="name">Name</InputLabel>
            <TextInput type="text" v-model="form.name" id="name" />
            <InputError class="mt-1" :message="form.errors.name"></InputError>
        </div>

        <div class="mb-6">
            <InputLabel for="email">Email</InputLabel>
            <TextInput type="email" v-model="form.email" id="email" />
            <InputError class="mt-1" :message="form.errors.email"></InputError>
        </div>

        <div class="mb-6">
            <InputLabel for="password">Password</InputLabel>
            <TextInput type="password" v-model="form.password" id="password" />
            <InputError class="mt-1" :message="form.errors.password"></InputError>
        </div>

        <PrimaryButton type="submit" :disabled="form.processing">
            Submit
        </PrimaryButton>
    </form>
</template>