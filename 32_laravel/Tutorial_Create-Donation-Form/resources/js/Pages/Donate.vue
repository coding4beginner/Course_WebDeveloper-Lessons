<template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded shadow">
                        <h1 class="text-2xl font-bold mb-6">Donate</h1>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700">Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="name" v-model="form.name"
                                    class="w-full px-3 py-2 border rounded" />
                                <span v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="bank_info" class="block text-gray-700">Bank Information <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="bank_info" v-model="form.bank_info"
                                    class="w-full px-3 py-2 border rounded" />
                                <span v-if="errors.bank_info" class="text-red-500 text-sm">{{ errors.bank_info }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="amount" class="block text-gray-700">Amount ($) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" id="amount" v-model="form.amount" step="0.01" min="0.01"
                                    class="w-full px-3 py-2 border rounded" />
                                <span v-if="errors.amount" class="text-red-500 text-sm">{{ errors.amount }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700">Description (Optional)</label>
                                <textarea id="description" v-model="form.description" rows="4"
                                    class="w-full px-3 py-2 border rounded"></textarea>
                                <span v-if="errors.description" class="text-red-500 text-sm">{{ errors.description
                                    }}</span>
                            </div>

                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Donate</button>
                        </form>

                        <div v-if="successMessage" class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ successMessage }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</template>


<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    props: {
        success: String,
    },
    setup(props) {
        const form = useForm({
            name: '',
            bank_info: '',
            amount: '',
            description: '',
        });

        const successMessage = ref(props.success);

        const submit = () => {
            form.post(route('donate.store'), {
                onSuccess: () => {
                    form.reset();
                    successMessage.value = 'Thank you for your donation!';
                },
                onError: () => {
                    successMessage.value = '';
                },
            });
        };

        return {
            form,
            submit,
            errors: form.errors,
            successMessage,
        };
    },
};
</script>

<style scoped>
/* Optional: Add custom styles here */
</style>
