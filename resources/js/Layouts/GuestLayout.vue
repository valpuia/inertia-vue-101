<script setup>

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const user = computed(() => page.props.auth.user)

</script>

<template>
    <Head title="Welcome to My App" />

    <section class="bg-gray-200 p-4">
        <div class="max-w-7xl mx-auto flex justify-between">
            <Link href="/" class="font-bold text-2xl">My App</Link>

            <Link href="/login" v-if="user == null">Login</Link>
            <Link href="/dashboard" v-else>Dashboard</Link>
        </div>
    </section>

    <section class="mt-4 max-w-7xl mx-auto p-4 md:px-0">
        <slot />
    </section>
</template>