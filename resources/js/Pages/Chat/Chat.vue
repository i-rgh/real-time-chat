<script setup lang="ts">
import {Ref, ref, UnwrapRef} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Message, User} from "@/types";
import UserList from "@/Pages/Chat/Partials/UserList.vue";



const me = usePage().props.auth.user;


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

// Define selectedUser
const selectedUser = ref<User | null>(null);


const form = useForm({
    content: '',
    receiver_id: ''
});

const submit = () => {
    form.post(route('private-chat.store'))
    if (selectedUser.value) {
        const newMessage = {
            sender_id: me.id,
            content: form.content
        };
        selectedUser.value.data.messages.push(newMessage);
    }
}

  function selectUser(user: User) {
    form.receiver_id = String(user.data.id);
    selectedUser.value = user;
  }



window.Echo.private(`MessageSend.${me.id}`)
    .listen('MessageSend', (event: any) => {
        console.log(event.message);
        selectedUser.value?.data.messages.push(event.message);

    });


</script>

<template>

    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Chat</h2>
        </template>Chat

        <!-- Sidebar -->
        <UserList :users="users as User[]" :selectUser="selectUser"> </UserList>

        <!-- Main Content -->
        <div class="ml-64">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h2 class="text-xl font-semibold mb-4">Messaging</h2>
                                <div v-if="selectedUser" class="mb-4">
                                    <div class="flex items-center mb-2">
                                        <div class="h-10 w-10 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                                        <span class="ml-2 bold">{{ selectedUser.data.name }}</span>
                                    </div>
                                    <div class="border border-gray-300 rounded-lg p-4 mb-4" style="max-height: 300px; overflow-y: auto;">
                                        <div v-for="message in selectedUser.data.messages" :key="message.id" class="mb-2">
                                            <div v-if="message.sender_id === me.id" class="message-right">
                                                <div class="flex items-center mb-1">
                                                    <span class="font-semibold p-2">{{ me.name }}</span>
                                                    <div class="h-6 w-6 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-600"></div>
                                                </div>
                                                <div class="content">{{ message.content }}</div>
                                            </div>
                                            <div v-else class="message-left" >
                                                <div class="flex items-center mb-1">
                                                    <span class="font-semibold p-2">{{ message.sender?.name }}</span>
                                                    <div class="h-6 w-6 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-red-600"></div>
                                                </div>
                                                <div class="content">{{ message.content }}</div>
                                            </div>
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


