<script setup>

const model = defineModel({
    type: String,
    required: true,
});

</script>

<template>
    <textarea v-model="model" class="w-full p-2 dark:bg-gray-600 rounded-lg" ref="input"></textarea>
</template>