<template>
  <div class="sellers">
    <div class="sellers__header">
      <SellersHeader />
    </div>

    <div class="sellers__content">
      <Nuxt />
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.$store.dispatch("updateLoginSellerUser");
  },
};
</script>

<style lang="scss" scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.sellers {
  background-color: #edeef3;
  min-height: 100vh;
  padding-bottom: 3.5rem;
  &__header {
    height: 7rem;
    margin-bottom: 5vh;
  }
  &__content {
    width: 90%;
    background-color: white;
    margin: 0 auto;
  }
}
</style>
