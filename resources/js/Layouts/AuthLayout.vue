<script setup>

import Nav from '../Shared/Nav.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ThemeToggle from '../Components/ThemeToggle.vue';

const page = usePage()

const user = computed(() => page.props.auth.user)

</script>

<template>
    <Head>
        <title>Welcome to My App</title>
        <meta name="description" content="This is default meta" head-key="description">
    </Head>

    <div class="flex flex-col h-screen">
        <section class="bg-gray-200 dark:bg-gray-900 text-gray-950 dark:text-white p-4">
            <div class="container mx-auto flex justify-between">
                <div class="flex items-center">
                    <Link :href="route('dashboard')" class="font-bold text-2xl mr-4">
                    <img src="/logo/dark.png" alt="logo" class="w-10 h-10 dark:hidden">
                    <img src="/logo/white.png" alt="logo" class="w-10 h-10 hidden dark:flex">
                    </Link>

                    <Nav class="hidden sm:flex" />
                </div>

                <div class="flex sm:items-center sm:ms-6">
                    <ThemeToggle />

                    <div class="ms-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-white bg-white dark:bg-gray-600 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ user.name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
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

        <main class="flex-grow bg-gray-50 dark:bg-gray-950 text-gray-950 dark:text-white">
            <div class="container mx-auto mt-4 px-5 md:px-0">
                <slot />
            </div>
        </main>
    </div>
</template>