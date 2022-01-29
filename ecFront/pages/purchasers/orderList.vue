<template>
  <div class="order-list">
    <h1 class="order-list__title">注文履歴</h1>
    <div
      v-for="(order, index) in orderList"
      :key="index"
      class="order-list__box"
    >
      <div class="box-header">
        <div class="box-header__date">
          <p>注文日</p>
          <p>{{ order.created_at }}</p>
        </div>
        <div class="box-header__id">
          <p>注文番号</p>
          <p>{{ order.id }}</p>
        </div>
        <div class="box-header__amount">
          <p>合計</p>
          <p>¥{{ order.amount.toLocaleString() }}</p>
        </div>
        <nuxt-link
          class="box-header__button"
          :to="`/purchasers/orderDetail/${order.id}`"
          >注文詳細</nuxt-link
        >
      </div>
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
      orderList: [],
    };
  },

  methods: {
    itemImg(path) {
      if (path == null) return;
      return `background-image: url(http://localhost:8000${path})`;
    },
    async getOrderHistories() {
      const resData = await this.$axios.get(
        "http://localhost:8000/api/purchase/index/" +
          this.$store.state.loginUser.id,
        { withCredentials: true }
      );
      this.orderList = resData.data;
      console.log(this.orderList);
    },
  },

  created() {
    this.getOrderHistories();
  },
};
</script>
<style lang="scss" scoped>
.order-list {
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
  &__box {
    border-radius: 0.9rem;
    overflow: hidden;
    border: 0.2rem solid #c4c4c4;
    margin-bottom: 2rem;
  }
}
.box-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.3rem 2rem;
  background-color: #f2f2f2;
  font-size: 1.2rem;
  // border-radius: 0.9rem;

  &__date {
  }
  &__id {
  }
  &__amount {
  }
  &__button {
    padding: 0.9rem 2.3rem;
    background-color: #218060;
    color: white;
    border-radius: 0.4rem;
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
