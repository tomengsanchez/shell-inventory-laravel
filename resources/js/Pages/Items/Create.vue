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
  name1: String
});

var form = useForm({
    item_name: '',
    item_types: ''
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
const item_types = ref([]);
const fetchData = async () => {
    try {
        var jsonResponse = [];
        const response = await fetch('item-table'); // Replace with your API endpoint
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
var item_type=ref([]);
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Items </h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="addItem" class="mt-6 space-y-6">
                            <InputLabel for="item_name" value="Item Name"></InputLabel>
                            <TextInput id="item_name" ref="item_name" v-model="form.item_name" type="text"
                                class="mt-1 block w-full" autocomplete="off" />
                            <InputError class="mt-2" :message="form.errors.item_name" />


                            <InputLabel for="item_types" value="Item Types"></InputLabel>
                            <select v-model="form.item_types">
                                <option v-for="i in data.data" :value='i.name'>{{ i.name }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.item_types" />

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