<script setup>

import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    post: Object,
})

</script>

<template>
    <Head title="View Post" />

    <h1 class="font-bold">View Post</h1>

    <form class="max-w-md mx-auto pt-8">
        <div class="mb-6">
            <InputLabel for="title">Title</InputLabel>
            <TextInput type="text" v-model="post.title" id="title" disabled />
        </div>

        <div class="mb-6">
            <InputLabel for="content">Content</InputLabel>
            <textarea name="content" id="content" rows="5" v-model="post.content" class="w-full border rounded-lg p-2"
                disabled></textarea>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <Checkbox name="publish" v-model:checked="post.publish" disabled />
                <span class="ms-2">Publish</span>
            </label>
        </div>

        <Link :href="route('posts.index')" class="border rounded-lg bg-gray-50 dark:bg-gray-500 px-4 py-3 ml-2">Back</Link>
    </form>
</template>