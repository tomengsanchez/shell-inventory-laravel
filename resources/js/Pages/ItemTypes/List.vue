<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ItemTypesTable from '@/Components/ItemTypes/ItemTypesTable.vue';
import { Head } from '@inertiajs/vue3';

var user = '';
defineProps <{
    name1?:string
}>()
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Item Types</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>

                    <br>this is the components <br>

                    <ItemTypesTable :name="name1"></ItemTypesTable>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
