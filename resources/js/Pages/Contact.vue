<script setup>

import SimplePagination from '@/Components/SimplePagination.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { EyeIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const props = defineProps({
    contacts: Object,
});

let openContactView = ref(false);
let contactData = ref('');

const showContactModal = (selectedContact) => {
    openContactView.value = true;
    contactData.value = selectedContact;
};

const closeEditModal = () => {
    openContactView.value = false;
    contactData.value = '';
};

</script>

<template>
    <Head :title="$t('Contacts')" />

    <h2 class="text-2xl font-semibold leading-tight mb-4">{{ $t('Contacts') }}</h2>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('name') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('email') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('message') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b border-gray-200 dark:border-gray-800 bg-gray-200 dark:bg-gray-900 dark:text-gray-200 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ $t('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="contacts.data.length" v-for="contact in contacts.data" :key="contact.id">
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ contact.name }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ contact.email }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm">
                        <p class="text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                            {{ contact.message.substr(0, 20) + '...' }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-3 border-b border-gray-200 bg-gray-100 dark:bg-gray-900 dark:border-gray-800 text-sm text-right">
                        <button type="button" @click="showContactModal(contact)" class="mr-2 text-blue-500">
                            <EyeIcon class="w-5 h-5" />
                        </button>
                    </td>
                </tr>

                <tr v-else>
                    <td colspan="4" class="px-3 py-3 border-gray-200 bg-gray-100 dark:bg-gray-900 text-sm text-center">
                        <p class="text-gray-950 dark:text-white whitespace-no-wrap">
                            No data found
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <SimplePagination v-if="props.contacts.data.length" :prevUrl="props.contacts.prev_page_url"
        :nextUrl="props.contacts.next_page_url" :total="props.contacts.total" :from="props.contacts.from"
        :to="props.contacts.to" class="mt-6" />

    <Modal :show="openContactView">
        <div class="p-6 dark:bg-gray-800 dark:text-white">
            <h2 class="text-lg font-medium mb-4">
                {{ $t('Details') }}
            </h2>

            <div class="grid grid-cols-3 gap-4">
                <div>{{ $t('name') }}</div>
                <div class="col-span-2">{{ contactData.name }}</div>

                <div>{{ $t('email') }}</div>
                <div class="col-span-2">{{ contactData.email }}</div>

                <div>{{ $t('message') }}</div>
                <div class="col-span-2">{{ contactData.message }}</div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeEditModal">{{ $t('Close') }}</SecondaryButton>
            </div>
        </div>
    </Modal>
</template>