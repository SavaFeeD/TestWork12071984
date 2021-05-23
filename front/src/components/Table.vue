<template>
  <div class="table-wrap">
    <table class="table table-dark table-hover">
      <thead>
        <tr>
          <th v-for="col in Object.keys(data[0])" :key="col">{{col}}</th>
          <th>Events</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in data" :key="row.id">
          <td v-for="val in row" :key="val">{{val}}</td>
          <td class="d-flex">
            <button type="button" class="btn btn-danger" @click="() => {delete_(row.id)}">
              <i class="fas fa-trash"></i>
            </button>
            <button type="button" class="btn btn-warning ml-2" @click="() => {update_(row.id)}">
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

  props: {
    data: Array,
    table: String
  },

  computed: {
    ...mapState(['user', 'admin_edit'])
  },

  methods: {
    delete_(id) {
      let data = {
        table: this.table,
        id: id
      }

      this.$store.state.admin_edit = false;
      this.$store.dispatch('deleteRow', data);
      this.check();
    },
    update_(id) {
      let data = {
        table: this.table,
        id: id
      }

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
