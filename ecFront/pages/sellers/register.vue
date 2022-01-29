<template>
  <div class="register">
    <h1 class="register__title">新規登録</h1>
    <div class="register__content">
      <h2 class="register__subtitle">初めてご利用の方・会員以外の方</h2>
      <div class="register__input-box">
        <label class="register__label" for="">お名前：</label>
        <input class="register__input" type="text" v-model="name" />
      </div>
      <div class="register__input-box">
        <label class="register__label" for="">メールアドレス：</label
        ><input class="register__input" type="email" v-model="email" />
      </div>
      <div class="register__input-box">
        <label class="register__label" for="">パスワード：</label
        ><input class="register__input" type="password" v-model="password" />
      </div>
      <div class="register__button" @click="register()">登録</div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "sellersAuth",

  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },

  methods: {
    async register() {
      await this.cookie();
      this.$axios
        .post(
          "http://localhost:8000/api/seller/register",
          {
            name: this.name,
            email: this.email,
            password: this.password,
          },
          {
            withCredentials: true,
          }
        )
        .then((response) => {
          this.login(response.data.newUser);
        });
    },
    async login({ email, password }) {
      this.$axios
        .post(
          "http://localhost:8000/api/seller/login",
          {
            email: email,
            password: password,
          },
          {
            withCredentials: true,
          }
        )
        .then(() => {
          this.$router.push("/sellers/home");
        });
    },
    async cookie() {
      await this.$axios.get("http://localhost:8000/sanctum/csrf-cookie", {
        withCredentials: true,
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.register {
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
}
</style>
