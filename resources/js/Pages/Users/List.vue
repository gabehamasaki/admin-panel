<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

import { User } from '@/types';
import { Head } from '@inertiajs/vue3';
import Button from 'primevue/button';

defineProps<{
    users: User[];
}>();
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Users</h2>
                <Button label="New User" rounded />
            </div>
        </template>

        <div class="container m-auto">
            <DataTable v-if="users.length > 0" :value="users" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
                <Column field="id" header="id"></Column>
                <Column field="name" header="Name"></Column>
                <Column field="email" header="email"></Column>
            </DataTable>
            <div v-else class="flex justify-center">
                <p class="mt-4 text-2xl text-white">No users found</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
