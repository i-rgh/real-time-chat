<script setup lang="ts">
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const showingSidebar = ref(true); // Set to true by default to show the sidebar

// Static user data for demonstration
const users = ref([
    { id: 1, name: 'User 1' },
    { id: 2, name: 'User 2' },
    // Add more users as needed
]);

// Define selectedUser and messageInput
const selectedUser = ref(null);
const messageInput = ref('');

// Function to select a user
function selectUser(user) {
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
            <!-- Add a close icon -->
            <button @click="showingSidebar = false" class="mt-4 focus:outline-none">
                <svg class="w-6 h-6 text-gray-300 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
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
                                    <!-- Messages will be displayed here -->
                                </div>
                                <!-- Message Input -->
                                <textarea v-model="messageInput" rows="3" class="w-full border border-gray-300 text-black rounded-lg p-2 mb-2" placeholder="Type your message..."></textarea>
                                <!-- Send Button -->
                                <button @click="sendMessage" class="bg-blue-500 text-black px-4 py-2 rounded-lg hover:bg-blue-600">Send</button>
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
