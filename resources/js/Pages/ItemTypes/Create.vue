<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TableInput from '@/Components/ItemTypes/TableInput.vue';
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
        <div>
            <TableInput></TableInput>
        </div>
    </AuthenticatedLayout>
</template>
