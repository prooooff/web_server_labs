<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-center">
      <div class="w-full">
        <nav class="navbar bg-gray-100 p-4 rounded-lg mb-4 flex justify-between items-center shadow-sm">
          <span class="text-lg font-semibold text-gray-700">Керування статтями</span>
          <a href="/admin/blog/posts/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition-colors duration-200">
            Додати статтю
          </a>
        </nav>
        <div class="card bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
          <div class="card-body p-6">
            <table class="table-auto w-full text-left border-collapse">
              <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-sm">
                  <th class="p-3 font-semibold">#</th>
                  <th class="p-3 font-semibold">Автор</th>
                  <th class="p-3 font-semibold">Категорія</th>
                  <th class="p-3 font-semibold">Заголовок</th>
                  <th class="p-3 font-semibold">Дата публікації</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 text-gray-700">
                <tr v-for="post in posts" :key="post.id" class="hover:bg-gray-50 transition-colors">
                  <td class="p-3">{{ post.id }}</td>
                  <td class="p-3">{{ post.user?.name || 'Невказано' }}</td>
                  <td class="p-3">{{ post.category?.title || 'Невказано' }}</td>
                  <td class="p-3">
                    <a :href="'/admin/blog/posts/' + post.id + '/edit'" class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                      {{ post.title }}
                    </a>
                  </td>
                  <td class="p-3 text-sm text-gray-500">
                    {{ post.published_at ? new Date(post.published_at).toLocaleDateString() : 'Чернетка' }}
                  </td>
                </tr>
                <tr v-if="posts.length === 0">
                  <td colspan="5" class="p-4 text-center text-gray-400">Завантаження даних або список порожній...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Post {
  id: number
  title: string
  published_at: string | null
  user?: { name: string }
  category?: { title: string }
}

const posts = ref<Post[]>([])

const getPosts = () => {
  $fetch<{ data: Post[] }>('http://localhost/api/admin/blog/posts')
    .then(response => {
      posts.value = response.data
    })
    .catch(error => {
      console.error('Помилка завантаження статей:', error)
    })
}

getPosts()
</script>
