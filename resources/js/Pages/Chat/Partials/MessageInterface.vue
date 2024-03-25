
<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { User, Message } from '@/types';

const form = useForm({
    content: '',
    receiver_id: ''
});

defineProps({
    users: {
        type: Array,
        default: () => [],
    },
    messages: {
        type: Array,
        default: () => [],
    },
    selectUser: Function
});


// Define selectedUser as a ref
const selectedUser = ref<User | null>(null);

const submit = () => {
    form.post(route('private-chat.store'))
};
</script>


<template>
    <div class="ml-64">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-semibold mb-4">Messaging</h2>
                        <div v-if="selectedUser" class="mb-4">
                            <div class="flex items-center mb-2">
                                <div class="h-10 w-10 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                                <span class="ml-2 font-semibold">{{ selectedUser.name }}</span>
                            </div>
                            <div class="border border-gray-300 rounded-lg p-4 mb-4" style="max-height: 300px; overflow-y: auto;">
                                <div v-for="message in messages as Message[]" :key="message.id" class="mb-2">
                                    <div class="flex items-center mb-1">
                                        <span class="ml-2 font-semibold p-2">{{ message.name }}</span>
                                        <div class="h-6 w-6 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                                    </div>
                                    <div>{{ message.content }}</div>
                                </div>
                            </div>
                            <form @submit.prevent="submit">
                                <textarea id="content" v-model="form.content" rows="3" class="w-full border border-gray-300 text-black rounded-lg p-2 mb-2" placeholder="Type your message..."></textarea>
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Register
                                </PrimaryButton>
                            </form>
                        </div>
                        <div v-else>
                            <p>Select a user from the sidebar to start messaging.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
