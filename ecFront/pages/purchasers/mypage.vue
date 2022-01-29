<template>
  <div class="my-page" v-if="$store.state.isLogin">
    <h1 class="my-page__title">マイページ</h1>
    <div class="my-page__top">
      <div
        class="my-page__img"
        :style="itemImg($store.state.loginUser.image_path)"
      ></div>
      <p class="my-page__name">{{ $store.state.loginUser.name }} 様</p>
    </div>
    <div class="my-page__contents">
      <nuxt-link
        v-for="(link, index) in links"
        class="links"
        :to="link.path"
        :key="index"
        @click.native="index == 5 ? logout() : null"
      >
        <div
          class="links__img"
          :style="{ backgroundImage: linkImg(link.img) }"
        ></div>
        <p class="links__name">{{ link.name }}</p>
      </nuxt-link>
    </div>
  </div>
  <p v-else>ログインして</p>
</template>

<script>
export default {
  layout: "purchasers",

  data() {
    return {
      links: [
        {
          name: "アカウント情報",
          img: "people-light.png",
          path: "/purchasers/mypage-detail",
        },
        {
          name: "お気に入り商品",
          img: "hart-light.png",
          path: "/purchasers/favorite",
        },
        { name: "カート", img: "cart-light.png", path: "/purchasers/cart" },
        {
          name: "注文履歴",
          img: "box-light.png",
          path: "/purchasers/orderList",
        },
        {
          name: "ポイント履歴",
          img: "point-light.png",
          path: "/purchasers/point",
        },
        {
          name: "ログアウト",
          img: "logout-light.png",
          path: "/",
        },
      ],
    };
  },

  methods: {
    linkImg(img) {
      const path = require(`@/assets/img/${img}`);
      return `url(${path})`;
    },
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
    async cookie() {
      this.$axios.get("http://localhost:8000/sanctum/csrf-cookie", {
        withCredentials: true,
      });
    },
    async logout() {
      console.log("c");
      await this.cookie();
      await this.$axios.post(
        "http://localhost:8000/api/purchaser/logout",
        {},
        {
          withCredentials: true,
        }
      );
      this.$store.dispatch("updateLoginPurchaserUser");
      this.$store.commit("removeCartList");
    },
  },
};
</script>

<style lang="scss" scoped>
.my-page {
  background-color: white;
  width: 90%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 4rem 0;
  &__title {
    font-size: 2.8rem;
    padding-bottom: 1rem;
    font-weight: bold;
    border-bottom: 4px solid #c4c4c4;
    margin-bottom: 3.5rem;
  }
  &__top {
    width: 90%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.8rem 5rem;
    border: 4px solid #c4c4c4;
    box-shadow: 0 0 1.2rem 0 #c4c4c4;
  }
  &__img {
    width: 8rem;
    padding-top: 8rem;
    background-color: #c4c4c4;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__name {
    font-size: 3rem;
  }
  &__contents {
    width: 75%;
    margin: 6rem auto 0;
    display: flex;
    flex-wrap: wrap;
    align-content: center;
    justify-content: space-between;
  }
}
.links {
  display: block;
  text-align: center;
  width: 28%;
  margin-bottom: 3.8rem;
  padding: 1.4rem 0;
  border: 4px solid #c4c4c4;
  box-shadow: 0 0 1.2rem 0 #c4c4c4;
  &__img {
    width: 40%;
    padding-top: 40%;
    margin: 0 auto;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__name {
    margin-top: 1.5rem;
    font-size: 1.3rem;
  }
}
</style>
