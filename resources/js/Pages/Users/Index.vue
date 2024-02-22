<script setup>

import Pagination from '@/Components/Pagination.vue';
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import debounce from 'lodash/debounce.js'
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    users: Object,
    filters: Object,
});

const form = useForm({
    id: '',
    name: '',
    email: '',
});

let search = ref(props.filters.search);
let openEditUser = ref(false);
let openDeleteModal = ref(false);
let idToBeDeleted = ref('');

watch(search, debounce(function (value) {
    router.get('/users', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 150));

const showEditForm = (selectedUser) => {
    openEditUser.value = true;

    form.id = selectedUser.id;
    form.name = selectedUser.name;
    form.email = selectedUser.email;
};

const closeEditModal = () => {
    openEditUser.value = false;

    form.reset();
};

const updateUser = () => {
    form.patch('/users/' + form.id, {
        preserveScroll: true,
        onSuccess: () => closeEditModal(),
        onFinish: () => form.reset(),
    });
};

const confirmDelete = (id) => {
    openDeleteModal.value = true;

    idToBeDeleted = id;
};

const closeDeleteModal = () => {
    openDeleteModal.value = false;

    idToBeDeleted = '';
};

const deleteUser = () => {
    router.delete(route('users.destroy', idToBeDeleted));

    closeDeleteModal();
};

</script>

<template>
    <Head title="Users" />

    <div class="flex justify-between">
        <h2 class="text-2xl font-semibold leading-tight">Users</h2>

        <Link :href="route('users.create')" class="bg-blue-500 text-white px-3 py-1.5 ml-2 rounded">New User</Link>
    </div>

    <div class="my-2 flex sm:flex-row flex-col justify-end">
        <div class="block relative">
            <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current">
                    <path
                        d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                    </path>
                </svg>
            </span>
            <input placeholder="Search..." v-model="search" type="search"
                class="appearance-none w-full rounded border bg-gray-50 border-gray-200 dark:border-gray-800 dark:bg-gray-900 block pl-8 pr-6 py-2 focus:outline-none" />
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Name
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Email
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="users.data.length" v-for="user in users.data" :key="user.id">
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ user.name }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ user.email }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm text-right">
                        <button type="button" @click="showEditForm(user)" class="mr-2 text-blue-500">
                            <PencilSquareIcon class="w-5 h-5" />
                        </button>

                        <button @click="confirmDelete(user.id)" class="text-red-500">
                            <TrashIcon class="w-5 h-5" />
                        </button>
                    </td>
                </tr>

                <tr v-else>
                    <td colspan="3" class="px-3 py-3 border-gray-200 bg-gray-100 dark:bg-gray-900 text-sm text-center">
                        <p class="text-gray-950 dark:text-white whitespace-no-wrap">
                            No data found
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <Pagination :links="users.links" class="mt-6 flex justify-end" />

    <Modal :show="openEditUser">
        <div class="p-6 dark:bg-gray-800 dark:text-white">
            <h2 class="text-lg font-medium">
                Edit User
            </h2>

            <div class="mt-6">
                <InputLabel class="required" for="name">Name</InputLabel>
                <TextInput required type="text" v-model="form.name" id="name" />
                <InputError class="mt-1" :message="form.errors.name" />
            </div>

            <div class="mt-6">
                <InputLabel class="required" for="email">Email</InputLabel>
                <TextInput required type="email" v-model="form.email" id="email" />
                <InputError class="mt-1" :message="form.errors.email" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeEditModal"> Cancel </SecondaryButton>

                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="updateUser">
                    Update
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="openDeleteModal">
        <div class="p-6 dark:bg-gray-800 dark:text-white">
            <h2 class="text-lg font-medium">
                Delete User?
            </h2>

            <div class="mt-6">
                Are you sure you want to do this
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeDeleteModal"> Cancel </SecondaryButton>

                <DangerButton @click="deleteUser" class="ml-2">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>