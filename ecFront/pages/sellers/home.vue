<template>
  <div class="my-page">
    <h1>ホーム</h1>
    <p v-if="stripe != null">本日の売り上げ：{{ stripe.salesDay }}</p>
    <p v-if="stripe != null">今月の売り上げ：{{ stripe.salesMonth }}</p>
  </div>
</template>

<script>
export default {
  layout: "sellers",

  data() {
    return {
      userData: null,
      stripe: null,
    };
  },

  methods: {
    async getUserData() {
      this.$axios
        .get("http://localhost:8000/api/seller/user", {
          withCredentials: true,
        })
        .then((response) => {
          this.userData = response.data;
        });
    },
    async getStripe() {
      await this.$axios
        .get("http://localhost:8000/api/seller/stripe")
        .then((res) => {
          this.stripe = res.data;
        });
    },
    async cookie() {
      this.$axios.get("http://localhost:8000/sanctum/csrf-cookie", {
        withCredentials: true,
      });
    },
  },

  async mounted() {
    this.getUserData();
    this.getStripe();
  },
};
</script>

<style lang="scss" scoped>
.my-page {
  height: calc(100vh - 47vh);
  background-color: rgb(125, 200, 184);
  font-size: 3vw;
  & input {
    font-size: 3vw;
  }
  & button {
    font-size: 3vw;
  }
}
</style>
