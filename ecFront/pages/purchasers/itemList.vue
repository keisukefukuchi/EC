<template>
  <div class="product-list">
    <div class="product-list__first-view"></div>
    <h1 class="product-list__title">
      商品一覧<span v-if="itemList">({{ pagination.total }}件)</span>
    </h1>
    <div class="product-list__content">
      <div
        class="item"
        v-for="item in itemList"
        :key="item.id"
        @click="$router.push('/purchasers/itemDetail/' + item.id)"
      >
        <div
          class="item__img"
          :style="itemImg(item.item_image[0].image_path)"
        ></div>
        <p class="item__title">{{ item.name }}</p>
        <p class="item__price">¥{{ item.price.toLocaleString() }}</p>
      </div>
    </div>
    <AtomPagination
      v-if="pagination != null"
      :page-data="pagination"
      @pageUpdate="getItemList"
    ></AtomPagination>
  </div>
</template>

<script>
export default {
  layout: "purchasers",

  data() {
    return {
      itemList: null,
      pagination: null,
    };
  },
  methods: {
    setUrl() {
      let url;
      switch (this.$route.query.filter) {
        case "category":
          url = `http://localhost:8000/api/item/category/${this.$route.query.category}?page=${this.$route.query.page}`;
          break;
        default:
          url = `http://localhost:8000/api/item_public?page=${this.$route.query.page}`;
      }
      this.getItemList(url);
    },
    async getItemList(url) {
      await this.$axios
        .get(url, {
          withCredentials: true,
        })
        .then((response) => {
          this.pagination = response.data;
          this.itemList = response.data.data;
        });
    },
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
  },

  async mounted() {
    await this.setUrl();
  },
};
</script>

<style lang="scss" scoped>
.product-list {
  width: 90%;
  max-width: 1400px;
  margin: 0 auto;
  &__first-view {
    margin: 0 auto;
    height: 60vh;
    background-image: url(~/assets/img/first-view.jpg);
    background-size: cover;
  }
  &__title {
    text-align: center;
    padding: 3rem 0;
    font-size: 2.7rem;
    font-weight: bold;
  }
  &__content {
    display: flex;
    margin: 0 auto 3vh;
    flex-wrap: wrap;
  }
}
.item {
  width: 25%;
  padding: 3rem 2rem 1.6rem;
  border-bottom: 1px solid #c4c4c4;
  &:hover {
    cursor: pointer;
  }
  &__img {
    padding-top: 100%;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__title {
    font-size: 1.5rem;
    margin-top: 1.1rem;
  }
  &__price {
    margin-top: 0.7rem;
    font-size: 1.5rem;
    color: red;
    font-weight: bold;
  }
}
</style>
