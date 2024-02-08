<script setup>

import Pagination from '@/Components/Pagination.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce.js';
import { computed } from 'vue';

const page = usePage()

const user = computed(() => page.props.auth.user)

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

    <div class="w-full">
        <div class="flex justify-between mb-5">
            <div>
                <h1 class="font-semibold text-2xl">Posts</h1>
            </div>
            <div>
                <input type="search" id="search" v-model="search" placeholder="Search title..."
                    class="border rounded px-3 py-1.5 mr-2">
                <Link href="/posts/create" class="bg-blue-500 text-white px-3 py-2 rounded">New Post</Link>
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
                        Publish
                    </th>
                    <th class="border-b text-left">
                        Action
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
                    <td class="border-b py-2 capitalize" :class="post.publish ? 'text-green-600' : 'text-red-500'">
                        {{ post.publish }}
                    </td>
                    <td class="border-b py-2 text-right">
                        <Link :href="route('posts.show', post.id)" class="mr-2 text-gray-600">View</Link>

                        <Link :href="route('posts.edit', post.id)" class="mr-2 text-blue-500">Edit</Link>

                        <button @click="confirmModal(post.id)" class="text-red-500">Delete</button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <Pagination :links="posts.links" class="mt-6 flex justify-end" />

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