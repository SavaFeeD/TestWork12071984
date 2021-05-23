<template>
  <div>
    <nav class="navbar navbar-dark bg-dark">
      <div class="container">
        <ul class="navbar-nav d-flex flex-row">
          <router-link :to="{ name: 'Home' }" class="navbar-brand mr-5" active="active">
            <i class="fas fa-crutch d-inline-block"></i>
            CRUD
          </router-link>

          <li class="nav-item">
            <router-link :to="{ name: 'Home' }" class="nav-link" active="active">Home</router-link>
          </li>
          <div v-if="user != {}">
            <li class="nav-item ml-4" v-if="user.role == 'admin'">
              <router-link :to="{ name: 'Admin' }" class="nav-link">Admin</router-link>
            </li>
          </div>
        </ul>
        <ul class="navbar-nav d-flex flex-row" v-if="user.id == undefined">
          <li class="nav-item">
            <router-link :to="{ name: 'Register' }" class="btn btn-outline-success">Sing Up</router-link>
          </li>
          <li class="nav-item ml-4">
            <router-link :to="{ name: 'Auth' }" class="btn btn-success">Sing In</router-link>
          </li>
        </ul>
        <ul class="navbar-nav d-flex flex-row" v-else>
          <div class="btn btn-outline-warning ml-3" @click="$store.dispatch('exit', {id: user.id})">
            <i class="fas fa-sign-out-alt"></i>
            {{ user.name }}
          </div>
        </ul>
      </div>
    </nav>

    <div class="container mt-5">
      <router-view/>
    </div>

    <div class="position-fixed p-3 w-25 mb-3 alert-general d-flex justify-content-between align-items-center" :class="{ 'error': _alert.type === 'error', 'message': _alert.type === 'message' }" v-if="_alert.flag"
      @click="setAlertFlag(false)">
        <div class="d-flex align-items-center ml-3">
          <i class="fas fa-bomb mr-2"></i>
          {{ _alert.message }}
        </div>
        <i class="far fa-window-close ml-3"></i>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'App',

  data: () => ({

  }),

  computed: {
    ...mapState(['user', '_alert'])
  },

  created() {
    this.$store.state.user = {};
    this.$store.dispatch('isAuth');
  },

  methods: {
    setAlertFlag(value) {
      this.$store.dispatch('setAlertFlag', value);
    },
  }
}
</script>


<style scoped>
.size-big{
  font-size: 20px;
}

.alert-general{
  background: #dcd8c0c2;
  cursor: pointer;
}
.position-fixed{
  position: fixed;
  bottom: 0;
}
</style>
