<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto mt-10 p-6 bg-white rounded shadow">
            <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Bank Information</th>
                        <th class="px-4 py-2">Amount ($)</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Donated At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="donation in donations.data" :key="donation.id" class="border-b">
                        <td class="px-4 py-2">{{ donation.id }}</td>
                        <td class="px-4 py-2">{{ donation.name }}</td>
                        <td class="px-4 py-2">{{ donation.bank_info }}</td>
                        <td class="px-4 py-2">{{ donation.amount.toFixed(2) }}</td>
                        <td class="px-4 py-2">{{ donation.description }}</td>
                        <td class="px-4 py-2">{{ formatDate(donation.created_at) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                <Pagination :links="donations.links" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>


<script>
import Pagination from '@/Components/Pagination.vue';

export default {
    props: {
        donations: Object,
    },
    components: {
        Pagination,
    },
    methods: {
        formatDate(date) {
            return new Date(date).toLocaleString();
        },
    },
};
</script>

<style scoped>
/* Optional: Add custom styles here */
</style>
