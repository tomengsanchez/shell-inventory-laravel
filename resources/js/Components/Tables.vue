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

<script>
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
        const response = await fetch('/item-types-table');
        if (response.ok) {
          this.data = await response.json(); // Parse JSON response and assign it to data
        } else {
          console.error('Failed to fetch data');
        }
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    getCSRFToken() {
      return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
    async saveItem(item) {
      try {''
        const response = await fetch('/item-types-table-update/${item.id}', {
          method: 'PUT', // Use PUT for update requests
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': this.getCSRFToken() // Include CSRF token in the request headers
          },
          body: JSON.stringify({ name: item.name }) // Send updated name in the request body
        });

        if (response.ok) {
          item.editing = false; // Exit editing mode
          this.fetchData(); // Refresh data
        } else {
          console.error('Failed to save item');
        }
      } catch (error) {
        console.error('Error saving item:', error);
      }
    },
    async deleteItem(id) {
      try {
        const response = await fetch('/item-types-table-delete/${id}', {
          method: 'DELETE', // Use DELETE for delete requests
          headers: {
            'X-CSRF-TOKEN': this.getCSRFToken() // Include CSRF token in the request headers
          }
        });

        if (response.ok) {
          this.data = this.data.filter(item => item.id !== id); // Remove deleted item from local data
        } else {
          console.error('Failed to delete item');
        }
      } catch (error) {
        console.error('Error deleting item:', error);
      }
    },
    editItem(item) {
      item.editing = true; // Enable editing mode
    }
  }
}
</script>