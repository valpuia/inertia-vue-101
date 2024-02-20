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

    <div class="w-full">
        <div class="flex justify-between mb-5">
            <div>
                <h1 class="font-semibold text-2xl">Users</h1>
            </div>
            <div>
                <input type="search" id="search" v-model="search" placeholder="Search..."
                    class="rounded px-3 py-1.5 mr-2 dark:bg-gray-500">
                <Link href="/users/create" class="bg-blue-500 text-white px-3 py-2 rounded">New User</Link>
            </div>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border-b text-left" id="name">
                        Name
                    </th>
                    <th class="border-b text-left" id="email">
                        Email
                    </th>
                    <th class="border-b text-left" id="action"></th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr v-for="user in users.data" :key="user.id">
                    <td class="border-b py-2">
                        {{ user.name }}
                    </td>
                    <td class="border-b py-2">
                        {{ user.email }}
                    </td>
                    <td class="border-b py-2 text-right">
                        <button type="button" @click="showEditForm(user)" class="mr-2 text-blue-500">
                            Edit
                        </button>

                        <button @click="confirmDelete(user.id)" class="text-red-500">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <Pagination :links="users.links" class="mt-6 flex justify-end" />

    <Modal :show="openEditUser">
        <div class="p-6 dark:bg-gray-600 dark:text-gray-200">
            <h2 class="text-lg font-medium">
                Edit User
            </h2>

            <div class="mt-6">
                <InputLabel for="name">Name</InputLabel>
                <TextInput type="text" v-model="form.name" id="name" />
                <InputError class="mt-1" :message="form.errors.name"></InputError>
            </div>

            <div class="mt-6">
                <InputLabel for="email">Email</InputLabel>
                <TextInput type="email" v-model="form.email" id="email" />
                <InputError class="mt-1" :message="form.errors.email"></InputError>
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
        <div class="p-6 dark:bg-gray-600 dark:text-gray-200">
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