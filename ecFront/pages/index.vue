<template>
  <div class="home">
    <div class="home__first-view"></div>
    <h2 class="home__sub-title">最新商品</h2>
    <div class="home__content">
      <div class="latest-item-box">
        <nuxtLink
          :to="`purchasers/itemDetail/${item.id}`"
          class="latest-item"
          v-for="item in latestItems"
          :key="item.id"
        >
          <img
            class="latest-item__image"
            :src="`http://localhost:8000${item.item_image[0].image_path}`"
            alt="商品画像"
          />
          <p class="latest-item__name">{{ item.name }}</p>
          <p class="latest-item__price">¥{{ item.price.toLocaleString() }}</p>
        </nuxtLink>
      </div>
    </div>
    <nuxt-link class="home__button" to="/purchasers/itemList"
      >もっと見る</nuxt-link
    >
    <h2 class="home__sub-title">カテゴリ</h2>
    <div class="home__content">
      <div class="category-box">
        <nuxt-link
          v-for="category in categories"
          :key="category.id"
          class="category"
          :to="`/purchasers/itemList?filter=category&category=${category.id}`"
          ><p class="category__name">{{ category.name }}</p></nuxt-link
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "purchasers",
  data() {
    return {
      latestItems: [],
      categories: [
        { id: 1, name: "筆記用具" },
        { id: 2, name: "画材用品" },
        { id: 3, name: "紙製品" },
        { id: 4, name: "整理用品" },
        { id: 5, name: "机上用品" },
        { id: 6, name: "事務用品" },
        { id: 7, name: "製図用品" },
        { id: 8, name: "その他" },
      ],
    };
  },
  methods: {
    async getLatestItems() {
      await this.$axios
        .get("http://localhost:8000/api/top/item/", {
          withCredentials: true,
        })
        .then((res) => {
          this.latestItems = res.data;
        });
    },
  },
  mounted() {
    this.getLatestItems();
  },
};
</script>

<style lang="scss" scoped>
.home {
  text-align: center;
  &__first-view {
    width: 90%;
    margin: 0 auto;
    height: 60vh;
    background-image: url(~/assets/img/first-view.jpg);
    background-size: cover;
  }
  &__sub-title {
    font-size: 1.8rem;
    text-align: center;
    font-weight: bold;
    margin: 2rem 0;
  }
  &__content {
    width: 80%;
    margin: 0 auto;
  }
  &__button {
    display: inline-block;
    margin: 0 auto;
    border: 0.1rem solid black;
    border-radius: 0.5rem;
    padding: 0.4rem 1.7rem;
    margin: 2rem 0;
    &:hover {
      cursor: pointer;
    }
  }
}
.latest-item-box {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  row-gap: 2rem;
}
.latest-item {
  width: 23%;
  text-align: left;
  &__image {
    width: 100%;
  }
  &__name {
    font-size: 1.2rem;
    margin: 0.4rem 0 0 0.4rem;
  }
  &__price {
    font-weight: bold;
    margin: 0.4rem 0 0 0.4rem;
  }
}
.category-box {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  row-gap: 1rem;
}
.category {
  width: 24%;
  padding-top: 24%;
  position: relative;
  background-image: url("~@/assets/img/first-view.jpg");
  background-size: cover;
  background-position: center;
  box-shadow: 0 0 0.4rem 0 black;
  &__name {
    position: absolute;
    z-index: 1;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.7vw;
    width: 100%;
    text-align: center;
    font-weight: bold;
    color: white;
  }
  &::before {
    content: "";
    position: absolute;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
    background: inherit;
    filter: blur(3px);
  }
}
</style>
