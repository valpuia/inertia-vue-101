<script setup>

import { useForm } from 'laravel-precognition-vue-inertia';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm('post', route('users.store'), {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => form.submit();

</script>

<template>
    <Head title="New User" />

    <h1 class="font-bold">New User</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto pt-8">
        <div class="mb-6">
            <InputLabel class="required" for="name">Name</InputLabel>
            <TextInput required type="text" v-model="form.name" id="name" @change="form.validate('name')" />
            <InputError class="mt-1" :message="form.errors.name" />
        </div>

        <div class="mb-6">
            <InputLabel class="required" for="email">Email</InputLabel>
            <TextInput required type="email" v-model="form.email" id="email" @change="form.validate('email')" />
            <InputError class="mt-1" :message="form.errors.email" />
        </div>

        <div class="mb-6">
            <InputLabel class="required" for="password">Password</InputLabel>
            <TextInput required type="password" v-model="form.password" id="password" @change="form.validate('password')" />
            <InputError class="mt-1" :message="form.errors.password" />
        </div>

        <div class="mb-6">
            <InputLabel class="required" for="password_confirmation">Password Confirmation</InputLabel>
            <TextInput required type="password" v-model="form.password_confirmation" id="password_confirmation"
                @change="form.validate('password_confirmation')" />
            <InputError class="mt-1" :message="form.errors.password_confirmation" />
        </div>

        <PrimaryButton type="submit" :disabled="form.processing">
            Submit
        </PrimaryButton>
    </form>
</template>