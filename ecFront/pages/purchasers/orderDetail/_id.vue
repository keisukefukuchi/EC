<template>
  <div class="order-detail">
    <h1 class="order-detail__title">注文詳細</h1>
    <div class="order-detail__info" v-if="order">
      <dl class="detail-info">
        <dt class="detail-info__column">注文番号</dt>
        <dd class="detail-info__data">
          {{ order.id }}
        </dd>
        <dt class="detail-info__column">注文日</dt>
        <dd class="detail-info__data">
          {{ order.created_at }}
        </dd>
        <dt class="detail-info__column">お届け先</dt>
        <dd class="detail-info__data">
          {{ order.destination }}
        </dd>
      </dl>
      <div class="detail-price">
        <h2 class="detail-price__title">購入明細</h2>
        <dl>
          <div class="detail-price__list">
            <dt>商品の小計：</dt>
            <dd>¥{{ order.amount.toLocaleString() }}</dd>
          </div>
          <div class="detail-price__list">
            <dt>ポイント：</dt>
            <dd>-¥{{ order.used_point.toLocaleString() }}</dd>
          </div>
          <div class="detail-price__sum">
            <dt>請求額：</dt>
            <dd>¥{{ order.total.toLocaleString() }}</dd>
          </div>
        </dl>
      </div>
    </div>
    <div v-if="order" class="order-detail__item">
      <h2 class="order-detail__sub-title">注文商品一覧</h2>
      <div
        class="box-list"
        v-for="(history, index) in order.histories"
        :key="index"
      >
        <div
          class="box-list__img"
          :style="itemImg(history.item.item_image[0].image_path)"
        ></div>
        <div class="box-list__item">
          <p class="box-list__item-name">{{ history.item.name }}</p>
        </div>
        <div class="box-list__number">
          <p class="box-list__quantity">数量：{{ history.quantity }}</p>
          <p class="box-list__price">
            ¥{{ history.item.price.toLocaleString() }}
          </p>
        </div>
        <nuxt-link
          class="box-list__button"
          :to="`/purchasers/review/${history.item.id}`"
          >レビューの投稿</nuxt-link
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: "purchasers",
  data() {
    return {
      order: null,
    };
  },
  methods: {
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
    async getOrderHistories(id) {
      const resData = await this.$axios.get(
        "http://localhost:8000/api/purchase/show/" + id,
        { withCredentials: true }
      );
      this.order = resData.data;
      console.log(this.orderList);
    },
  },
  created() {
    this.getOrderHistories(this.$route.params.id);
  },
};
</script>

<style lang="scss" scoped>
.order-detail {
  background-color: white;
  width: 90%;
  max-width: 1300px;
  margin: 0 auto;
  padding: 4rem 0;
  &__title {
    font-size: 2.8rem;
    padding-bottom: 1rem;
    font-weight: bold;
    border-bottom: 4px solid #c4c4c4;
    margin-bottom: 3.5rem;
  }
  &__item {
    border: 0.2rem solid #c4c4c4;
    border-radius: 0.9rem;
    overflow: hidden;
  }
  &__sub-title {
    font-size: 1.3rem;
    background-color: #f2f2f2;
    padding: 0.8rem 2rem;
  }
  &__info {
    display: flex;
    margin-bottom: 2rem;
  }
}
.detail-info {
  width: 40%;
  &__column {
    font-weight: bold;
  }
  &__data {
    margin-bottom: 0.9rem;
  }
}
.detail-price {
  width: 30%;
  &__title {
    font-weight: bold;
  }
  &__list {
    font-size: 0.9rem;
    display: flex;
    justify-content: space-between;
    padding: 0.6rem 0 0.6rem 1.2rem;
  }
  &__sum {
    font-size: 1.8rem;
    display: flex;
    justify-content: space-between;
    border-top: 0.2rem solid #218060;
    padding: 0.6rem 0 0.6rem 1.2rem;
  }
}
.box-list {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.9rem 2rem;
  &:not(:last-child) {
    border-bottom: 0.2rem solid #c4c4c4;
  }
  &__img {
    width: 10.2rem;
    height: 10.2rem;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  &__item {
    width: 30%;
  }
  &__item-name {
    font-size: 2.3rem;
    margin-bottom: 2rem;
  }
  &__number {
    width: 22%;
  }
  &__quantity {
    font-size: 1.2rem;
    margin-bottom: 2rem;
  }
  &__price {
    font-size: 2rem;
  }
  &__button {
    color: #218060;
    border: 0.15rem solid #218060;
    padding: 1rem 2rem;
    border-radius: 0.8rem;
  }
}
</style>
