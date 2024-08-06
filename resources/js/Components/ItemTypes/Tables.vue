<template>
  <div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Data List</h1>
    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">ID</th>
          <th class="py-2 px-4 border-b">Name</th>
          <th class="py-2 px-4 border-b">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data.data" :key="item.id">
          <td class="text-center py-2 px-8">{{ item.id }}</td>
          <td v-if="!item.editing" class="text-center py-2 px-10">{{ item.name }}</td>
          <td v-if="item.editing" class="text-center py-2 px-10">
            <input v-model="item.name" />
          </td>
          <td>
            <div class="flex items-center justify-center">
              <button @click="item.editing ? updateItem(item) : editItem(item)"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                {{ item.editing ? 'Update' : 'Edit' }}
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
      
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
        Next 1
      </button>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Dropdown from '../Dropdown.vue';

// Define the props to use in your component
const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String

  // 'data' => ItemTypeListResource::collection(ItemType::all()),
        //     'totalItems' => $itemTypes->total(),
        //     'currentPage' => $itemTypes->currentPage(),
        //     'totalPages' => $itemTypes->lastPage(),
});

const form = useForm({
  id: '',
  name: ''
});

const data = ref([]); // Initialize data as a reactive reference
var currentPage = 1;
var totalPages = 0;
var totalItems = ref(0);


// Function to fetch data with pagination
const fetchData = async () => {
  try {
    const response = await fetch(`/item-types-table?page=${currentPage}&limit=2`);
    
    if (response.ok) {
      var jsonResponse = [];
      jsonResponse = await response.json();
      
      data.value = jsonResponse; // Parse JSON response and assign it to data
      currentPage = jsonResponse.meta.current_page;
      console.log(currentPage);
      totalPages = jsonResponse.meta.last_page;
      // alert(currentPage);
      
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
  
  
  if (parseInt(currentPage) < parseInt(totalPages)) {
    currentPage= parseInt(currentPage) + 1;
    currentPage = parseInt(currentPage);
     fetchData();
  }

  
  
};

const prevPage = () => {
  if (currentPage > 1) {
    currentPage--;
    fetchData();
  }
};

// Function to handle the start of editing an item
const editItem = (item) => {
  item.editing = true;
};

const updateItem = (item) => {
  // Create a form instance using useForm
  const form = useForm({
    name: item.name,
  });

  // Send a PUT request to update the item
  form.put(`/item-types-table-update/${item.id}`, {
    onSuccess: () => {
      console.log('Item updated successfully!');
      // Exit editing mode
      item.editing = false;
    },
    onError: (error) => {
      console.error('Error updating item:', error);
    }
  });
};

const deleteItem = (id) => {
  if (confirm('Are you sure you want to delete this item?')) {
    form.delete(`/item-types-table-delete/${id}`, {
      preserveScroll: true, // Optional: keeps the scroll position after the request
      onSuccess: () => {
        console.log('Item deleted successfully!');
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
