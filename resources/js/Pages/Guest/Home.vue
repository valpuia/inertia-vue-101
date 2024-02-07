<script setup>

import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    posts: Object,
})

const allPosts = ref(props.posts.data);
const currentPage = ref(props.posts.current_page);
const loadingMore = ref(false)

const loadMorePost = () => {
    loadingMore.value = true

    router.get(route('home', { page: currentPage.value + 1 }), {}, {
        only: ['posts'],
        replace: false,
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            allPosts.value = [...allPosts.value, ...props.posts.data];
            currentPage.value++;

            setTimeout(() => {
                window.scrollTo(0, window.scrollY + 100);
            }, 0);

            loadingMore.value = false
        }
    });

}

</script>

<template>
    <Head title="Welcome" />

    <div class="w-100 grid grid-cols-3 gap-4">
        <template v-for="(post, index) in allPosts" :key="index">
            <div class="bg-gray-50 shoadow border rounded-xl p-5">
                <div class="font-semibold">{{ post.title }}</div>
                <div>{{ post.content.substr(0, 85) + '...' }}</div>
                <div class="text-xs text-gray-500 mt-1">-- {{ post.user.name }}</div>
            </div>
        </template>
    </div>

    <div class="flex justify-center mt-3" v-if="props.posts.next_page_url">
        <button @click="loadMorePost" class="border rounded bg-gray-50 px-2 py-1">
            Load more...
        </button>
    </div>
</template>