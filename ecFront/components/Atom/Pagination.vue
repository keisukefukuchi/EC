<template>
  <ul class="pagination">
    <li class="pagination__list--arrow" v-if="pageData.prev_page_url != null">
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(pageData.current_page - 1) }"
        >＜</nuxt-link
      >
    </li>
    <li class="pagination__list" v-if="pageData.current_page >= 3">
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(1) }"
        >1</nuxt-link
      >
    </li>
    <li class="pagination__list--space" v-if="pageData.current_page >= 4">
      <span class="pagination__text">…</span>
    </li>

    <li
      class="pagination__list"
      v-if="
        pageData.current_page == pageData.last_page && pageData.last_page >= 3
      "
    >
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(pageData.current_page - 2) }"
        >{{ pageData.current_page - 2 }}</nuxt-link
      >
    </li>
    <li class="pagination__list" v-if="pageData.current_page != 1">
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(pageData.current_page - 1) }"
        >{{ pageData.current_page - 1 }}</nuxt-link
      >
    </li>
    <li class="pagination__list--current">
      <span class="pagination__text">{{ pageData.current_page }}</span>
    </li>
    <li
      class="pagination__list"
      v-if="pageData.current_page != pageData.last_page"
    >
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(pageData.current_page + 1) }"
        >{{ pageData.current_page + 1 }}</nuxt-link
      >
    </li>
    <li
      class="pagination__list"
      v-if="pageData.current_page == 1 && pageData.last_page >= 3"
    >
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(pageData.current_page + 2) }"
        >{{ pageData.current_page + 2 }}</nuxt-link
      >
    </li>

    <li
      class="pagination__list--space"
      v-if="pageData.last_page - pageData.current_page >= 3"
    >
      <span class="pagination__text">…</span>
    </li>
    <li
      class="pagination__list"
      v-if="pageData.last_page - pageData.current_page >= 2"
    >
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(pageData.last_page) }"
        >{{ pageData.last_page }}</nuxt-link
      >
    </li>
    <li class="pagination__list--arrow" v-if="pageData.next_page_url != null">
      <nuxt-link
        class="pagination__text"
        :to="{ path: path, query: setQuery(pageData.current_page + 1) }"
        >＞</nuxt-link
      >
    </li>
  </ul>
</template>
<script>
export default {
  props: ["pageData"],
  data() {
    return {
      path: this.$route.path,
      query: this.$route.query,
    };
  },
  methods: {
    setQuery(page) {
      const query = JSON.parse(JSON.stringify(this.query));
      query.page = page;
      return query;
    },
  },
};
</script>
<style lang="scss" scoped>
.pagination {
  display: flex;
  justify-content: center;
  column-gap: 0.5rem;
  %list {
    width: 4rem;
    height: 4rem;
    border-radius: 0.3rem;
    color: white;
  }
  &__list {
    @extend %list;
    background-color: #8ac68f;
    font-size: 1.5rem;
    &--arrow {
      @extend %list;
      font-size: 2rem;
      font-weight: bold;
      background-color: #8ac68f;
    }
    &--current {
      @extend %list;
      background-color: #218060;
      font-size: 1.5rem;
    }
    &--space {
      @extend %list;
      background-color: #8ac68f;
      font-size: 2rem;
    }
  }
  &__text {
    display: block;
    width: 4rem;
    height: 4rem;
    line-height: 4rem;
    text-align: center;
  }
}
</style>
