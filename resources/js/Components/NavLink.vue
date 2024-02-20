<script setup>

defineProps({
    active: Boolean,
});

</script>

<template>
    <Link class="text-black dark:text-gray-300 hover:underline" :class="{ 'font-bold underline': active }">
    <slot />
    </Link>
</template>
