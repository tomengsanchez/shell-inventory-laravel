<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted, watch } from 'vue';
import ItemTypesCreateForm from '@/Components/ItemTypes/ItemTypesCreateForm.vue';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    id: Number,
    item_name: String,
    item_type_id: String,
    item_type_name: String,
    form_type: String,
    item_info:Object
});

console.log(props.item_info);

var form = useForm({
    item_name: '',
    item_type_id: '',
});

const data = ref([]); // Initialize data as a reactive reference


const addItem = () => {
    form.post('store-item', {
        preserveScroll: true,
        onSuccess: (data) => {
            console.log(data);
        },
        onError: () => {
            console.log(222);
        }
    });
}

const fetchData = async () => {
    try {
        var jsonResponse = [];
        const response = await fetch('/dropdown-item-types');
        jsonResponse = await response.json();
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
                        <form @submit.prevent="addItem" class="mt-6 space-y-6">
                            <!-- Conditionally render InputLabel and TextInput for 'create' -->
                            <div v-if="form_type === 'create'">
                                <InputLabel for="item_name" value="New Item Name" />
                                <TextInput id="item_name" v-model="form.item_name" type="text" class="mt-1 block w-full"
                                    autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.item_name" />

                                <InputLabel for="item_type_id" value="Item Types" />
                                <select id="item_type_id" v-model="form.item_type_id" class="mt-1 block w-full">
                                    <option v-for="i in data.data" :value="i.id" :key="i.id">
                                        {{ i.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.item_type_id" />
                            </div>

                            <!-- Conditionally render InputLabel and TextInput for 'edit' -->
                            <div v-if="form_type === 'edit'">

                                <InputLabel for="item_name" value="Edit Item Name" />
                                <TextInput id="item_name" v-model="form.item_name" type="text" class="mt-1 block w-full" :value="item_info.item_name"
                                autocomplete="off" />
                                <InputError class="mt-2" :message="form.errors.item_name" />

                                <InputLabel for="item_type_id" value="Item Types" />
                                <select id="item_type_id" class="mt-1 block w-full" >
                                    <option v-for="item in data.data" :value="item.id" :selected="item.id == item_info.item_type_id">
                                        {{ item.name }}
                                    </option>
                                    <!-- <option :selected="'item_type_id' === 'item.id'"> {{ item_name }} </option> -->
                                </select>
                                <InputError class="mt-2" :message="form.errors.item_type_id" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>
                    <div class="item-info">
                            <h2>Item Information</h2>
                            <p><strong>Item Id:</strong> {{ item_info.id }}</p>
                            <p><strong>Item Name:</strong> {{ item_info.item_name }}</p>
                            <p><strong>Item Type ID:</strong> {{ item_type_name }}</p>
                        </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
