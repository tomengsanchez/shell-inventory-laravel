

<template>
  <div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Data List</h1>
    <table class="min-w-full bg-white border border-gray-200">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">ID</th>
          <th class="py-2 px-4 border-b">Name</th>
          <th class="py-2 px-4 border-b">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data" :key="item.id">
          <td class="py-2 px-4 border-b">{{ item.id }}</td>
          <td class="py-2 px-4 border-b">{{ item.name }}</td>
          <td class="py-2 px-4 border-b">
            <button @click="updateData(item.id)" class="bg-blue-500 text-white py-1 px-2 rounded">Update</button>
            <button @click="deleteData(item.id)" class="bg-red-500 text-white py-1 px-2 rounded">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<!-- <script>
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
        const response = await fetch('/item-types'); // Fetch data from the Laravel route
        if (response.ok) {
          this.data = await response.json(); // Parse JSON response and assign it to `data`
        } else {
          console.error('Failed to fetch data'); // Handle fetch errors
        }
      } catch (error) {
        console.error('Error fetching data:', error); // Handle network errors
      }
    },
    async updateData(id) {
      // Add necessary form data here
      const formData = new URLSearchParams();
      formData.append('name', 'Updated Name'); // Example data

      try {
        const response = await fetch(`/item-types/${id}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: formData
        });

        if (response.ok) {
          this.fetchData(); // Refresh data after update
        } else {
          console.error('Failed to update data');
        }
      } catch (error) {
        console.error('Error updating data:', error);
      }
    },
    async deleteData(id) {
      try {
        const response = await fetch(`/item-types/${id}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        });

        if (response.ok) {
          this.fetchData(); // Refresh data after deletion
        } else {
          console.error('Failed to delete data');
        }
      } catch (error) {
        console.error('Error deleting data:', error);
      }
    }
  }
}
</script> -->
