<template>
  <div class="login">
    <h1 class="login__title">ログイン</h1>
    <div class="login__content">
      <h2 class="login__subtitle">会員のお客様</h2>
      <div class="login__input-box">
        <label class="login__label" for="">メールアドレス：</label>
        <input class="login__input" type="email" v-model="email" />
      </div>
      <div class="login__input-box">
        <label class="login__label" for="">パスワード：</label
        ><input class="login__input" type="password" v-model="password" />
      </div>
      <div class="login__button" @click="login">ログイン</div>
      <nuxt-link class="login__register" to="/purchasers/register"
        >初めての方はこちら</nuxt-link
      >
    </div>
  </div>
</template>

<script>
export default {
  layout: "purchasers",

  data() {
    return {
      email: "",
      password: "",
    };
  },

  methods: {
    async login() {
      this.$axios
        .post(
          "http://localhost:8000/api/purchaser/login",
          {
            email: this.email,
            password: this.password,
          },
          {
            withCredentials: true,
          }
        )
        .then(() => {
          this.$router.push("/");
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.login {
  width: 55%;
  max-width: 1000px;
  margin: 0 auto;
  padding: 7rem 0 10rem;
  &__title {
    font-size: 2.4rem;
    font-weight: bold;
    margin-bottom: 3.4rem;
  }
  &__content {
    width: 80%;
    margin: 0 auto;
  }
  &__subtitle {
    font-weight: bold;
    font-size: 2rem;
    padding: 0 0 0.8rem 1.4rem;
    border-bottom: 5px solid black;
  }
  &__input-box {
    display: flex;
    align-items: center;
    padding-top: 1.8rem;
  }
  &__label {
    display: inline-block;
    text-align: right;
    font-size: 1.5rem;
    width: 30%;
  }
  &__input {
    display: inline-block;
    width: 70%;
    font-size: 2.4rem;
    padding: 0.6rem 0.5rem;
    background-color: #fafafa;
    border-radius: 0.6rem;
    border: solid 2px #e2e2e2;
  }

  &__button {
    margin: 2rem 0 3.3rem auto;
    display: block;
    width: 30%;
    text-align: center;
    font-size: 2.2rem;
    background-color: #218060;
    border-radius: 0.4rem;
    padding: 0.7rem 0;
    color: white;
    &:hover {
      cursor: pointer;
    }
  }
  &__register {
    text-align: center;
  }
}
</style>
