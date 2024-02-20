<script setup>

import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from '../../Components/Textarea.vue';

const form = useForm({
    name: '',
    email: '',
    message: '',
})

function submit() {
    form.post(route('contact.store'), {
        onSuccess: () => form.reset(),
    })
}

</script>

<template>
    <Head title="Contact us" />

    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 pt-8">
        <div class="">
            Contact Us
        </div>

        <div>
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
                    <InputLabel for="message">Message</InputLabel>
                    <Textarea id="message" rows="5" v-model="form.message" />
                    <InputError class="mt-1" :message="form.errors.message"></InputError>
                </div>

                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Submit</PrimaryButton>

                    <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Message sent.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </div>
</template>