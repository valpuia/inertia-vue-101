<script setup>

const model = defineModel({
    type: String,
    required: true,
});

</script>

<template>
    <input v-model="model" class="border w-full p-2 rounded" ref="input">
</template>