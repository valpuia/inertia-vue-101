<script setup>

import { useForm } from 'laravel-precognition-vue-inertia';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Textarea from '@/Components/Textarea.vue';
import BackButton from '@/Components/BackButton.vue';

const form = useForm('post', route('posts.store'), {
    title: '',
    content: '',
    publish: false,
});

const submit = () => form.submit();

</script>

<template>
    <Head :title="$t('New Post')" />

    <h1 class="font-bold">{{ $t('New Post') }}</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto pt-8">
        <div class="mb-6">
            <InputLabel class="required" for="title">{{ $t('title') }}</InputLabel>
            <TextInput required type="text" v-model="form.title" id="title" @change="form.validate('title')" />
            <InputError class="mt-1" :message="form.errors.title" />
        </div>

        <div class="mb-6">
            <InputLabel class="required" for="content">{{ $t('content') }}</InputLabel>
            <Textarea required name="content" id="content" rows="5" v-model="form.content"
                @change="form.validate('content')" />
            <InputError class="mt-1" :message="form.errors.content" />
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <Checkbox name="publish" v-model:checked="form.publish" />
                <span class="ms-2">{{ $t('publish') }}</span>
            </label>
        </div>

        <PrimaryButton type="submit" :disabled="form.processing">
            {{ $t('Submit') }}
        </PrimaryButton>

        <BackButton :href="route('posts.index')" class="ml-2">{{ $t('Back') }}</BackButton>
    </form>
</template>