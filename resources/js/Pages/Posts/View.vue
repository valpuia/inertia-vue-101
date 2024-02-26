<script setup>

import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Textarea from '@/Components/Textarea.vue';
import BackButton from '@/Components/BackButton.vue';

const props = defineProps({
    post: Object,
})

</script>

<template>
    <Head :title="$t('View Post')" />

    <h1 class="font-bold">{{ $t('View Post') }}</h1>

    <form class="max-w-md mx-auto pt-8">
        <div class="mb-6">
            <InputLabel for="title">{{ $t('title') }}</InputLabel>
            <TextInput type="text" v-model="post.title" id="title" disabled />
        </div>

        <div class="mb-6">
            <InputLabel for="content">{{ $t('content') }}</InputLabel>
            <Textarea id="content" rows="5" v-model="post.content" disabled />
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <Checkbox name="publish" v-model:checked="post.publish" disabled />
                <span class="ms-2">{{ $t('publish') }}</span>
            </label>
        </div>

        <BackButton :href="route('posts.index')">{{ $t('Back') }}</BackButton>
    </form>
</template>