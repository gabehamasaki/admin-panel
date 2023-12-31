<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputText from 'primevue/inputtext';
import { Head, router, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import { useToast } from "primevue/usetoast";
import { User } from '@/types';
const toast = useToast();

const { user } =  defineProps<{
    user: User
}>();

const form = useForm({
    name: user.name,
    email: user.email,
    password: '',
});

function submit() {
    form.patch(route('users.update', user.id), {
        onSuccess: () => {
            toast.add({ severity: "success", summary: "Success", detail: "User successfully updated!", life: 3000});
        },
        onError: (error) => {
            if (error.name) {
                toast.add({ severity: "warn", summary: "Warn", detail: error.name, life: 3000});
            }
            if (error.email) {
                toast.add({ severity: "warn", summary: "Warn", detail: error.email, life: 3000});
            }
            if (error.password) {
                toast.add({ severity: "warn", summary: "Warn", detail: error.password, life: 3000});
            }
        }
    });
}

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Edit User</h2>
                <Button label="Back" class="mr-2" size="small" @click="router.get(route('users.index'))"/>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-8 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <form @submit.prevent="submit()" class="flex flex-wrap items-center justify-between gap-3 mt-6">
                        <div class="w-[45%]">
                            <InputLabel for="name" value="Name" />
                            <InputText
                                id="name"
                                type="text"
                                class="block w-full mt-1"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="w-[45%]">
                            <InputLabel for="email" value="Email" />
                            <InputText
                                id="email"
                                type="email"
                                class="block w-full mt-1"
                                v-model="form.email"
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="w-[45%]">
                            <InputLabel for="password" value="Password" />
                            <InputText
                                id="password"
                                type="password"
                                class="block w-full mt-1"
                                v-model="form.password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="w-full mt-4">
                            <Button class="w-full" type="submit" label="Update" :disabled="form.processing"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
