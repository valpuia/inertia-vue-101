<script setup>

import Nav from '../Shared/Nav.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const page = usePage()

const user = computed(() => page.props.auth.user)

</script>

<template>
    <Head>
        <title>Welcome to My App</title>
        <meta name="description" content="This is default meta" head-key="description">
    </Head>

    <section class="bg-gray-200 p-4">
        <div class="container mx-auto flex justify-between">
            <div class="flex items-center">
                <Link :href="route('dashboard')" class="font-bold text-2xl mr-4">
                <img src="/logo.png" alt="logo" class="h-10 w-10">
                </Link>

                <Nav class="hidden sm:flex" />
            </div>

            <div class="flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    {{ user.name }}

                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('home')">Home</DropdownLink>

                            <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-4 container mx-auto p-4 md:px-0">
        <slot />
    </section>
</template>