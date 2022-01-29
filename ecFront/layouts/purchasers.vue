<template>
  <div class="purchasers">
    <div class="purchasers__header">
      <PurchaserHeader />
    </div>
    <div class="purchasers__content">
      <Nuxt :nuxt-child-key="$route.fullPath" />
    </div>
    <div class="purchasers__footer">
      <Footer />
    </div>
  </div>
</template>

<script>
export default {
  middleware: "isPurchaserLoginCheck",
};
</script>

<style lang="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.purchasers {
  background-color: #f5f0ed;
  padding-top: 1rem;
  &__header {
    width: 95%;
    margin: 0 auto 2.7rem;
  }
  &__content {
    width: 95%;
    background-color: white;
    margin: 0 auto;
    padding-bottom: 3rem;
  }
}
</style>
