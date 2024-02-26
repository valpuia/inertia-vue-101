<script setup>

import NavLink from '@/Components/NavLink.vue';

</script>

<template>
    <nav>
        <ul class="flex space-x-6">
            <li>
                <NavLink href="/dashboard" :active="route().current('dashboard')">{{ $t('Dashboard') }}</NavLink>
            </li>

            <li>
                <NavLink href="/users" :active="$page.component.startsWith('Users')">{{ $t('Users') }}</NavLink>
            </li>

            <li>
                <NavLink href="/posts" :active="$page.component.startsWith('Posts')">Posts</NavLink>
            </li>

            <li>
                <NavLink href="/contacts" :active="route().current('contacts.index')">{{ $t('Contacts') }}</NavLink>
            </li>
        </ul>
    </nav>
</template>