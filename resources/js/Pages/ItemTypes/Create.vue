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
    item_name?: string;
}>()



const form = useForm({
    item_name: ''
});

const addItem = () => {
    form.post('add-item-types', {
        preserveScroll: true,
        onSuccess: (data) => {

            console.log(data);
        },
        onError: () => {
            console.log(222);
        }
    });
}
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
                        <form @submit.prevent="addItem" class="mt-6 space-y-6">
                            <InputLabel for="item_name" value="Item name"></InputLabel>
                            <TextInput id="current_password" ref="currentPasswordInput" v-model="form.item_name" type="text"
                                class="mt-1 block w-full" autocomplete="current-password" />
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
