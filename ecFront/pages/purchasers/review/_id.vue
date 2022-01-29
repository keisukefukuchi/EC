<template>
  <div class="review" v-if="item">
    <h1 class="review__title">商品レビュー</h1>
    <div class="review__content">
      <div class="review__row">
        <div class="item">
          <div
            class="item__image"
            :style="itemImg(item.item_image[0].image_path)"
          ></div>
          <div class="item__name">{{ item.name }}</div>
        </div>
      </div>
      <div class="review__row">
        <h2 class="review__subtitle">総合評価</h2>
        <button
          class="review__star"
          v-for="index of 5"
          :key="index"
          @click="reviewData.star = index"
          :style="starImage(index)"
        ></button>
        <button
          v-if="reviewData.star != 0"
          class="review__star-zero"
          @click="reviewData.star = 0"
        >
          削除
        </button>
      </div>
      <div class="review__row">
        <h2 class="review__subtitle">タイトル</h2>
        <input type="text" class="review__input" v-model="reviewData.title" />
      </div>
      <div class="review__row">
        <h2 class="review__subtitle">写真の投稿（最大5枚）</h2>
        <div class="review-image">
          <div
            class="review-image__content--view"
            v-for="(newReviewImageURL, index) in newReviewImageURLs"
            :key="index"
            :style="`background-image: url(${newReviewImageURL})`"
            @click="
              newReviewImageURLs.splice(index, 1);
              newReviewImages.splice(index, 1);
            "
          >
            <div class="delete"></div>
          </div>
          <label
            class="review-image__content--input"
            v-if="newReviewImageURLs.length < 5"
          >
            <input type="file" @change="imageChange" multiple />
          </label>
        </div>
      </div>
      <div class="review__row">
        <h2 class="review__subtitle">感想</h2>
        <textarea
          class="review__input"
          cols="30"
          rows="10"
          v-model="reviewData.content"
        ></textarea>
      </div>
      <div class="review__control">
        <div class="review__button" @click="register">投稿する</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "purchasers",

  data() {
    return {
      item: null,
      newReviewImages: [],
      newReviewImageURLs: [],
      reviewData: {
        star: 0,
        title: "",
        content: "",
        purchaser_id: this.$store.state.loginUser.id,
        item_id: this.$route.params.id,
      },
    };
  },

  methods: {
    starImage(index) {
      if (index <= this.reviewData.star)
        return `background-image: url(${require("@/assets/img/star-full.png")})`;
      return `background-image: url(${require("@/assets/img/star-zero.png")})`;
    },
    async getItemDetail(id) {
      await this.$axios
        .get("http://localhost:8000/api/item/" + id, {
          withCredentials: true,
        })
        .then((response) => {
          this.item = response.data;
        });
    },
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
    imageChange(event) {
      this.newReviewImages.push(...event.target.files);
      if (this.newReviewImages.length > 5) this.newReviewImages.length = 5;
      this.newReviewImageURLs = this.newReviewImages.map((newReviewImage) =>
        URL.createObjectURL(newReviewImage)
      );
    },

    async register() {
      await this.$axios
        .post("http://localhost:8000/api/review/register", this.reviewData, {
          withCredentials: true,
        })
        .then(async (res) => {
          console.log(res);
          const formData = new FormData();
          this.newReviewImages.forEach((newReviewImage) => {
            formData.append(`file[]`, newReviewImage);
          });
          formData.append("review_id", res.data.content.id);
          await this.$axios
            .post("http://localhost:8000/api/review-image/register", formData, {
              withCredentials: true,
            })
            .then((res) => {
              console.log(res);
            });
        });
      this.$router.push("/purchasers/itemDetail/" + this.$route.params.id);
    },
  },

  mounted() {
    this.getItemDetail(this.$route.params.id);
  },
};
</script>

<style lang="scss" scoped>
input[type="file"] {
  display: none;
}
.review {
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
  }
  &__content {
    width: 95%;
    margin: 0 auto;
    & .review__row:nth-last-child(2) {
      border: none;
    }
  }
  &__row {
    padding: 1rem 0 3rem;
    border-bottom: 2px solid #c4c4c4;
  }
  &__subtitle {
    font-size: 2rem;
  }
  &__star {
    width: 5rem;
    height: 5rem;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  &__input {
    border: 1px solid #c4c4c4;
    border-radius: 0.5em;
    padding: 0.8rem 1rem;
    width: calc(100% - 4rem);
    margin: 2rem 0 0 4rem;
    font-size: 1.5rem;
  }
  &__control {
    text-align: right;
  }
  &__button {
    display: inline-block;
    padding: 1rem 2rem;
    font-size: 1.7rem;
    color: white;
    background-color: #218060;
    border-radius: 1.1rem;
    margin: 1rem 3rem 0 0;
    &:hover {
      cursor: pointer;
    }
  }
}
.review-image {
  display: flex;
  flex-wrap: wrap;
  margin-left: 4rem;
  %image-box {
    margin-top: 3rem;
    margin-right: 3rem;
    height: 15rem;
    width: 15rem;
    border-radius: 1rem;
    background-size: cover;
    background-position: center;
  }
  &__content {
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
      display: block;
      border: solid 1px #c4c4c4;
      background-image: url("~/assets/img/image-add.png");
      &:hover {
        cursor: pointer;
      }
    }
  }
}
.item {
  display: flex;
  &__image {
    width: 15rem;
    padding-top: 15rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__name {
    font-size: 3rem;
    margin: 2rem 0 0 2rem;
  }
}
</style>
