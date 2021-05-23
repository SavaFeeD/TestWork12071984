<template>
  <div>
    <h4>Tables:</h4>
    <div class="d-flex align-items-center">
      <button type="button" class="btn btn-info" @click="() => {read('users')}">Users</button>
      <button type="button" class="btn btn-info ml-3" @click="() => {read('posts')}">Posts</button>
      <button type="button" class="btn btn-info ml-3" @click="() => {read('comments')}">Comments</button>
    </div>
    <div class="mt-5" v-if="table_data[0] != undefined">
      <Table :data="table_data" :table="table_name" />
    </div>
  </div>
</template>

<script>
import Table from '@/components/Table.vue'
import { mapState } from 'vuex'

export default {
  name: 'Admin',

  data: () => ({
    table_name: 'users'
  }),

  components: {
    Table
  },

  computed: {
    ...mapState(['user', 'table_data'])
  },

  created() {
    this.read('users')
  },

  methods: {
    read(table_name) {
      let data = {
        table: table_name,
        id: this.user.id
      }

      this.$store.dispatch('readTable', data);
      this.table_name = table_name;
    }
  }
}
</script>

<style scopeds>

</style>
