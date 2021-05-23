<template>
  <div class="d-flex flex-column justify-content-center align-items-center">
    <h3 class="text-dark mb-5 mt-3">Registration</h3>
    <form class="form-group col-6" @submit.prevent="reg">
      <div class="mb-3 row">
        <label for="inputName" class="col-sm-4 col-form-label">Name:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="inputName" v-model="name" required>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputEmail" class="col-sm-4 col-form-label">Email:</label>
        <div class="col-sm-8">
          <input type="email" class="form-control" id="inputEmail" v-model="email" required>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-4 col-form-label">Password:</label>
        <div class="col-sm-8">
          <input type="password" class="form-control" id="inputPassword" v-model="password" required>
        </div>
      </div>
      <div class="mb-3 row">
        <label for="inputPasswordConfirm" class="col-sm-4 col-form-label">Password confirm:</label>
        <div class="col-sm-8">
          <input type="password" class="form-control" id="inputPasswordConfirm" v-model="password_confirm" required>
        </div>
      </div>
      <button type="submit" class="btn btn-block btn-primary mt-4">Sign up</button>
    </form>
  </div>

</template>

<script>

export default {
  name: 'Register',
  data: () => ({
    name: '',
    email: '',
    password: '',
    password_confirm: ''
  }),

  methods: {
    reg() {

      if (this.name.length < 4) {
        this.$store.dispatch('setAlert', 'Имя меньше 4 символов')
      } else if (this.password.length < 6) {
        this.$store.dispatch('setAlert', 'Пароль меньше 6 символов')
      } else if (this.password == this.password_confirm) {
        let data = {
          email: this.email,
          password: this.password,
          name: this.name
        }

        this.$store.dispatch('Register', data);
      } else {
        this.$store.dispatch('setAlert', 'Эхх..')
      }
    }
  }
}
</script>
