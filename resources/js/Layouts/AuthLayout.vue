<script setup>

import Nav from '../Shared/Nav.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const user = computed(() => page.props.auth.user)

</script>

<template>
    <Head>
        <title>Welcome to My App</title>
        <meta name="description" content="This is default meta" head-key="description">
    </Head>

    <section class="bg-gray-200 p-6">
        <div class="max-w-7xl mx-auto flex justify-between">
            <div class="flex items-center">
                <Link href="/" class="font-bold text-2xl">My App</Link>

                <p class="text-sm ml-4">Welcome back {{ user.name }}!</p>
            </div>

            <Nav />

        </div>
    </section>

    <section class="mt-4 max-w-7xl mx-auto p-6">
        <slot />
    </section>
</template>