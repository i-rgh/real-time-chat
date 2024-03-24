<script setup lang="ts">
import {Ref, ref, UnwrapRef} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Message, Room, User} from "@/types";
import UserList from "@/Pages/Chat/Partials/UserList.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import CreateRoom from "@/Pages/Room/Partials/CreateRoom.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import RoomList from "@/Pages/Room/Partials/RoomList.vue";



const me = usePage().props.auth.user;


defineProps({
    rooms: {
        type: Array,
        default: () => [],
    },
    messages: {
        type: Array,
        default: () => [],
    },
    selectRoom: Function
});

// Define selectedUser
const selectedRoom = ref<Room | null>(null);


const form = useForm({
    content: '',
    room_id: 0
});

const submit = () => {
    form.post(route('chat-room.message.store'))
}

function selectRoom(room: Room) {

    selectedRoom.value = room;
    console.log(selectedRoom.value.data.messages);
    form.room_id = room.data.id;

    console.log("Rooooms", selectedRoom.value.data.id)

    window.Echo.channel(`ChatRoom.${selectedRoom.value?.data.id}`)
        .listen('ChatRoomMessageSend', (event: any) => {
            selectedRoom.value.data.messages.push(event.message)
        });


}




</script>

<template>

    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Rooms</h2>
        </template>Rooms


        <div class="py-12 ml-64">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <CreateRoom

                        class="max-w-xl"
                    />
                </div>


            </div>
        </div>


        <!-- Sidebar -->
        <RoomList :rooms="rooms" :selectRoom="selectRoom"> </RoomList>

        <!-- Main Content -->
        <div class="ml-64">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="text-xl font-semibold mb-4">Messaging Of Room  </h2>
                            <div v-if="selectedRoom" class="mb-4">
                                <div class="flex items-center mb-2">
                                    <div class="h-10 w-10 rounded-full overflow-hidden bg-gradient-to-br from-pink-400 to-red-600"></div>
                                    <span class="ml-2 font-semibold">{{ selectedRoom.data.name }}</span>
                                </div>
                                <div class="border border-gray-300 rounded-lg p-4 mb-4" style="max-height: 300px; overflow-y: auto;">
                                    <div v-for="message in selectedRoom.data.messages" :key="message.id" class="mb-2">

                                            <div class="flex items-center mb-1">
                                                <span class="font-semibold p-2">{{ message.user?.name }}</span>
                                                <div class="h-6 w-6 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                                            </div>
                                            <div class="content">{{ message.content }}</div>


                                    </div>
                                </div>
                                <form @submit.prevent="submit">
                                    <textarea id="content" v-model="form.content" rows="3" class="w-full border border-gray-300 text-black rounded-lg p-2 mb-2" placeholder="Type your message..."></textarea>
                                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Send
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

    </AuthenticatedLayout>
</template>


