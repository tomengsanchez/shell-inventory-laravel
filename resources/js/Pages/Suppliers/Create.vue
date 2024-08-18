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
                                <InputLabel for="supplier name" value="Name of Supplier" />
                                <TextInput id="supplier name" v-model="form.name" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.name" />

                                <br>

                                <InputLabel for="address" value="Supplier Address" />
                                <TextInput id="address" v-model="form.address" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.name" />

                                <br>

                                <InputLabel for="contact number" value="Contact Number" />
                                <TextInput id="contact number" v-model="form.contact_number" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.name" />

                                <br>

                                <InputLabel for="supplier type" value="Supplier Type" />
                                <select id="supplier type" v-model="form.supplier_type_id" class="mt-1 block w-full">
                                    <option v-for="item in data.data" :value="item.id" :key="item.id">
                                        {{ item.supplier_type_name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.supplier_type_id" />
                            </div>

                            <!-- Conditionally render InputLabel and TextInput for 'edit' -->
                            <div v-if="form_type === 'edit'">
                                <InputLabel for="name" value="Edit Supplier Name" />
                                <TextInput id="name" v-model="item_info.name" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.name" />

                                <br>

                                <InputLabel for="address" value="Edit Supplier Name" />
                                <TextInput id="address" v-model="item_info.address" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.address" />

                                <br>

                                <InputLabel for="contact number" value="Edit Supplier Name" />
                                <TextInput id="contact number" v-model="item_info.contact_number" type="text" class="mt-1 block w-full" autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.contact_number" />

                                <br>

                                <InputLabel for="supplier_type_id" value="Supplier Types" />
                                <select id="supplier_type_id" v-model="item_info.supplier_type_id" class="mt-1 block w-full">
                                    <option v-for="item in data.data" :value="item.id" :key="item.id">
                                        {{ item.supplier_type_name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.supplier_type_id" />
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
    name: '',
    address: '',
    contact_number: '',
    supplier_type_id: '',
});

const data = ref([]); // Initialize data as a reactive reference

const createItem = () => {
    form.post('add-supplier', {
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
        name: item.name,
        address: item.address,
        contact_number:item.contact_number,
        supplier_type_id: item.supplier_type_id,
    });

    console.log(updateForm);

    updateForm.put(`/supplier-update/${item.id}`, {
        onSuccess: () => {
            console.log('Item updated successfully!');
        },
        onError: (error) => {
            console.error('Error updating item:', error);
        }
    });
};

const fetchData = async () => {
    try {
        const response = await fetch('/dropdown-supplier-types');
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