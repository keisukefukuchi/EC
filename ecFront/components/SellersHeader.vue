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
        v-if="!$store.state.isLogin"
        class="header-nav__list"
        @click="$router.push('/sellers/login')"
      >
        ログイン
      </div>
      <div v-else class="header-nav__list" @click="logout()">
        ログアウト({{ $store.state.loginUser.name }})
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
        .get("http://localhost:8000/api/seller/user", {
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
        "http://localhost:8000/api/seller/logout",
        {},
        {
          withCredentials: true,
        }
      );
      this.$store.dispatch("updateLoginSellerUser");
      this.$router.push("/sellers/login");
    },
  },
};
</script>
<style lang="scss" scoped>
.header {
  height: 100%;
  background-color: #3c9b9a;
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
  }
}
.header-nav {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  &__list {
    margin-right: 1vw;
    font-size: 2vw;
    padding: 10px;
    background-color: rgba(114, 121, 118, 0.472);
    &:hover {
      cursor: pointer;
    }
  }
}
</style>
