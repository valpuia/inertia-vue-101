<script setup>

import SimplePagination from '@/Components/SimplePagination.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

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
    <Head title="Contacts" />

    <div class="w-full">
        <div class="mb-5">
            <h1 class="font-semibold text-2xl">Contacts</h1>
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
                    <th class="border-b text-left" id="message">
                        Message
                    </th>
                    <th class="border-b text-left" id="action"></th>
                </tr>
            </thead>

            <tbody class="text-left">
                <tr v-for="contact in contacts.data" :key="contact.id">
                    <td class="border-b py-2">
                        {{ contact.name }}
                    </td>
                    <td class="border-b py-2">
                        {{ contact.email }}
                    </td>
                    <td class="border-b py-2">
                        {{ contact.message.substr(0, 20) + '...' }}
                    </td>
                    <td class="border-b py-2 text-right">
                        <button type="button" class="mr-2 text-gray-600" @click="showContactModal(contact)">
                            View
                        </button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <SimplePagination v-if="props.contacts.data.length" :prevUrl="props.contacts.prev_page_url"
        :nextUrl="props.contacts.next_page_url" :total="props.contacts.total" :from="props.contacts.from"
        :to="props.contacts.to" class="mt-6" />

    <Modal :show="openContactView">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Details
            </h2>

            <div class="grid grid-cols-3 gap-4">
                <div>Name</div>
                <div class="col-span-2">{{ contactData.name }}</div>

                <div>Email</div>
                <div class="col-span-2">{{ contactData.email }}</div>

                <div>Message</div>
                <div class="col-span-2">{{ contactData.message }}</div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeEditModal">Close</SecondaryButton>
            </div>
        </div>
    </Modal>
</template>