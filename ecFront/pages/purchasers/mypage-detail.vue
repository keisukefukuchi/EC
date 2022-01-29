<template>
  <div class="my-page" v-if="$store.state.isLogin">
    <h1 class="my-page__title">マイページ</h1>
    <div class="my-page__content">
      <div class="my-page__row">
        <div class="my-page__colum">プロフィール画像</div>
        <div class="my-page__image" :style="itemImg(userData.image_path)"></div>
        <label class="my-page__button">
          <input type="file" @change="updateImage" />画像をアップロード
        </label>
      </div>
      <div class="my-page__row">
        <div class="my-page__colum">お名前</div>
        <div v-if="!isInput.name" class="my-page__value">
          {{ userData.name }}
        </div>
        <input
          v-else
          class="my-page__value"
          type="text"
          v-model="userData.name"
        />
        <div
          v-if="!isInput.name"
          class="my-page__button"
          @click="isInput.name = true"
        >
          編集
        </div>
        <div
          v-else
          class="my-page__button--save"
          @click="
            updateValue({ name: userData.name });
            isInput.name = false;
          "
        >
          保存
        </div>
      </div>
    </div>
    <h2 class="my-page__sub-title">アカウント情報</h2>
    <div class="my-page__content">
      <div class="my-page__row">
        <div class="my-page__colum">性別</div>
        <div v-if="!isInput.gender" class="my-page__value">
          {{ gender(userData.gender) }}
        </div>
        <div v-else class="my-page__value">
          <label>
            男性
            <input type="radio" v-model="userData.gender" value="0" />
          </label>
          <label>
            女性
            <input type="radio" v-model="userData.gender" value="1" />
          </label>
        </div>
        <div
          v-if="!isInput.gender"
          class="my-page__button"
          @click="isInput.gender = true"
        >
          編集
        </div>
        <div
          v-else
          class="my-page__button--save"
          @click="
            updateValue({ gender: userData.gender });
            isInput.gender = false;
          "
        >
          保存
        </div>
      </div>
      <div class="my-page__row">
        <div class="my-page__colum">生年月日</div>
        <div v-if="!isInput.birthday" class="my-page__value">
          {{ userData.birthday }}
        </div>
        <input
          v-else
          class="my-page__value"
          type="date"
          v-model="userData.birthday"
        />
        <div
          v-if="!isInput.birthday"
          class="my-page__button"
          @click="isInput.birthday = true"
        >
          編集
        </div>
        <div
          v-else
          class="my-page__button--save"
          @click="
            updateValue({ birthday: userData.birthday });
            isInput.birthday = false;
          "
        >
          保存
        </div>
      </div>
      <div class="my-page__row">
        <div class="my-page__colum">e-mail</div>
        <div v-if="!isInput.email" class="my-page__value">
          {{ userData.email }}
        </div>
        <input
          v-else
          class="my-page__value"
          type="email"
          v-model="userData.email"
        />
        <div
          v-if="!isInput.email"
          class="my-page__button"
          @click="isInput.email = true"
        >
          編集
        </div>
        <div
          v-else
          class="my-page__button--save"
          @click="
            updateValue({ email: userData.email });
            isInput.email = false;
          "
        >
          保存
        </div>
      </div>
      <div class="my-page__row">
        <div class="my-page__colum">住所</div>
        <div v-if="!isInput.address" class="my-page__value">
          {{ userData.address }}
        </div>
        <input
          v-else
          class="my-page__value"
          type="text"
          v-model="userData.address"
        />
        <div
          v-if="!isInput.address"
          class="my-page__button"
          @click="isInput.address = true"
        >
          編集
        </div>
        <div
          v-else
          class="my-page__button--save"
          @click="
            updateValue({ address: userData.address });
            isInput.address = false;
          "
        >
          保存
        </div>
      </div>
      <div class="my-page__row">
        <div class="my-page__colum">パスワード</div>
        <div class="my-page__value">未実装</div>
        <div class="my-page__button">・・</div>
      </div>
      <div class="my-page__row">
        <div class="my-page__colum">登録カード</div>
        <div class="my-page__value">未実装</div>
        <div class="my-page__button">・・</div>
      </div>
    </div>
  </div>
  <p v-else>ログインして</p>
</template>

<script>
export default {
  layout: "purchasers",

  data() {
    return {
      userData: JSON.parse(JSON.stringify(this.$store.state.loginUser)),
      isInput: {
        name: false,
        gender: false,
        birthday: false,
        email: false,
        address: false,
      },
    };
  },

  methods: {
    gender(id) {
      if (id == null) return "";
      switch (Number(id)) {
        case 0:
          return "男性";
        case 1:
          return "女性";
        default:
          return "";
      }
    },
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
    async updateValue(value) {
      await this.$axios
        .post(
          "http://localhost:8000/api/purchaser/update",
          { value: value, id: this.userData.id },
          {
            withCredentials: true,
          }
        )
        .then((res) => {
          console.log(res);
        });
      await this.$store.dispatch("updateLoginPurchaserUser");
      // this.userData = JSON.parse(JSON.stringify(this.$store.state.loginUser));
    },
    async updateImage(event) {
      const formData = new FormData();
      formData.append("file", event.target.files[0]);
      formData.append("id", this.userData.id);
      await this.$axios.post(
        "http://localhost:8000/api/purchaser/update-image",
        formData,
        {
          withCredentials: true,
        }
      );
      await this.$store.dispatch("updateLoginPurchaserUser");
      this.userData = JSON.parse(JSON.stringify(this.$store.state.loginUser));
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
  &__sub-title {
    margin: 8rem 0 2rem;
    font-size: 2rem;
  }
  &__content {
    width: 95%;
    margin: 0 auto;
    border: 1px solid #c4c4c4;
    border-bottom: 0;
  }
  &__row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1.4rem;
    padding: 1.1rem 1.2rem;
    border-bottom: 1px solid #c4c4c4;
  }
  &__image {
    width: 13rem;
    height: 13rem;
    border-radius: 100%;
    background-color: #c4c4c4;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__colum {
    width: 23%;
    color: #c4c4c4;
  }
  &__value {
    width: 65%;
  }
  %button {
    border: 1px solid #218060;
    color: #218060;
    border-radius: 0.8rem;
    padding: 0.7rem 1rem;
    &:hover {
      cursor: pointer;
    }
  }
  &__button {
    @extend %button;
    &--save {
      @extend %button;
      background-color: #218060;
      color: white !important;
    }
  }
}
input[class="my-page__value"] {
  border: 1px solid #c4c4c4;
  border-radius: 0.4rem;
  padding: 0.4rem 0.8rem;
}
input[type="file"] {
  display: none;
}
</style>
