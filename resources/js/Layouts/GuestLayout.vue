<script setup>

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import ThemeToggle from '@/Components/ThemeToggle.vue';
import LocaleSwitcher from '../Components/LocaleSwitcher.vue';
const appName = import.meta.env.VITE_APP_NAME || 'My App';

const page = usePage()

const user = computed(() => page.props.auth.user)

</script>

<template>
    <div class="flex flex-col h-screen">
        <section class="bg-gray-200 dark:bg-gray-900 text-gray-950 dark:text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <Link href="/" class="font-bold text-2xl">{{ appName }}</Link>

                <div class="flex items-center">
                    <LocaleSwitcher class="mr-3" />
                    <ThemeToggle class="mr-3" />
                    <Link href="/login" v-if="user == null">{{ $t('Login') }}</Link>
                    <Link href="/dashboard" v-else>{{ $t('Dashboard') }}</Link>
                </div>
            </div>
        </section>

        <main class="flex-grow bg-gray-50 dark:bg-gray-950 text-gray-950 dark:text-white pb-5">
            <slot />
        </main>

        <footer class="bg-gray-200 dark:bg-gray-900 text-gray-950 dark:text-white">
            <div class="container py-4 mx-auto flex items-center sm:flex-row flex-col">
                <a class="flex title-font font-medium items-center md:justify-start justify-center">
                    <img src="/logo/dark.png" alt="logo" class="w-10 h-10 dark:hidden">
                    <img src="/logo/white.png" alt="logo" class="w-10 h-10 hidden dark:flex">
                    <span class="ml-3 text-xl">{{ appName }}</span>
                </a>
                <p class="text-sm sm:ml-4 sm:pl-4 sm:border-l sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">
                    &copy; 2023. {{ $t('All right reserved') }}.
                </p>
                <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
                    <Link :href="route('contact.us')" class="ml-3" :class="{ 'underline': route().current('contact.us') }">
                    {{ $t('Contacts') }}
                    </Link>
                </span>
            </div>
        </footer>
    </div>
</template>