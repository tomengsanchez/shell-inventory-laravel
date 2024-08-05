<!-- <template>
    <div class="container mx-auto p-4">
      <h1 class="text-xl font-bold mb-4">{{ isEditing ? 'Edit Item' : 'Create Item' }}</h1>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label class="block text-gray-700">Name</label>
          <input
            v-model="form.name"
            type="text"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            required
          />
        </div>
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
        >
          {{ isEditing ? 'Save' : 'Create' }}
        </button>
      </form>
    </div>
  </template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

// const route = useRoute(); // Access route parameters
// const router = useRouter(); // Navigate programmatically

const isEditing = ref(route.query.action === 'edit'); // Determine mode
const form = useForm({
    id: '',
    name: ''
});

const submitForm = () => {
    if (isEditing.value) {
        // Update item
        form.put(`/item-types-table-update/${form.id}`, {
            data: { name: form.name },
            onSuccess: () => {
                router.push({ name: 'data-list' }); // Redirect back to list
            },
            onError: (error) => {
                console.error('Error updating item:', error);
            }
        });
    } else {
        // Create new item
        form.post('/item-types-table-create', {
            data: { name: form.name },
            onSuccess: () => {
                router.push({ name: 'data-list' }); // Redirect back to list
            },
            onError: (error) => {
                console.error('Error creating item:', error);
            }
        });
    }
};

onMounted(() => {
    if (isEditing.value) {
        // Fetch item data if in edit mode
        fetch(`/item-types-table/${route.query.id}`)
            .then(response => response.json())
            .then(data => {
                form.name = data.name;
            });
    }
});
</script> -->