<script setup lang="ts">
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';

import { User } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { FilterMatchMode } from 'primevue/api';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';

const toast = useToast();

const selectedUser = ref<User | undefined>(undefined);
const dt = ref();
const deleteUserDialog = ref(false);
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

const deleteUser = () => {
    window.axios.delete(route('users.destroy', {id: selectedUser.value?.id}))
    .then(() => {
        deleteUserDialog.value = false;
        selectedUser.value = undefined;
        toast.add({severity:'success', summary: 'Successful', detail: 'User deleted successfully', life: 3000});
        router.reload();
    })
    .catch((err) => {
        toast.add({severity:'error', summary: 'Error', detail: err, life: 3000});
    })
};

const confirmDeleteUser = () => {
    deleteUserDialog.value = true;
};

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
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <Toolbar class="mb-4">
                        <template #end>
                            <Button label="New" severity="success" class="mr-2" size="small" @click="router.get(route('users.create'))"/>
                            <Button label="Edit" severity="info" class="mr-2" size="small" :disabled="!selectedUser"/>
                            <Button label="Delete" severity="danger" size="small" @click="confirmDeleteUser" :disabled="!selectedUser" />
                        </template>
                    </Toolbar>
                    <DataTable v-if="users.length > 0" :value="users" ref="dt" dataKey="id" v-model:selection="selectedUser"
                        :paginator="true" :rows="10" :filters="filters"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[10,15,20]"
                        currentPageReportTemplate="Showing {first} of {totalRecords} products"
                >
                        <template #header>
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <h4 class="m-0">Manage Users</h4>
                                <span class="p-input-icon-left">
                                    <InputText v-model="filters['global'].value" placeholder="Search..." />
                                </span>
                            </div>
                        </template>
                        <Column selectionMode="single" style="width: 3rem" :exportable="false"></Column>
                        <Column field="id" header="id"></Column>
                        <Column field="name" header="Name"></Column>
                        <Column field="email" header="email"></Column>
                        <Column style="width: 10%; min-width: 8rem" bodyStyle="text-align:center">Editar</Column>
                    </DataTable>
                    <div v-else class="flex justify-center bg-white shadow-sm dark:bg-gray-800">
                        <p class="p-6 text-gray-900 dark:text-gray-100">No users found</p>
                    </div>
                </div>
            </div>
        </div>

        <Dialog v-model:visible="deleteUserDialog" :style="{width: '450px'}" header="Confirm" :modal="true">
            <div class="confirmation-content">
                <i class="mr-3" style="font-size: 2rem" />
                <span v-if="selectedUser">Are you sure you want to delete <b>{{selectedUser.name}}</b>?</span>
            </div>
            <template #footer>
                <Button label="No" text @click="deleteUserDialog = false"/>
                <Button label="Yes" text @click="deleteUser" />
            </template>
        </Dialog>

    </AuthenticatedLayout>
</template>
