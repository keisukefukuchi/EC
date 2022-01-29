<template>
  <div class="sellers">
    <div class="sellers__header">
      <SellersHeader />
    </div>
    <div class="sellers__main">
      <div class="sellers__sidebar">
        <SellersSideBar />
      </div>
      <div class="sellers__content">
        <Nuxt />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  middleware: "isSellerLoginCheck",
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
  &__header {
    height: 7rem;
    // position: sticky;
  }
  &__main {
    height: calc(100vh - 7rem);
    display: flex;
  }
  &__sidebar {
    width: 20rem;
  }
  &__content {
    width: calc(100% - 20rem);
    padding: 0 5rem;
    overflow-y: scroll;
  }
}
</style>
