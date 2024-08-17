<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ form_type === 'edit' ? 'Edit' : 'Add' }} Item
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="form_type === 'edit' ? updateItem(item_info) : createItem()" class="mt-6 space-y-6">
                            <!-- Conditionally render InputLabel and TextInput for 'create' -->
                            <div v-if="form_type === 'create'">
                                <InputLabel for="item_name" value="New Item Name" />
                                <TextInput id="item_name" v-model="form.item_name" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.item_name" />

                                <InputLabel for="item_type_id" value="Item Types" />
                                <select id="item_type_id" v-model="form.item_type_id" class="mt-1 block w-full">
                                    <option v-for="item in data.data" :value="item.id" :key="item.id">
                                        {{ item.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.item_type_id" />
                            </div>

                            <!-- Conditionally render InputLabel and TextInput for 'edit' -->
                            <div v-if="form_type === 'edit'">
                                <InputLabel for="item_name" value="Edit Item Name" />
                                <TextInput id="item_name" v-model="item_info.item_name" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.item_name" />

                                <InputLabel for="item_type_id" value="Item Types" />
                                <select id="item_type_id" v-model="item_info.item_type_id" class="mt-1 block w-full">
                                    <option v-for="item in data.data" :value="item.id" :key="item.id">
                                        {{ item.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.item_type_id" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">
                                    {{ form_type === 'edit' ? 'Update' : 'Create' }}
                                </PrimaryButton>

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



<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    form_type: String,
    item_info: Object
});

const form = useForm({
    item_name: '',
    item_type_id: '',
});

const data = ref([]); // Initialize data as a reactive reference

const createItem = () => {
    form.post('store-item', {
        preserveScroll: true,
        onSuccess: (data) => {
            console.log('Item created:', data);
        },
        onError: () => {
            console.log('Error creating item');
        }
    });
}

const updateItem = (item) => {
    const updateForm = useForm({
        item_name: item.item_name,
        item_type_id: item.item_type_id,
    });

    console.log(updateForm);

    updateForm.put(`/item-update/${item.id}`, {
        onSuccess: () => {
            console.log('Item updated successfully!');
            fetchData(); // Refresh data
        },
        onError: (error) => {
            console.error('Error updating item:', error);
        }
    });
};

const fetchData = async () => {
    try {
        const response = await fetch('/dropdown-item-types');
        const jsonResponse = await response.json();
        data.value = jsonResponse;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

// Fetch data when the component is mounted
onMounted(() => {
    fetchData();
});
</script>
