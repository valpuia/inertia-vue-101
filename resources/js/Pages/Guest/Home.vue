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
    <Head :title="$t('Welcome')" />

    <div class="md:py-52 py-20 relative">
        <img class="absolute inset-0 h-full w-full object-cover bg-center bg-no-repeat block" src="/images/banner.jpg"
            alt="banner" loading="lazy" />

        <div class="absolute inset-0 bg-gray-50 bg-opacity-70 dark:bg-gray-600 dark:bg-opacity-70 block"></div>

        <div class="container mx-auto relative text-center">
            <div
                class="text-4xl font-bold bg-gradient-to-r from-sky-600 via-violet-400 to-pink-500 text-transparent bg-clip-text">
                {{ $t('app.welcome') }}
            </div>
        </div>
    </div>

    <div class="mt-4 mx-auto p-4 xl:px-0 container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template v-for="(post, index) in allPosts" :key="index">
                        <Link :href="route('show.post.detail', post.slug)"
                            class="bg-gray-100 dark:bg-gray-900 border dark:border-gray-800 rounded-lg p-5">
                        <div class="font-semibold">{{ post.title }}</div>
                        <div>{{ post.content.substr(0, 85) + '...' }}</div>
                        <div class="text-xs text-gray-500 mt-1">-- {{ post.user.name }}</div>
                        </Link>
                    </template>
                </div>

                <div class="flex justify-center mt-3" v-if="nextUrl">
                    <button @click="loadMorePost"
                        class="border dark:border-gray-800 rounded bg-gray-100 dark:bg-gray-900 px-2 py-1 disabled:bg-gray-400"
                        :disabled="loading">
                        {{ $t('Load more') }}<span v-show="loading">...</span>
                    </button>
                </div>
            </div>

            <div>
                <div
                    class="rounded-lg p-5 flex justify-center bg-gradient-to-r from-amber-400 to-orange-400 text-white font-semibold">
                    ADS
                </div>

                <div class="mt-4">
                    <img src="/images/dragon.jpg" alt="dragon" loading="lazy" class="rounded-xl">
                </div>
            </div>
        </div>
    </div>
</template>