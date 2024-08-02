<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Head } from '@inertiajs/vue3';


import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ItemTypesCreateForm from '@/Components/ItemTypes/ItemTypesCreateForm.vue';

defineProps({
    mustVerifyEmail: boolean,
    status: string,
    item_name: string
}),



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
},


export default {
  data() {
    return {
      data: [] // Initialize data as an empty array
    };
  },
  created() {
    this.fetchData(); // Fetch data when the component is created
  },
  methods: {
    async fetchData() {
      try {
        const response = await fetch('/item-types-table'); // Fetch data from the Laravel route
        if (response.ok) {
          this.data = await response.json(); // Parse JSON response and assign it to `data`
        } else {
          console.error('Failed to fetch data'); // Handle fetch errors
        }
      } catch (error) {
        console.error('Error fetching data:', error); // Handle network errors
      }
    }
  }
}
</script>






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
          <!-- <td class="py-2 px-4 border-b">{{ item.name }}</td> -->
          <td v-if="!item.editing" class="text-center py-2 px-10">{{ item.name }}</td>
          <td v-if="item.editing" class="text-center py-2 px-10"><input v-model="item.name" /></td>
          <!-- <td class="py-2 px-4 border-b">
            <button @click="updateData(item.id)" class="bg-blue-500 text-white py-1 px-2 rounded">Update</button>
            <button @click="deleteData(item.id)" class="bg-red-500 text-white py-1 px-2 rounded">Delete</button>
           -->

        <td>
          <div class="flex items-center justify-center">
              <button @click="item.editing ? saveItem(item) : editItem(item) " class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
              {{ item.editing ? 'Save' : 'Edit' }}
              </button>
            <button @click="deleteItem(item.id)"  class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Delete</button>
          </div>
        </td>
          <!-- </td> -->
        </tr>
      </tbody>
    </table>
  </div>
</template>



