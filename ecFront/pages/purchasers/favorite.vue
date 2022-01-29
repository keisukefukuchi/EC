<template>
  <div class="favorite-list">
    <h1 class="favorite-list__title">
      お気に入り商品一覧<span v-if="itemList">({{ itemList.length }}件)</span>
    </h1>
    <div class="favorite-list__content">
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
  </div>
</template>

<script>
export default {
  layout: "purchasers",

  data() {
    return {
      itemList: null,
    };
  },

  methods: {
    async getItemList() {
      this.$axios
        .get("http://localhost:8000/api/favorite/items", {
          withCredentials: true,
          params: {
            purchaser_id: this.$store.state.loginUser.id,
          },
        })
        .then((response) => {
          this.itemList = response.data;
        });
    },
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
  },

  mounted() {
    this.getItemList();
  },
};
</script>

<style lang="scss" scoped>
.favorite-list {
  padding-top: 3rem;
  max-width: 1200px;
  margin: 0 auto;
  &__title {
    text-align: center;
    font-size: 2.7rem;
    font-weight: bold;
  }
  &__content {
    display: flex;
    width: 90%;
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
