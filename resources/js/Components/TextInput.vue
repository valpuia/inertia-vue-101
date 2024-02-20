<script setup>

const model = defineModel({
    type: String,
    required: true,
});

</script>

<template>
    <input v-model="model" class="w-full p-2 dark:bg-gray-600 rounded" ref="input">
</template>