<template>
  <div class="item-register" v-if="itemData != null">
    <h1 class="item-register__title">商品情報編集</h1>
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
            v-for="(oldItemImage, index) in oldItemImages"
            :key="oldItemImage.id"
            :style="`background-image: url(${oldItemImage.image_path})`"
            @click="
              oldItemImages.splice(index, 1);
              deletedOldItemImages.push(oldItemImage.id);
            "
          >
            <div class="delete"></div>
          </div>
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
            v-if="oldItemImages.length + newItemImages.length < 5"
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
          <dt class="item-register-info__name">在庫</dt>
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
            v-if="itemData.recommendation_image != ''"
            class="item-register-info__image-box--view"
            :style="`background-image: url(http://localhost:8000${itemData.recommendation_image})`"
            @click="itemData.recommendation_image = ''"
          >
            <div class="delete"></div>
          </div>
          <div
            v-if="newRecommendImage != ''"
            class="item-register-info__image-box--view"
            :style="`background-image: url(${newRecommendImageURL})`"
            @click="
              newRecommendImage = '';
              newRecommendImageURL = '';
            "
          >
            <div class="delete"></div>
          </div>
          <label
            class="item-register-info__image-box--input"
            v-if="
              itemData.recommendation_image == '' && newRecommendImage == ''
            "
          >
            <input type="file" @change="recommendImageChange" />
          </label>
        </div>
      </dl>
      <div class="item-register__footer">
        <div class="item-register__button" @click="updateItem">保存する</div>
      </div>
    </div>
  </div>
  <div v-else>そんな商品ない</div>
</template>
<script>
export default {
  layout: "sellers",

  data() {
    return {
      itemData: null,
      oldItemImages: [],
      deletedOldItemImages: [],
      newItemImages: [],
      newItemImageURLs: [],
      newRecommendImage: "",
      newRecommendImageURL: "",
    };
  },

  methods: {
    async updateItem() {
      if (this.newItemImages.length == 0 && this.oldItemImages == 0) return;
      const formData = new FormData();
      if (this.itemData.recommendation_image == "") {
        formData.append("recommend_image", this.newRecommendImage);
      } else {
        formData.append("recommend_image", "noUpdate");
      }
      formData.append("item", JSON.stringify(this.itemData));
      await this.$axios
        .post("http://localhost:8000/api/item/update", formData, {
          withCredentials: true,
        })
        .then((res) => {
          console.log(res);
        });
      await this.updateImage();
      this.$router.push("/sellers/item/all");
    },
    async updateImage() {
      const formData = new FormData();
      this.newItemImages.forEach((newItemImage) => {
        formData.append(`file[]`, newItemImage);
      });
      formData.append("item_id", this.itemData.id);
      this.deletedOldItemImages.forEach((deletedOldItemImage) => {
        formData.append(`delete_id[]`, deletedOldItemImage);
      });
      await this.$axios.post(
        "http://localhost:8000/api/item-image/register",
        formData,
        {
          withCredentials: true,
        }
      );
    },
    async getItemDetail() {
      this.$axios
        .get("http://localhost:8000/api/item/" + this.$route.params.id, {
          withCredentials: true,
        })
        .then((response) => {
          console.log(response);
          this.itemData = response.data;
          this.oldItemImages = response.data.item_image.map((image) => {
            image.image_path = `http://localhost:8000${image.image_path}`;
            return image;
          });
        });
    },
    imageChange(event) {
      this.newItemImages.push(...event.target.files);
      const maxFiles = 5 - this.oldItemImages.length;
      if (this.newItemImages.length > maxFiles)
        this.newItemImages.length = maxFiles;
      this.newItemImageURLs = this.newItemImages.map((newItemImage) =>
        URL.createObjectURL(newItemImage)
      );
    },
    recommendImageChange(event) {
      this.newRecommendImage = event.target.files[0];
      this.newRecommendImageURL = URL.createObjectURL(this.newRecommendImage);
    },
  },

  mounted() {
    this.getItemDetail();
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
