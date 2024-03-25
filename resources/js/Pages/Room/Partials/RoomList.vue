<script setup lang="ts">

import {usePage} from "@inertiajs/vue3";

const user = usePage().props.auth.user;
import {Room} from "@/types";

defineProps({
    rooms: {
        type: Array as () => Room[],
        required: true
    },
    selectRoom: {
        type: Function,
        default: null
    }
});
</script>

<template>
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white p-4">
        <h2 class="text-lg font-semibold mb-4">ًRooms</h2>
        <!-- List of Users -->
        <ul>
            <li v-for="room in rooms" :key="room.data.id" class="flex items-center space-x-2 cursor-pointer hover:bg-gray-700 p-2 rounded-lg" @click="selectRoom(room)">


                    <!-- Placeholder for profile picture -->
                    <div class="h-8 w-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                    <!-- User Name -->
                    <span>{{ room.data.name }}</span>


            </li>
        </ul>

    </div>
</template>

<style scoped>

</style>
