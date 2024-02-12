<script setup>

defineProps({
    post: Object,
    date: String,
});

</script>

<template>
    <Head :title="post.title" />

    <section class="max-w-md mx-auto mt-6">
        <div class="border rounded-xl bg-gray-100 p-4 mb-4">
            <div class="font-semibold text-2xl">{{ post.title }}</div>

            <div class="text-sm text-gray-600 py-2">{{ post.user.name + ' | ' + date }}</div>

            <div>{{ post.content }}</div>
        </div>

        <Link :href="route('home')" class="border px-2 py-1 bg-gray-100 rounded">Back</Link>
    </section>
</template>