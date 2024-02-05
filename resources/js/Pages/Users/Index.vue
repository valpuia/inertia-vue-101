<script setup>

import Pagination from '../../Components/Pagination.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
    filters: Object,
})

let search = ref(props.filters.search)

watch(search, value => {
    router.get('/users', { search: value }, {
        preserveState: true,
        replace: true,
    });
})

</script>

<template>
    <Head title="Users" />

    <div class="w-full">
        <div class="flex justify-between mb-5">
            <div>
                <h1 class="font-semibold">Users</h1>
            </div>
            <div>
                <input type="search" id="search" v-model="search" placeholder="Search..." class="border rounded px-3 mr-2">
                <Link href="/users/create" class="bg-blue-500 text-white px-3 py-1 rounded">+Add</Link>
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
                        Edit
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <Pagination :links="users.links" class="mt-6 flex justify-end" />
</template>