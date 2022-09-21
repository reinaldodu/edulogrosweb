<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap mt-4 mb-4 ml-4">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded hover:bg-white"
                    v-html="link.label"
                />

                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                    :class="[ link.active ? 'bg-white' : 'bg-gray-100' ]"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<script setup>
//import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    links: Array,
});
</script>