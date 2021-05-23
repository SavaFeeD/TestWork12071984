<template>
  <div class="card" style="width: 18rem;">
    <img v-if="data.img" src="../assets/logo.png" alt="no-image">
    <img :src="data.img" class="card-img-top" :alt="data.img">
    <div class="card-body">
      <h5 class="card-title">{{ data.title }}</h5>
      <p class="card-text">{{ data.description }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'post',
  props: {
    data: Object
  }
}
</script>

<style scoped>

</style>
