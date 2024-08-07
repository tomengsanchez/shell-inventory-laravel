<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateorEdit from '@/Components/ItemTypes/CreateorEdit.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';



defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
    item_name?: string;
}>()



const form = useForm({
    name: ''
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
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Item Types </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="addItem" class="mt-6 space-y-6">
                    <label for="name">Input new item type</label>
                    <input id="name" ref="name" v-model="form.name" type="text" class="mt-1 block w-full" autocomplete="off" />
                    <span v-if="form.errors.name" class="mt-2">{{ form.errors.name }}</span>
                    <div class="flex items-center gap-4">
                        <button :disabled="form.processing">Save</button>
                        <transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                        </transition>
                    </div>
                </form>
            </div>
            <!-- <CreateorEdit></CreateorEdit> -->
        </div>
    </AuthenticatedLayout>
</template>
