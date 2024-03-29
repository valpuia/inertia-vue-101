<script setup>

import SimplePagination from '@/Components/SimplePagination.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce.js';
import { PencilSquareIcon, TrashIcon, EyeIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    posts: Object,
    filters: Object,
});

let openDeleteConfirmationModal = ref(false);
let search = ref(props.filters.search);
let status = ref(props.filters.status ?? '');
let idToBeDeleted = ref('');

watch([search, () => status.value], debounce(function ([search, status]) {
    router.get('/posts', { search: search, status: status }, {
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
    <Head :title="$t('Posts')" />

    <div class="flex justify-between">
        <h2 class="text-2xl font-semibold leading-tight">{{ $t('Posts') }}</h2>

        <Link :href="route('posts.create')" class="bg-blue-500 text-white px-3 py-1.5 ml-2 rounded">{{ $t('New Post') }}
        </Link>
    </div>

    <div class="my-2 flex sm:flex-row flex-col justify-end">
        <div class="flex flex-row mb-1 sm:mb-0">
            <div class="relative">
                <select v-model="status"
                    class="appearance-none h-full rounded-l rounded-r border block w-full bg-gray-50 border-gray-200 dark:border-gray-800 dark:bg-gray-900 px-4 pr-8 py-2 focus:outline-none sm:rounded-r-none sm:border-r-0 border-r">
                    <option value="">{{ $t('All') }}</option>
                    <option value="1">{{ $t('Published') }}</option>
                    <option value="false">{{ $t('Unpublish') }}</option>
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-200">
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
            <input :placeholder="$t('Search...')" v-model="search" type="search"
                class="appearance-none rounded-r rounded-l sm:rounded-l-none border bg-gray-50 border-gray-200 dark:border-gray-800 dark:bg-gray-900 block pl-8 pr-6 py-2 focus:outline-none w-full" />
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('title') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('content') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('Status') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('Creator') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="posts.data.length" v-for="post in posts.data" :key="post.id">
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ post.title }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ post.content.substr(0, 50) + '...' }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="whitespace-no-wrap capitalize" :class="post.publish ? 'text-green-600' : 'text-red-500'">
                            {{ post.publish ? $t('Published') : $t('Unpublish') }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ post.user.name }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm text-right">
                        <Link :href="route('posts.show', post.id)"
                            class="mr-2 text-gray-600 dark:text-gray-300 inline-flex">
                        <EyeIcon class="w-5 h-5" />
                        </Link>

                        <Link :href="route('posts.edit', post.id)" class="mr-2 text-blue-500 inline-flex">
                        <PencilSquareIcon class="w-5 h-5" />
                        </Link>

                        <button @click="confirmModal(post.id)" class="text-red-500 inline-flex">
                            <TrashIcon class="w-5 h-5" />
                        </button>
                    </td>
                </tr>

                <tr v-else>
                    <td colspan="5" class="px-3 py-3 border-gray-200 bg-gray-100 dark:bg-gray-900 text-sm text-center">
                        <p class="text-gray-950 dark:text-white whitespace-no-wrap">
                            {{ $t('No data found') }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <SimplePagination v-if="props.posts.data.length" :prevUrl="props.posts.prev_page_url"
        :nextUrl="props.posts.next_page_url" :total="props.posts.total" :from="props.posts.from" :to="props.posts.to"
        class="mt-6" />

    <Modal :show="openDeleteConfirmationModal">
        <div class="p-6 dark:bg-gray-800 dark:text-white">
            <h2 class="text-lg font-medium">
                {{ $t('Delete Post?') }}
            </h2>

            <div class="mt-6">
                {{ $t('Are you sure you want to do this') }}
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">{{ $t('Cancel') }}</SecondaryButton>

                <DangerButton @click="deletePost" class="ml-2">
                    {{ $t('Delete') }}
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>