<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head } from '@inertiajs/vue3';


import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ItemTypesCreateForm from '@/Components/ItemTypes/ItemTypesCreateForm.vue';



defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
    item_name?:string;
}>()






</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Item Types </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ItemTypesCreateForm :item_name="item_name"></ItemTypesCreateForm>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
