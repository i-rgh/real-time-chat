<script setup lang="ts">
import {User} from "@/types";

defineProps({
    users: {
        type: Array as () => User[],
        required: true
    },
    selectUser: Function
});
</script>

<template>
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white p-4">
        <h2 class="text-lg font-semibold mb-4">Users</h2>
        <!-- List of Users -->
        <ul>
            <li v-for="user in users" :key="user.data.id" class="flex items-center space-x-2 cursor-pointer hover:bg-gray-700 p-2 rounded-lg" @click="selectUser(user)">
                <!-- Placeholder for profile picture -->
                <div class="h-8 w-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                <!-- User Name -->
                <span>{{ user.data.name }}</span>
            </li>
        </ul>

    </div>
</template>

<style scoped>

</style>
