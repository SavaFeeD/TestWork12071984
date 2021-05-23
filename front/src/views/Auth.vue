<template>
  <div class="d-flex flex-column justify-content-center align-items-center">
    <h3 class="text-dark mb-5 mt-3">Authorization</h3>
    <form class="form-group col-5" @submit.prevent="auth">
      <div class="mb-3 row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="inputEmail" v-model="email" required>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPassword" v-model="password" required>
        </div>
      </div>
      <button type="submit" class="btn btn-block btn-primary mt-4">Sign in</button>
    </form>
  </div>

</template>

<script>

export default {
  name: 'Auth',

  data: () => ({
    email: '',
    password: ''
  }),

  methods: {
    auth() {
      let data = {
        email: this.email,
        password: this.password
      }

      this.$store.dispatch('Login', data);
    }
  }
}
</script>
