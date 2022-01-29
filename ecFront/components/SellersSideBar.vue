<template>
  <div class="sidebar">
    <nuxt-link class="sidebar__link" to="/sellers/home">HOME</nuxt-link>
    <nuxt-link class="sidebar__link" to="/sellers/item/all">商品一覧</nuxt-link>
    <nuxt-link class="sidebar__link" to="/sellers/item/register"
      >商品登録</nuxt-link
    >
  </div>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>
.sidebar {
  background-color: #dadbdd;
  height: 100%;
  &__link {
    display: block;
    font-size: 1.8rem;
    padding: 1.5rem 2rem;
    color: #5f5c5c;
  }
}
.nuxt-link-active {
  background-color: #faf6f6;
}
</style>
