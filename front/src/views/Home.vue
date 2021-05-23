<template>
  <div>
    <div class="d-flex w-100 justify-content-center">
      <div class="alert alert-warning p-4">
        <p>Что-бы зайти в админ панель (там находится CRUD система) нужно авторизироваталься как администратор:</p>
        <ul>
          <li>email: admin@mail.ru</li>
          <li>password: admin</li>
        </ul>
        после перейти в админ панель (Admin)
      </div>
    </div>
    <hr>
    <div class="d-flex w-100 flex-wrap">
      <Post v-for="post in posts" :key="post.title" :data="post"/>
    </div>
  </div>
</template>

<script>
import Post from '@/components/Post.vue'
import { mapState } from 'vuex'

export default {
  name: 'Home',

  data: () => ({

  }),

  computed: {
    ...mapState(['posts'])
  },

  components: {
    Post
  }
}
</script>
