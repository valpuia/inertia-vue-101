<script setup>

defineProps({
    prevUrl: { String, required: true },
    nextUrl: { String, required: true },
    from: { Number, required: true },
    to: { Number, required: true },
    total: { Number, required: true }
})

</script>

<template>
    <div class="bg-gray-50 dark:bg-gray-950 flex flex-col xs:flex-row items-center xs:justify-between          ">
        <span class="text-xs xs:text-sm text-gray-900 dark:text-gray-200">
            Showing {{ from }} to {{ to }} of {{ total }} Entries
        </span>
        <div class="inline-flex mt-2 xs:mt-0">
            <Component :is="prevUrl ? 'Link' : 'span'" :href="prevUrl" preserve-scroll
                class="text-sm bg-gray-300 font-semibold py-2 px-4 rounded-l"
                :class="prevUrl ? 'hover:bg-gray-400 text-gray-800' : 'text-gray-600 cursor-not-allowed'">
                Prev
            </Component>
            <Component :is="nextUrl ? 'Link' : 'span'" :href="nextUrl" preserve-scroll
                class="text-sm bg-gray-300 font-semibold py-2 px-4 rounded-r"
                :class="nextUrl ? 'hover:bg-gray-400 text-gray-800' : 'text-gray-600 cursor-not-allowed'">
                Next
            </Component>
        </div>
    </div>
</template>