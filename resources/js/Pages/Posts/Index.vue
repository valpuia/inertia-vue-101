<script setup>

import SimplePagination from '@/Components/SimplePagination.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce.js';

const props = defineProps({
    posts: Object,
    filters: Object,
});

let openDeleteConfirmationModal = ref(false);
let search = ref(props.filters.search);
let idToBeDeleted = ref('');

watch(search, debounce(function (value) {
    router.get('/posts', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 150));

const confirmModal = (id) => {
    openDeleteConfirmationModal.value = true;
    idToBeDeleted = id;
};

const closeModal = () => {
    openDeleteConfirmationModal.value = false;
    idToBeDeleted = '';
};

const deletePost = () => {
    router.delete(route('posts.destroy', idToBeDeleted));

    closeModal();
};

</script>


<template>
    <Head title="Posts" />

    <div class="flex justify-between">
        <h2 class="text-2xl font-semibold leading-tight">Posts</h2>

        <Link href="/posts/create" class="bg-blue-500 text-white px-3 py-2 rounded">New Post</Link>
    </div>

    <div class="my-2 flex sm:flex-row flex-col">
        <div class="flex flex-row mb-1 sm:mb-0">
            <div class="relative">
                <select
                    class="appearance-none h-full rounded-l border block w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 sm:rounded-r-none sm:border-r-0 border-r">
                    <option value="all">All</option>
                    <option value="true">Published</option>
                    <option value="false">Unpublish</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="block relative">
            <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                    <path
                        d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                    </path>
                </svg>
            </span>
            <input placeholder="Search" v-model="search"
                class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
        </div>
    </div>

    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Title
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Content
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Creator
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts.data" :key="post.id">
                        <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ post.title }}
                            </p>
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ post.content.substr(0, 50) + '...' }}
                            </p>
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="whitespace-no-wrap capitalize"
                                :class="post.publish ? 'text-green-600' : 'text-red-500'">
                                {{ post.publish }}
                            </p>
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ post.user.name }}
                            </p>
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm">
                            <Link :href="route('posts.show', post.id)" class="mr-2 text-gray-600">View</Link>

                            <Link :href="route('posts.edit', post.id)" class="mr-2 text-blue-500">Edit</Link>

                            <button @click="confirmModal(post.id)" class="text-red-500">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <SimplePagination :prevUrl="props.posts.prev_page_url" :nextUrl="props.posts.next_page_url" :total="props.posts.total"
        :from="props.posts.from" :to="props.posts.to" />

    <Modal :show="openDeleteConfirmationModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Delete Post?
            </h2>

            <div class="mt-6">
                Are you sure you want to do this
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton @click="deletePost" class="ml-2">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>