<script setup>

import { ref, onMounted, watch } from 'vue';
import { SunIcon, MoonIcon, ComputerDesktopIcon } from '@heroicons/vue/20/solid';

const systemDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
const option = ref(localStorage.getItem('option'));
const isDropdownOpen = ref(false);

const setOption = (selectedOption) => {
    localStorage.setItem('option', selectedOption);
    option.value = selectedOption
    isDropdownOpen.value = false;
}

const setTheme = () => {
    if (option.value === 'system') {
        window.matchMedia('(prefers-color-scheme: dark)').matches ? toggleDarkClass('dark') : toggleDarkClass('light')
    } else {
        option.value === 'dark' ? toggleDarkClass('dark') : toggleDarkClass('light')
    }
};

const toggleDarkClass = (className) => {
    if (className === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

watch(option, setTheme);

onMounted(() => {
    if (!option.value) {
        setOption('system')
    }

    setTheme();

    systemDarkMode.addListener((event) => {
        if (option.value === 'system') {
            if (event.matches) {
                toggleDarkClass('dark')
            } else {
                toggleDarkClass('light')
            }
        }
    });
});

</script>

<template>
    <div class="relative">
        <div @click="isDropdownOpen = !isDropdownOpen">
            <button type="button"
                class="flex px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                <SunIcon v-if="option === 'light'" class="h-5 w-5" aria-hidden="true" />
                <MoonIcon v-if="option === 'dark'" class="h-5 w-5" aria-hidden="true" />
                <ComputerDesktopIcon v-if="option === 'system'" class="h-5 w-5" aria-hidden="true" />
            </button>
        </div>

        <div v-show="isDropdownOpen" class="fixed inset-0 z-40" @click="isDropdownOpen = false"></div>

        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-show="isDropdownOpen"
                class="absolute z-50 mt-2 rounded-md shadow-lg ltr:origin-top-left rtl:origin-top-right start-0"
                style="display: none" @click="isDropdownOpen = false">
                <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-gray-800">
                    <button @click="setOption('light')"
                        class="flex hover:bg-gray-100 dark:hover:bg-gray-900 w-full text-left cursor-pointer py-2 px-3 focus:outline-none focus:ring rounded truncate whitespace-nowrap text-gray-500 active:text-gray-600 dark:text-white dark:hover:text-gray-400 dark:active:text-gray-600">
                        <SunIcon class="h-5 w-5" aria-hidden="true" />
                        <span class="ml-2">Light</span>
                    </button>

                    <button @click="setOption('dark')"
                        class="flex hover:bg-gray-100 dark:hover:bg-gray-900 w-full text-left cursor-pointer py-2 px-3 focus:outline-none focus:ring rounded truncate whitespace-nowrap text-gray-500 active:text-gray-600 dark:text-white dark:hover:text-gray-400 dark:active:text-gray-600">
                        <MoonIcon class="h-5 w-5" aria-hidden="true" />
                        <span class="ml-2">Dark</span>
                    </button>

                    <button @click="setOption('system')"
                        class="flex hover:bg-gray-100 dark:hover:bg-gray-900 w-full text-left cursor-pointer py-2 px-3 focus:outline-none focus:ring rounded truncate whitespace-nowrap text-gray-500 active:text-gray-600 dark:text-white dark:hover:text-gray-400 dark:active:text-gray-600">
                        <ComputerDesktopIcon class="h-5 w-5" aria-hidden="true" />
                        <span class="ml-2">System</span>
                    </button>
                </div>
            </div>
        </Transition>
    </div>
</template>