<template>
    <div class="flex justify-center mt-4">
        <ul class="flex items-center space-x-2">
            <li v-if="links.prev">
                <Link :href="links.prev.url" class="px-3 py-1 bg-blue-500 text-white rounded">Previous</Link>
            </li>
            <li v-for="link in links" :key="link.label">
                <Link
                    v-if="!link.url"
                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded cursor-default"
                >
                    {{ link.label }}
                </Link>
                <Link
                    v-else
                    :href="link.url"
                    :class="{'bg-blue-500 text-white rounded': link.active, 'px-3 py-1 bg-white text-blue-500 border border-gray-300 rounded': !link.active}"
                >
                    {{ link.label }}
                </Link>
            </li>
            <li v-if="links.next">
                <Link :href="links.next.url" class="px-3 py-1 bg-blue-500 text-white rounded">Next</Link>
            </li>
        </ul>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    props: {
        links: Array,
    },
    components: {
        Link,
    },
};
</script>

<style scoped>
/* Optional: Add custom styles here */
</style>
