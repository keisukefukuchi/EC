<template>
  <div class="item-register">
    <h1 class="item-register__title">商品登録</h1>
    <div class="item-register__content">
      <h2 class="item-register__sub-title">商品情報</h2>
      <dl class="item-register-info">
        <div class="item-register-info__row">
          <dt class="item-register-info__name">商品名</dt>
          <input
            class="item-register-info__value--input"
            v-model="itemData.name"
          />
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">カテゴリ</dt>
          <select v-model="itemData.category_id">
            <option value="1">筆記用具</option>
            <option value="2">画材用具</option>
            <option value="3">紙製品</option>
            <option value="4">整理用品</option>
            <option value="5">机上用品</option>
            <option value="6">事務用品</option>
            <option value="7">製図用品</option>
            <option value="8">その他</option>
          </select>
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">商品画像 (最大5枚）</dt>
          <dd class="item-register-info__value--image"></dd>
          <div
            class="item-register-info__image-box--view"
            v-for="(newItemImageURL, index) in newItemImageURLs"
            :key="index"
            :style="`background-image: url(${newItemImageURL})`"
            @click="
              newItemImageURLs.splice(index, 1);
              newItemImages.splice(index, 1);
            "
          >
            <div class="delete"></div>
          </div>
          <label
            class="item-register-info__image-box--input"
            v-if="newItemImageURLs.length < 5"
          >
            <input type="file" @change="imageChange" multiple />
          </label>
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">商品説明</dt>
          <textarea
            class="item-register-info__value--text-area"
            name=""
            id="explanation"
            cols="30"
            rows="10"
            v-model="itemData.explanation"
          ></textarea>
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">販売価格</dt>
          <input
            class="item-register-info__value--input"
            v-model="itemData.price"
          />
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">初期在庫</dt>
          <input
            class="item-register-info__value--input"
            v-model="itemData.stock"
          />
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">公開設定</dt>
          <label class="item-register-info__value--radio">
            <input type="radio" v-model="itemData.public" value="1" />
            公開
          </label>
          <label class="item-register-info__value--radio">
            <input type="radio" v-model="itemData.public" value="0" />
            非公開
          </label>
        </div>
      </dl>
      <h2 class="item-register__sub-title">おすすめ情報</h2>
      <dl class="item-register-info">
        <div class="item-register-info__row">
          <dt class="item-register-info__name">おすすめ登録</dt>
          <label class="item-register-info__value--radio">
            <input type="radio" v-model="itemData.recommendation" value="1" />
            おすすめ商品に登録
          </label>
          <label class="item-register-info__value--radio">
            <input type="radio" v-model="itemData.recommendation" value="0" />
            おすすめ登録商品に登録しない
          </label>
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">キャッチコピー</dt>
          <textarea
            class="item-register-info__value--text-area"
            name=""
            id="explanation"
            cols="30"
            rows="10"
            v-model="itemData.slogan"
          ></textarea>
        </div>
        <div class="item-register-info__row">
          <dt class="item-register-info__name">おすすめ画像</dt>
          <dd class="item-register-info__value--image"></dd>
          <div
            class="item-register-info__image-box--view"
            :style="`background-image: url(${recommendImageURL})`"
            v-if="recommendImage != ''"
            @click="
              recommendImage = '';
              recommendImageURL = '';
            "
          >
            <div class="delete"></div>
          </div>
          <label
            class="item-register-info__image-box--input"
            v-if="recommendImage == ''"
          >
            <input type="file" @change="recommendImageChange" />
          </label>
        </div>
      </dl>
      <div class="item-register__footer">
        <div class="item-register__button" @click="registerItem">登録する</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "sellers",

  data() {
    return {
      itemData: {
        name: "",
        explanation: "",
        price: 0,
        stock: 0,
        public: 1,
        recommendation: 0,
        slogan: "",
        category_id: 8,
      },
      newItemImages: [],
      newItemImageURLs: [],
      recommendImage: "",
      recommendImageURL: "",
    };
  },

  methods: {
    async registerItem() {
      if (this.newItemImages.length == 0) return;
      const formData = new FormData();
      formData.append("recommend_image", this.recommendImage);
      formData.append("item", JSON.stringify(this.itemData));
      await this.$axios
        .post("http://localhost:8000/api/item/register", formData, {
          withCredentials: true,
        })
        .then(async (response) => {
          console.log(response);
          const formData = new FormData();
          this.newItemImages.forEach((newItemImage) => {
            formData.append(`file[]`, newItemImage);
          });
          formData.append("item_id", response.data.content.id);
          await this.$axios.post(
            "http://localhost:8000/api/item-image/register",
            formData,
            {
              withCredentials: true,
            }
          );
        });
      this.$router.push("/sellers/item/all");
    },

    imageChange(event) {
      this.newItemImages.push(...event.target.files);
      if (this.newItemImages.length > 5) this.newItemImages.length = 5;
      this.newItemImageURLs = this.newItemImages.map((newItemImage) =>
        URL.createObjectURL(newItemImage)
      );
    },
    recommendImageChange(event) {
      this.recommendImage = event.target.files[0];
      this.recommendImageURL = URL.createObjectURL(this.recommendImage);
    },
  },
};
</script>

<style lang="scss" scoped>
input[type="file"] {
  display: none;
}
.item-register {
  &__title {
    font-size: 2.5vw;
    background-color: white;
    padding: 0.8vh 1.2vw;
  }
  &__content {
    margin-top: 3vh;
    background-color: white;
    padding: 3vh 2vw;
  }
  &__sub-title {
    font-size: 1.8vw;
    padding-bottom: 1.8vh;
    border-bottom: 5px solid #c4c4c4;
  }
  &__footer {
    text-align: center;
  }
  &__button {
    display: inline-block;
    background-color: #3c9b9a;
    color: white;
    margin-top: 3vh;
    font-size: 1.4vw;
    padding: 1vw 2vw;
    border-radius: 0.6vw;
    &:hover {
      cursor: pointer;
    }
  }
}
.item-register-info {
  width: 90%;
  margin: 0 auto;
  &__row {
    display: flex;
    // align-items: center;
    flex-wrap: wrap;
    padding: 2.6vh 0;
    border-bottom: 2px solid #c4c4c4;
  }
  &__name {
    flex-basis: 25%;
  }
  &__value {
    &--input {
      flex: 1;
      border: 1px solid #c4c4c4;
      border-radius: 1vw;
      padding: 1.3vh 1vw;
    }
    &--image {
      flex-basis: 75%;
    }
    &--radio {
      margin-right: 9vw;
    }
    &--text-area {
      border: 1px solid #c4c4c4;
      flex: 1;
      border-radius: 1vw;
      padding: 1.3vh 1vw;
    }
  }
  %image-box {
    margin-top: 3vh;
    margin-right: 3vh;
    height: 15vh;
    width: 15vh;
    border-radius: 1vh;
    background-size: cover;
    background-position: center;
  }
  &__image-box {
    &--view {
      @extend %image-box;
      &:hover {
        cursor: pointer;
        & .delete {
          width: 100%;
          height: 100%;
          border-radius: inherit;
          background-color: #3d3c3ca9;
          background-image: url("~/assets/img/garbage-white.png");
          background-size: 40% 40%;
          background-position: center;
          background-repeat: no-repeat;
        }
      }
    }
    &--input {
      @extend %image-box;
      border: solid 1px #c4c4c4;
      background-image: url("~/assets/img/image-add.png");
      &:hover {
        cursor: pointer;
      }
    }
  }
}
</style>
