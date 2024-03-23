import {a} from "vite/dist/node/types.d-FdqQ54oU";

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    messages: Message[];
    data?: any | null;
    value: any;
    sender: User;

}

export interface Room {
    id: number;
    name: string;
    users: User[];
    messages: Message[];
    data: any;
}


export interface Message {
    id: number; // Assuming `id` is a unique identifier for each message
    name: string; // Assuming `name` is the name of the sender or some identifier
    content: string; // Assuming `content` is the actual message content
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
