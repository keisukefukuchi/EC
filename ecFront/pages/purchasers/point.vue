<template>
  <div class="point">
    <h1 class="point__title">ポイント履歴</h1>
    <div class="point-box">
      <div class="point-box__header">
        <div class="point-list">
          <div class="point-list__date">日付</div>
          <div class="point-list__number">項目</div>
          <div class="point-list__get">獲得</div>
          <div class="point-list__use">利用</div>
        </div>
      </div>
      <div class="point-box__content">
        <div class="point-list" v-for="order in orderList" :key="order.id">
          <div class="point-list__date">{{ dateFormat(order.created_at) }}</div>
          <div class="point-list__number">注文番号：{{ order.id }}</div>
          <div class="point-list__get">{{ numberFormat(order.get_point) }}</div>
          <div class="point-list__use">
            {{ numberFormat(order.used_point * -1) }}
          </div>
        </div>
      </div>
      <div class="point-box__footer"></div>
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
    async getOrderHistories() {
      const resData = await this.$axios.get(
        "http://localhost:8000/api/purchase/index/" +
          this.$store.state.loginUser.id,
        { withCredentials: true }
      );
      this.orderList = resData.data;
    },
    dateFormat(data) {
      const date = new Date(data);
      return `${date.getFullYear()}/${
        date.getMonth() + 1
      }/${date.getDate()}\n${date.getHours()}:${date.getMinutes()}`;
    },
    numberFormat(num) {
      if (num == 0) return "";
      return num;
    },
  },

  created() {
    this.getOrderHistories();
  },
};
</script>

<style lang="scss" scoped>
.point {
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
}
.point-box {
  width: 90%;
  margin: 0 auto;
  &__header {
    background-color: #eaeaea;
    border: 0.2rem solid #cccccc;
    font-size: 1.4rem;
    font-weight: bold;
  }
  &__content {
    border: 0.2rem solid #cccccc;
  }
  &__footer {
    background-color: #eaeaea;
    height: 4rem;
    border: 0.2rem solid #cccccc;
  }
}
.point-list {
  display: flex;
  align-content: center;
  border-bottom: 0.2rem solid #cccccc;
  &__date {
    width: 22%;
    padding: 1.2rem 0 1.2rem 0.9rem;
    border-right: 0.2rem solid #cccccc;
  }
  &__number {
    width: 52%;
    padding: 1.2rem 0 1.2rem 0.9rem;
    border-right: 0.2rem solid #cccccc;
  }
  &__get {
    width: 13%;
    padding: 1.2rem 0 1.2rem 0.9rem;
    border-right: 0.2rem solid #cccccc;
  }
  &__use {
    width: 13%;
    padding: 1.2rem 0 1.2rem 0.9rem;
  }
}
</style>
