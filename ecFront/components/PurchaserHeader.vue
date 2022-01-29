<template>
  <div class="header">
    <img
      class="header__logo"
      src="~/assets/img/logo.png"
      alt=""
      @click="$router.push('/')"
    />
    <nav class="header__nav header-nav">
      <div
        v-if="$store.state.isLogin"
        class="header-nav__list"
        @click="$router.push('/purchasers/mypage')"
      >
        <div class="header-nav__img--people"></div>
        <p class="header-nav__name">{{ $store.state.loginUser.name }}</p>
      </div>
      <div
        v-else
        class="header-nav__list"
        @click="$router.push('/purchasers/login')"
      >
        <div class="header-nav__img--people"></div>
        <p class="header-nav__name">ログイン</p>
      </div>
      <div class="header-nav__list" @click="$router.push('/purchasers/about')">
        <div class="header-nav__img--building"></div>
        <p class="header-nav__name">Freshs</p>
      </div>
      <div class="header-nav__list" @click="$router.push('/purchasers/cart')">
        <div class="header-nav__img--cart"></div>
        <p class="header-nav__name">カート</p>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isLogin: false,
    };
  },
  methods: {
    async getUserData() {
      this.$axios
        .get("http://localhost:8000/api/purchaser/user", {
          withCredentials: true,
        })
        .then(() => {
          this.isLogin = true;
        });
    },
    async cookie() {
      this.$axios.get("http://localhost:8000/sanctum/csrf-cookie", {
        withCredentials: true,
      });
    },

    async logout() {
      await this.cookie();
      await this.$axios.post(
        "http://localhost:8000/api/purchaser/logout",
        {},
        {
          withCredentials: true,
        }
      );
      this.$store.dispatch("updateLoginUser");
    },
  },
};
</script>
<style lang="scss" scoped>
.header {
  height: 7rem;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: space-between;
  &__logo {
    height: 80%;
    &:hover {
      cursor: pointer;
    }
  }
  &__nav {
    width: 40%;
  }
}
.header-nav {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  &__list {
    margin-right: 3rem;
    font-size: 0.8rem;
    &:hover {
      cursor: pointer;
    }
  }
  %img {
    padding-top: 3rem;
    width: 3rem;
    margin: 0 auto;
    background-size: cover;
  }
  &__img {
    &--people {
      @extend %img;
      background-image: url("~/assets/img/people-dark.png");
    }
    &--building {
      @extend %img;
      background-image: url("~/assets/img/building-dark.png");
    }
    &--cart {
      @extend %img;
      background-image: url("~/assets/img/cart-dark.png");
    }
  }
  &__name {
    font-size: 1.2rem;
    margin-top: 0.8rem;
    text-align: center;
  }
}
</style>
