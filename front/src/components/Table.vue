<template>
  <div class="table-wrap">
    <table class="table table-dark table-hover">
      <thead>
        <tr>
          <span class="p-2 pl-4 d-flex">Create</span>
        </tr>
        <tr>
          <th v-for="col in Object.keys(data[0])" :key="col">{{col}}</th>
          <th>Create</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td v-for="(col, i) in Object.keys(data[0])" :key="i">
            <input v-if="col != 'id'" v-model="req_create[col]" type="text">
          </td>
          <td class="d-flex">
            <button type="button" class="btn btn-success" @click="() => {create()}">
              ADD
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <table class="table table-dark table-hover">
      <thead>
        <tr>
          <th v-for="col in Object.keys(data[0])" :key="col">{{col}}</th>
          <th>Events</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in data" :key="row.id">
            <td v-for="(val, i) in row" :key="i">
              <span v-if="row.id != update_id || i == 'id'">
                {{val}}
              </span>
              <input v-else v-model="req_update[i]" type="text">
            </td>
            <td class="d-flex">
              <button v-if="row.id != update_id" type="button" class="btn btn-danger" @click="() => {delete_(row.id)}">
                <i class="fas fa-trash"></i>
              </button>
              <button v-if="row.id != update_id" type="button" class="btn btn-warning ml-2" @click="() => {update_start(row)}">
                <i class="fas fa-edit"></i>
              </button>
              <button v-if="row.id == update_id" type="button" class="btn btn-success" @click="() => {update_end()}">
                <i class="fas fa-edit"></i>
              </button>
            </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'Table',

  data: () => ({
    update_id: undefined,
    req_update: {},
    req_create: {}
  }),

  props: {
    data: Array,
    table: String
  },

  computed: {
    ...mapState(['user', 'admin_edit'])
  },

  methods: {
    create() {
      let req = {}

      for (let key in this.req_create) {
        req[key] = this.req_create[key];
      }

      let data = {
        table: this.table,
        req
      }

      this.$store.dispatch('setAlert', 'Подождите');
      this.$store.state.admin_edit = false;
      this.$store.dispatch('createRow', data);
      this.check();
    },
    delete_(id) {
      let data = {
        table: this.table,
        id: id
      }

      this.$store.dispatch('setAlert', 'Подождите');
      this.$store.state.admin_edit = false;
      this.$store.dispatch('deleteRow', data);
      this.check();
    },
    update_start(row) {
      for (let key in row) {
        if (key != 'id') {
          this.req_update[key] = row[key];
        }
      }
      this.update_id = row.id;
    },
    update_end() {
      let data = {
        table: this.table,
        id: this.update_id,
        req: this.req_update
      }

      this.$store.dispatch('setAlert', 'Подождите');
      this.$store.state.admin_edit = false;
      this.$store.dispatch('updateRow', data);
      this.check();
    },

    check() {
      if (this.$store.state.admin_edit) {
        let data = {
          table: this.table,
          id: this.user.id
        }
        this.update_id = undefined;
        this.$store.dispatch('readTable', data);
      } else {
        setTimeout(() => {
          this.check()
        }, 100)
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.table-wrap{
  max-width: 1200px!important;
  overflow-y: auto!important;
}
td{
  max-width: 300px;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
