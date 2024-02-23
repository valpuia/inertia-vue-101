<script setup>

import BackButton from '@/Components/BackButton.vue';

defineProps({
    post: Object,
    date: String,
});

</script>

<template>
    <Head :title="post.title" />

    <section class="max-w-md mx-auto mt-6">
        <div class="border rounded-xl bg-gray-100 dark:bg-gray-900 dark:border-gray-800 p-4 mb-4">
            <div class="font-semibold text-2xl">{{ post.title }}</div>

            <div class="text-sm text-gray-600 dark:text-gray-400 py-2">{{ post.user.name + ' | ' + date }}</div>

            <div>{{ post.content }}</div>
        </div>

        <BackButton :href="route('home')">Back</BackButton>
    </section>
</template>