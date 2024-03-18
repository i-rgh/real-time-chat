<script setup lang="ts">
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const showingSidebar = ref(true); // Set to true by default to show the sidebar

// Static user data for demonstration
const user = usePage().props.auth.user;




defineProps({
    users: {
        type: Array,
        default: () => [],
    },
});

// Define selectedUser
const selectedUser = ref(null);

const form = useForm({
    content: '',
    receiver_id: ''
});

const submit = () => {
    form.post(route('private-message.create'))
}
// Function to select a user
function selectUser(user) {
    form.receiver_id = user.id
    selectedUser.value = user;
}

// Function to send a message
function sendMessage() {
    // Implement your logic to send the message here
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white p-4">
            <h2 class="text-lg font-semibold mb-4">Users</h2>
            <!-- List of Users -->
            <ul>
                <li v-for="user in users" :key="user.id" class="flex items-center space-x-2 cursor-pointer hover:bg-gray-700 p-2 rounded-lg" @click="selectUser(user)">
                    <!-- Placeholder for profile picture -->
                    <div class="h-8 w-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                    <!-- User Name -->
                    <span>{{ user.name }}</span>
                </li>
            </ul>

        </div>

        <!-- Main Content -->
        <div class="ml-64"> <!-- Adjust margin-left to accommodate the sidebar width -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <!-- Messaging Interface -->
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <!-- Header -->
                            <h2 class="text-xl font-semibold mb-4">Messaging</h2>
                            <!-- Selected User Card -->
                            <div v-if="selectedUser" class="mb-4">
                                <div class="flex items-center mb-2">
                                    <!-- Placeholder for profile picture -->
                                    <div class="h-10 w-10 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                                    <!-- User Name -->
                                    <span class="ml-2 font-semibold">{{ selectedUser.name }}</span>
                                </div>
                                <!-- Message Display Area -->
                                <div class="border border-gray-300 rounded-lg p-4 mb-4" style="max-height: 300px; overflow-y: auto;">
                                    <!-- Displaying messages -->
                                    <div v-for="message in selectedUser.receiver" :key="message.id" class="mb-2">
                                        <!-- Sender's information -->
                                        <div class="flex items-center mb-1">
                                            <!-- Placeholder for profile picture -->
                                            <div class="h-6 w-6 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                                            <!-- Sender's name -->
                                            <span class="ml-2 font-semibold">{{ message.sender }}</span>
                                        </div>
                                        <!-- Message content -->
                                        <div>{{ message.content }}</div>
                                    </div>
                                </div>

                                <!-- Message Input -->
                                <form @submit.prevent="submit">
                                    <textarea id="content" v-model="form.content" rows="3" class="w-full border border-gray-300 text-black rounded-lg p-2 mb-2" placeholder="Type your message..."></textarea>
                                    <!-- Send Button -->
                                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Register
                                    </PrimaryButton>
                                </form>

                            </div>
                            <!-- If no user is selected, show a message -->
                            <div v-else>
                                <p>Select a user from the sidebar to start messaging.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
