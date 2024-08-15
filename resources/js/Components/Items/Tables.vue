<template>
    <div class="container mx-auto p-4">

        <NavLink :href="route('add-item')"
            class="inline-flex items-center justify-center bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600">
            Add New Item
        </NavLink> <br><br>

        <div class="mb-4">
            <label for="items-per-page" class="mr-2">Items per page:</label>
            <select v-model="pageLimit" @change="fetchData" id="items-per-page" class="border py-2 px-6 rounded">
                <option value="2">2</option>
                <option value="5">5</option>
                <option value="10">10</option>
            </select>

            <input v-model="searchTerm" @keyup="fetchData" type="text" placeholder="Search..."
                class="border py-2 px-4 rounded float-right" />
        </div>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Item Name</th>
                    <th class="py-2 px-4 border-b">Item Type</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data" :key="item.id">
                    <td class="text-center py-2 px-8">{{ item.id }}</td>
                    <td class="text-center py-2 px-10">{{ item.item_name }}</td>
                    <td class="text-center py-2 px-8"> {{ item.item_type_name }}</td>

                    <td>
                        <div class="flex items-center justify-center">
                            <button @click="edit(item.id)">Edit 2</button>
                            <button @click="editItem(item)"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                                Edit
                            </button>

                            <button @click="deleteItem(item.id)"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full ml-2">
                                Delete
                            </button>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>
        <div class="mt-4 flex justify-between">
            <button @click="prevPage" :disabled="currentPage === 1"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                Previous
            </button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage === totalPages"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                Next
            </button>
        </div>
    </div>
</template>


<script setup>
import NavLink from '@/Components/NavLink.vue';
import { ref, onMounted, resolveComponent } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Define the props to use in your component
const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String
});

const edit=(item_id)=>{
    window.location.href=`/item/${item_id}/edit`;
}

const form = useForm({
    id: '',
    item_name: '',
    item_type_id: '',
    item_type_name: '',
});

const data = ref([]); // Initialize data as a reactive reference
var currentPage = 1;
var totalPages = 0;
var pageLimit = 7;
var searchTerm = ref('');

// Function to fetch data with pagination
const fetchData = async () => {

    try {
        const response = await fetch(`/item-table-data?page=${currentPage}&limit=${pageLimit}&search=${encodeURIComponent(searchTerm.value)}`);

        if (response.ok) {
            var jsonResponse = [];
            jsonResponse = await response.json();

            data.value = jsonResponse; // Parse JSON response and assign it to data
            currentPage = jsonResponse.current_page;
            totalPages = jsonResponse.last_page;
        } else {
            console.error('Failed to fetch data');
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};


// Functions to handle pagination
const nextPage = () => {
    // alert(1);
    if (currentPage < totalPages) {
        currentPage++;
        fetchData();
    }
};

const prevPage = () => {
    if (currentPage > 1) {
        currentPage--;
        fetchData();
    }
};

const editItem = (item) => {
    // Update form with current item values
    form.id = item.id;
    form.item_name = item.item_name;
    form.item_type_id = item.item_type_id;
    form.item_type_name = item.item_type_name;

    // Make a POST request to fetch the item details
    form.post('/item-edit', { // Adjust URL as necessary
        data: { id: item.id },
        preserveScroll: true,
        onSuccess: (data) => {
            // Optionally update the form fields with the fetched data
            form.item_name = data.item_name;
            form.item_type_id = data.item_type_id;
            form.item_type_name = data.item_type_name;
        },
        onError: () => {
            console.log('Error fetching item');
        }
    });
};

const deleteItem = (id) => {
    if (confirm('Are you sure you want to delete this item?')) {
        form.delete(`/item-table-delete/${id}`, {
            preserveScroll: true, // Optional: keeps the scroll position after the request
            onSuccess: () => {
                console.log('Item deleted successfully!');
                fetchData();
                // Remove the deleted item from local data
                data.value = data.value.filter(item => item.id !== id);
            },
            onError: (error) => {
                console.error('Error deleting item:', error);
            }
        });
    }
};
onMounted(() => {
    fetchData(); // Fetch data when the component is mounted
});
</script>