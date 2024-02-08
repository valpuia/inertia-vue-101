<script setup>

import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({
    title: '',
    content: '',
    publish: false,
})

function submit() {
    form.post(route('posts.store'), form)
}

</script>

<template>
    <Head title="New Post" />

    <h1 class="font-bold">New Post</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto pt-8">
        <div class="mb-6">
            <InputLabel for="title">Title</InputLabel>
            <TextInput type="text" v-model="form.title" id="title" />
            <InputError class="mt-1" :message="form.errors.title"></InputError>
        </div>

        <div class="mb-6">
            <InputLabel for="content">Content</InputLabel>
            <textarea name="content" id="content" rows="5" v-model="form.content"
                class="w-full border rounded-lg p-2"></textarea>
            <InputError class="mt-1" :message="form.errors.content"></InputError>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <Checkbox name="publish" v-model:checked="form.publish" />
                <span class="ms-2">Publish</span>
            </label>
        </div>

        <PrimaryButton type="submit" :disabled="form.processing">
            Submit
        </PrimaryButton>

        <Link :href="route('posts.index')" class="border rounded-lg bg-gray-50 px-4 py-3 ml-2">Back</Link>
    </form>
</template>