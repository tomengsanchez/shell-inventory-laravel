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
        <tr v-for="item in data" :key="item.id">
          <td class="text-center py-2 px-8">{{ item.id }}</td>
          <td v-if="!item.editing" class="text-center py-2 px-10">{{ item.name }}</td>
          <td v-if="item.editing" class="text-center py-2 px-10">
            <input v-model="item.name" />
          </td>
          <td>
            <div class="flex items-center justify-center">
              <button
                @click="item.editing ? saveItem(item) : editItem(item)"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
              >
                {{ item.editing ? 'Save' : 'Edit' }}
              </button>
              <button
                @click="deleteItem(item.id)"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full ml-2"
              >
                Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Define the props to use in your component
// Define the props using defineProps
const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  item_name: String
});


const form = useForm({
  id: '',
  name: ''
});

const data = ref([]); // Initialize data as a reactive reference

const fetchData = async () => {
  try {
    const response = await fetch('/item-types-table');
    if (response.ok) {
      data.value = await response.json(); // Parse JSON response and assign it to data
    } else {
      console.error('Failed to fetch data');
    }
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

const saveItem = (item) => {
  if (!item.name) {
    console.error('Name is required.');
    return;
  }

  form.put(`/item-types-table-update/${item.id}`, {
    preserveScroll: true,
    data: { name: item.name },
    onSuccess: () => {
      item.editing = false; // Exit editing mode
      fetchData(); // Refresh data
      console.log('Item updated successfully!');
    },
    onError: (error) => {
      console.error('Error saving item:', error);
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

const editItem = (item) => {
  item.editing = true; // Enable editing mode
};

onMounted(() => {
  fetchData(); // Fetch data when the component is mounted
});
</script>
