<script setup>

import Pagination from '@/Components/Pagination.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce.js'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()

const user = computed(() => page.props.auth.user)

const props = defineProps({
    posts: Object,
    filters: Object,
});

let search = ref(props.filters.search);

watch(search, debounce(function (value) {
    router.get('/posts', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 150));

</script>


<template>
    <Head title="Posts" />

    <div class="w-full">
        <div class="flex justify-between mb-5">
            <div>
                <h1 class="font-semibold text-2xl">Posts</h1>
            </div>
            <div>
                <input type="search" id="search" v-model="search" placeholder="Search title..."
                    class="border rounded px-3 py-1.5 mr-2">
                <!-- <Link href="/posts/create" class="bg-blue-500 text-white px-3 py-2 rounded">New Post</Link> -->
            </div>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border-b text-left">
                        Title
                    </th>
                    <th class="border-b text-left">
                        Content
                    </th>
                    <th class="border-b text-left">

                    </th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr v-for="post in posts.data" :key="post.id">
                    <th class="border-b py-2 font-normal">
                        {{ post.title }}
                    </th>
                    <td class="border-b py-2">
                        {{ post.content.substr(0, 90) + '...' }}
                    </td>
                    <td class="border-b py-2 text-blue-500 text-right">
                        <button type="button" v-if="user && post.user_id == user.id">
                            Edit
                        </button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <Pagination :links="posts.links" class="mt-6 flex justify-end" />
</template>