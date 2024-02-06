<script setup>

import Pagination from '../../Components/Pagination.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce.js'
import Modal from '../../Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
    filters: Object,
});

const form = useForm({
    name: '',
});

let search = ref(props.filters.search);
let openEditUser = ref(false);
let editUserId = ref('');

watch(search, debounce(function (value) {
    router.get('/users', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 150));

const showEditForm = (id, name) => {
    openEditUser.value = true;
    editUserId = id;
    form.name = name;
};

const closeModal = () => {
    openEditUser.value = false;
    editUserId = '';

    form.reset();
};

const updateUser = () => {
    form.patch('/users/' + editUserId, {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
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
                    class="border rounded px-3 py-1.5 mr-2">
                <Link href="/users/create" class="bg-blue-500 text-white px-3 py-2 rounded">New User</Link>
            </div>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border-b text-left">
                        Name
                    </th>
                    <th class="border-b text-left">
                        Email
                    </th>
                    <th class="border-b text-left">

                    </th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr v-for="user in users.data" :key="user.id">
                    <th class="border-b py-2 font-normal">
                        {{ user.name }}
                    </th>
                    <td class="border-b py-2">
                        {{ user.email }}
                    </td>
                    <td class="border-b py-2 text-blue-500 text-right">
                        <button type="button" @click="showEditForm(user.id, user.name)">
                            Edit
                        </button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <Pagination :links="users.links" class="mt-6 flex justify-end" />

    <Modal :show="openEditUser">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Edit User
            </h2>

            <div class="mt-6">
                <InputLabel for="name">Name</InputLabel>
                <TextInput type="text" v-model="form.name" id="name" />
                <InputError class="mt-1" :message="form.errors.name"></InputError>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="updateUser">
                    Update
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>