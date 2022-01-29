<template>
  <div class="item-detail" v-if="item">
    <div class="item-status">
      <div
        class="item-status__img"
        :style="itemImg(item.item_image[0].image_path)"
      ></div>
      <div class="item-status__center">
        <p class="item-status__name">{{ item.name }}</p>
        <nuxt-link
          :to="`/purchasers/itemList?filter=category&category=${item.category_id}`"
          >{{ item.category.name }}</nuxt-link
        >
        <p class="item-status__price">
          ¥{{ item.price.toLocaleString() }}（税込）
        </p>
      </div>
      <div class="item-status__right">
        <div v-if="$store.state.isLogin">
          <div
            class="item-status__favorite"
            @click="createFavorite()"
            :style="favoriteStyle"
          >
            <span v-if="favorite == true">♡:お気に入り済み</span>
            <span v-else>♡:お気に入りに追加</span>
          </div>
          <br />
          <label for="">数量</label><input type="number" v-model="quantity" />
          <p @click="addCart(item)" class="item-status__cart">カートに入れる</p>
        </div>
      </div>
    </div>
    <div class="item-explanation">
      <h2 class="item-explanation__title">商品説明</h2>
      <p class="item-explanation__text">{{ item.explanation }}</p>
    </div>
    <div class="item-images">
      <h2 class="item-images__title">商品ギャラリー</h2>
      <div class="item-images__content">
        <div
          class="item-images__image"
          v-for="itemImage in item.item_image"
          :key="itemImage.id"
          :style="itemImg(itemImage.image_path)"
        ></div>
      </div>
    </div>
    <div class="review" v-if="reviews">
      <h2 class="review__title">レビュー</h2>
      <div class="review-main">
        <h3 class="review-main__title">総合評価</h3>
        <div class="review-main__content">
          <div class="review-info">
            <p class="review-info__score">{{ starsDesc.allEvaluate }}</p>
            <div class="review-info__star-box">
              <div
                v-for="(star, index) in starsDesc.allEvaluateStar"
                class="review-info__star"
                :key="index"
                :style="starImage(star)"
              ></div>
            </div>
            <p class="review-info__number">{{ reviews.length }}件の評価</p>
          </div>
          <div class="review-bar-box">
            <div
              class="review-bar"
              v-for="(star, index) in reversedStars"
              :key="index"
            >
              <div class="review-bar__star"></div>
              <div class="review-bar__number">{{ 5 - index }}</div>
              <div class="bar">
                <div
                  class="bar__fill"
                  :style="`width: ${starsDesc.percent[index]}%`"
                ></div>
              </div>
              <div class="review-bar__percent">
                {{ starsDesc.percent[index] }}%
              </div>
            </div>
          </div>
        </div>
        <div class="review-main__control">
          <nuxt-link
            class="review-main__button"
            :to="`/purchasers/review/${$route.params.id}`"
            >レビューを書く</nuxt-link
          >
        </div>
      </div>
      <div class="review-box" v-for="review in reviews" :key="review.id">
        <div class="review-box__profile-box">
          <div
            class="review-box__profile-image"
            :style="itemImg(review.purchaser.image_path)"
          ></div>
          <p class="review-box__profile-name">{{ review.purchaser.name }}</p>
        </div>
        <p class="review-box__time">{{ review.created_at }}</p>
        <div class="review-box__main">
          <div class="review-box__star-box">
            <div
              v-for="i in review.star"
              class="review-box__fill-star"
              :key="i"
            ></div>
            <div
              v-for="i in 5 - review.star"
              class="review-box__zero-star"
              :key="i + 5"
            ></div>
          </div>
          <div class="review-box__title">{{ review.title }}</div>
        </div>
        <p class="review-box__text">{{ review.content }}</p>
        <div class="review-box__image-box">
          <div
            v-for="(image, index) in review.review_image"
            class="review-box__image"
            :key="index"
            :style="itemImg(image.image_path)"
          ></div>
        </div>
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
      favorite: null,
      quantity: 1,
      reviews: null,
      stars: [0, 0, 0, 0, 0],
    };
  },

  computed: {
    cartList() {
      this.$store.state.cartList;
    },
    favoriteStyle() {
      if (this.favorite) {
        return `background-color: #218060; color: white`;
      } else {
        return `border: 1px solid #218060; color: #218060`;
      }
    },
    reversedStars() {
      return JSON.parse(JSON.stringify(this.stars)).reverse();
    },
    starsDesc() {
      const numberOfStars = this.reviews.length;
      const desc = {};
      desc.percent = this.reversedStars.map((star) =>
        numberOfStars != 0 ? Math.round((star * 100) / numberOfStars) : 0
      );
      desc.allEvaluate =
        numberOfStars != 0
          ? Math.round(
              (this.stars.reduce(
                (pre, cur, curIndex) => pre + cur * (curIndex + 1)
              ) *
                100) /
                numberOfStars
            ) / 100
          : 0;
      desc.allEvaluateStar = [];
      for (let i = 0; i < 5; i++) {
        if (desc.allEvaluate - i <= 0) {
          desc.allEvaluateStar.push("zero");
        } else if (desc.allEvaluate - i >= 0.1 && desc.allEvaluate - i < 1) {
          desc.allEvaluateStar.push("half");
        } else {
          desc.allEvaluateStar.push("fill");
        }
      }
      return desc;
    },
  },

  methods: {
    starImage(key) {
      switch (key) {
        case "fill":
          return `background-image: url(${require("@/assets/img/star-full.png")})`;
        case "zero":
          return `background-image: url(${require("@/assets/img/star-zero.png")})`;
        default:
          return `background-image: url(${require("@/assets/img/star-half.png")})`;
      }
    },
    async getItemDetail(id) {
      await this.$axios
        .get("http://localhost:8000/api/item/" + id, {
          withCredentials: true,
        })
        .then((response) => {
          this.item = response.data;
          console.log(this.item);
        });
    },
    async getReview(id) {
      await this.$axios
        .get("http://localhost:8000/api/review/" + id, {
          withCredentials: true,
        })
        .then((response) => {
          this.reviews = response.data;
          this.reviews.forEach((review) => {
            this.stars[review.star - 1]++;
          });
        });
    },

    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },

    async addCart(item) {
      const itemQuantity = this.quantity;
      const validateCheck = /^([1-9]\d*|0)$/;
      if (itemQuantity != null && validateCheck.test(itemQuantity)) {
        item.quantity = itemQuantity;
      } else {
        return alert("正しい値を入力してください！");
      }

      this.$store.dispatch("addCartList", item);
      this.$router.push("/purchasers/cart");
    },

    async showFavorite() {
      if (this.$store.state.loginUser == null) return;
      await this.$axios
        .get("http://localhost:8000/api/favorite/show/", {
          withCredentials: true,
          params: {
            purchaser_id: this.$store.state.loginUser.id,
            item_id: this.$route.params.id,
          },
        })
        .then(() => {
          this.favorite = true;
        })
        .catch(() => {
          this.favorite = false;
        });
    },

    async createFavorite() {
      this.favorite = !this.favorite;
      await this.$axios.post(
        "http://localhost:8000/api/favorite/create/",
        {
          purchaser_id: this.$store.state.loginUser.id,
          item_id: this.$route.params.id,
        },
        {
          withCredentials: true,
        }
      );
    },
  },

  async mounted() {
    await this.getItemDetail(this.$route.params.id);
    this.getReview(this.$route.params.id);
    this.showFavorite();
  },
};
</script>

<style lang="scss" scoped>
.item-detail {
  width: 90%;
  max-width: 1000px;
  margin: 0 auto;
  padding: 5% 0;
}
.item-status {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 10vh;
  &__img {
    width: 15rem;
    padding-top: 15rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__center {
    width: 40%;
    padding-top: 0.7rem;
  }
  &__right {
    width: 30%;
    padding-top: 0.7rem;
  }
  &__name {
    font-size: 2.3rem;
    padding-bottom: 1rem;
  }
  &__price {
    font-size: 1.3rem;
    font-weight: bold;
    color: red;
    padding-bottom: 3rem;
  }
  &__favorite {
    text-align: center;
    padding: 1.2rem 0;
    font-size: 1.2rem;
    border-radius: 0.8rem;
    margin-bottom: 1.8rem;
    &:hover {
      cursor: pointer;
    }
  }
  &__cart {
    text-align: center;
    padding: 1.2rem 0;
    font-size: 1.2rem;
    background-color: #218060;
    color: white;
    border-radius: 0.8rem;
    box-shadow: 0 0 0.4rem 0 rgb(77, 76, 76);
    &:hover {
      cursor: pointer;
    }
  }
}
.item-explanation {
  &__title {
    font-size: 1.4rem;
  }
  &__text {
    font-size: 1.2rem;
    width: 90%;
    margin: 1.5rem auto 0;
    white-space: pre-line;
  }
}
.item-images {
  &__title {
    font-size: 1.4rem;
    margin-top: 2rem;
  }
  &__content {
    display: flex;
    overflow-x: scroll;
    width: 90%;
    margin: 1.5rem auto 0;
  }
  &__image {
    width: 15rem;
    min-width: 15rem;
    height: 15rem;
    margin: 0 2rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
}
.review {
  &__title {
    font-size: 1.4rem;
    margin: 2rem 0 1.3rem;
  }
  &__image {
    width: 15rem;
    min-width: 15rem;
    height: 15rem;
    margin: 0 2rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
}
.review-main {
  width: 90%;
  margin: 0 auto;
  padding: 0.6rem 0.7rem;
  border: 1px solid #c4c4c4;
  &__title {
    font-size: 1.4rem;
    font-weight: bold;
  }
  &__content {
    display: flex;
  }
  &__control {
    text-align: right;
  }
  &__button {
    display: inline-block;
    padding: 0.2rem 1rem;
    color: #218060;
    border: 1px solid #218060;
    border-radius: 2rem;
  }
}
.review-info {
  width: 25%;
  &__score {
    font-size: 1.1rem;
    font-weight: bold;
    margin-top: 1.2rem;
  }
  &__star-box {
    margin-top: 1.2rem;
    display: flex;
  }
  &__star {
    width: 1.4rem;
    height: 1.4rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__number {
    margin-top: 1.2rem;
  }
}
.review-bar {
  display: flex;
  align-items: center;
  &__star {
    width: 1.1rem;
    height: 1.1rem;
    margin-right: 0.2rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-image: url("~/assets/img/star-full.png");
  }
  &__number {
    font-size: 0.9rem;
    margin-right: 1.4rem;
  }
  &__percent {
    font-size: 0.9rem;
  }
}
.bar {
  width: 18rem;
  height: 1.7rem;
  background-color: #e5e5e5;
  border-radius: 1.1rem;
  margin-right: 1.7rem;
  margin-bottom: 0.5rem;
  &__fill {
    height: 1.7rem;
    border-radius: 1.1rem;
    width: 0;
    background-color: #fadd28;
  }
}
.review-box {
  width: 90%;
  margin: 0 auto;
  padding: 1rem 1rem;
  border: 1px solid #c4c4c4;
  border-top: 0;
  &__profile-box {
    display: flex;
    align-items: center;
    margin-bottom: 0.3rem;
  }
  &__profile-image {
    width: 3.8rem;
    height: 3.8rem;
    margin: 0 0.9rem 0 0;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__profile-name {
    font-size: 1.6rem;
  }
  &__time {
    font-size: 0.7rem;
    margin-left: 3rem;
  }
  &__main {
    padding: 1.2rem 0;
    display: flex;
    align-items: center;
  }
  &__star-box {
    display: flex;
    margin-right: 1.2rem;
  }
  %star {
    width: 1.8rem;
    height: 1.8rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__fill-star {
    @extend %star;
    background-image: url("~/assets/img/star-full.png");
  }
  &__zero-star {
    @extend %star;
    background-image: url("~/assets/img/star-zero.png");
  }
  &__title {
    font-size: 1.1rem;
    font-weight: bold;
  }
  &__text {
    width: 95%;
    margin: 0 auto 1rem;
    font-size: 1.2rem;
    white-space: pre-line;
  }
  &__image-box {
    display: flex;
    align-items: center;
    width: 95%;
    margin: 0 auto;
  }
  &__image {
    width: 7rem;
    height: 7rem;
    margin-right: 0.8rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
}
</style>
