<script setup>

import axios from 'axios';
import { ref } from 'vue';

const props = defineProps({
    posts: Object,
})

const allPosts = ref(props.posts.data);
const nextUrl = ref(props.posts.next_page_url);
const loading = ref(false);

const loadMorePost = () => {
    loading.value = true;

    axios.get(nextUrl.value).then(response => {
        allPosts.value = [...allPosts.value, ...response.data.data];

        nextUrl.value = response.data.next_page_url;

        loading.value = false;
    })
}

</script>

<template>
    <Head title="Welcome" />

    <div class="w-100 grid grid-cols-1 md:grid-cols-3 gap-4">
        <template v-for="(post, index) in allPosts" :key="index">
            <Link :href="route('show.post.detail', post.slug)" class="bg-gray-50 shoadow border rounded-xl p-5">
            <div class="font-semibold">{{ post.title }}</div>
            <div>{{ post.content.substr(0, 85) + '...' }}</div>
            <div class="text-xs text-gray-500 mt-1">-- {{ post.user.name }}</div>
            </Link>
        </template>
    </div>

    <div class="flex justify-center mt-3" v-if="nextUrl">
        <button @click="loadMorePost" class="border rounded bg-gray-50 px-2 py-1 disabled:bg-gray-400" :disabled="loading">
            Load more<span v-show="loading">...</span>
        </button>
    </div>
</template>